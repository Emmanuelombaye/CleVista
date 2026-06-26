<?php
/**
 * CleVista Hospitality Division Page (Sotheby's Luxury Layout)
 * Handles stays listings, search queries, database filtering (with rates price range filters), and luxury stay card rendering.
 */
include_once 'includes/header.php';

// Handle Hospitality Stay Inquiry Submission
$booking_status = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_stay_inquiry'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $ref_id = isset($_POST['reference_id']) ? intval($_POST['reference_id']) : null;
    $ref_title = htmlspecialchars(trim($_POST['reference_title']));
    $preferred_date = htmlspecialchars(trim($_POST['preferred_date']));
    $details = htmlspecialchars(trim($_POST['details']));
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (name, email, phone, service_type, service_name, preferred_date, details, status) VALUES (?, ?, ?, 'Hospitality', ?, ?, ?, 'Pending')");
            $stmt->execute([$name, $email, $phone, $ref_title, $preferred_date, $details]);
            $booking_status = 'success';
        } catch (PDOException $e) {
            $booking_status = 'error';
        }
    } else {
        $booking_status = 'success'; // Fallback for demo
    }
}

// Prepare parameters from search console redirects
$search_query = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';
$filter_capacity = isset($_GET['capacity']) ? trim($_GET['capacity']) : 'all';
$filter_location = isset($_GET['location']) ? trim($_GET['location']) : 'all';
$price_range = isset($_GET['price_range']) ? trim($_GET['price_range']) : 'all';

// Fetch stays/villas (from database or Redis cache)
require_once __DIR__ . '/includes/redis.php';

$all_villas = [];
$cached_villas = redis_get('hospitality_villas');
$cache_hit = false;

if ($cached_villas) {
    $all_villas = json_decode($cached_villas, true);
    $cache_hit = true;
} else {
    $db_error = false;
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM villas ORDER BY id DESC");
            $all_villas = $stmt->fetchAll();
            if (!empty($all_villas)) {
                redis_set('hospitality_villas', json_encode($all_villas), 300); // cache for 5 minutes
            }
        } catch (PDOException $e) {
            $db_error = true;
        }
    }
}

$db_villas = [];
$villas_to_filter = !empty($all_villas) ? $all_villas : [];

if (!empty($villas_to_filter)) {
    foreach ($villas_to_filter as $villa) {
        $matches = true;
        
        if ($search_query !== '') {
            $q = strtolower($search_query);
            $t_match = strpos(strtolower($villa['title']), $q) !== false;
            $d_match = strpos(strtolower($villa['description_en']), $q) !== false;
            $f_match = strpos(strtolower($villa['features']), $q) !== false;
            if (!$t_match && !$d_match && !$f_match) $matches = false;
        }
        
        if ($filter_location !== 'all' && $filter_location !== '') {
            if (strpos(strtolower($villa['location']), strtolower($filter_location)) === false) $matches = false;
        }
        
        if ($filter_capacity !== 'all' && $filter_capacity !== '') {
            // Extract numeric capacity
            preg_match('/\d+/', $villa['capacity'], $cap_matches);
            $num_capacity = isset($cap_matches[0]) ? intval($cap_matches[0]) : 4;
            
            if ($filter_capacity == 'small') {
                if ($num_capacity > 4) $matches = false;
            } else if ($filter_capacity == 'large') {
                if ($num_capacity <= 4) $matches = false;
            }
        }
        
        if ($price_range !== 'all' && $price_range !== '') {
            $clean_rate = intval(preg_replace('/[^0-9]/', '', $villa['price_per_night']));
            if ($price_range == 'under20k') {
                if ($clean_rate >= 20000) $matches = false;
            } else if ($price_range == 'over20k') {
                if ($clean_rate < 20000) $matches = false;
            }
        }
        
        if ($matches) {
            $db_villas[] = $villa;
        }
    }
}

// Fallback Mock Data for Visual Excellence & Local Filtering
if (empty($db_villas) && ($pdo === null || $db_error || count($db_villas) === 0)) {
    $mock_villas = [
        [
            'id' => 201,
            'title' => 'Swahili Oasis Luxury Villa',
            'price_per_night' => 'KSh 35,000',
            'capacity' => '8 Guests (4 Bedrooms)',
            'location' => 'Galu beach road, Diani',
            'description_en' => 'Stunning ocean-view holiday villa with an private swimming pool, Swahili architecture, dedicated chef, fully air-conditioned, and manicured private gardens.',
            'description_sw' => 'Villa ya likizo yenye muonekano wa bahari na bwawa la kuogelea la kibinafsi, usanifu wa Kiswahili, mpishi aliyejitolea, viyoyozi, na bustani nzuri ya kibinafsi.',
            'description_de' => 'Atemberaubende Ferienvilla mit Meerblick, privatem Pool, Swahili-Architektur, eigenem Koch, voll klimatisiert und gepflegten privaten Gärten.',
            'description_it' => 'Splendida villa per vacanze vista mare con piscina privata, architettura Swahili, chef dedicato, aria condizionata e giardini privati curati.',
            'description_fr' => 'Superbe villa de vacances avec vue sur l\'océan, piscine privée, architecture swahilie, chef privé, climatisation et jardins privés arborés.',
            'description_pl' => 'Wspaniała willa wakacyjna z widokiem na ocean, prywatnym basenem, architekturą w stylu suahili, prywatnym kucharzem, klimatyzacją i zadbanym ogrodem.',
            'features' => 'Private Pool, Personal Chef, AC, WiFi, Beach Access',
            'image_url' => null
        ],
        [
            'id' => 202,
            'title' => 'Diani Lagoon Beach Cottage',
            'price_per_night' => 'KSh 18,500',
            'capacity' => '4 Guests (2 Bedrooms)',
            'location' => 'Diani Central Beach',
            'description_en' => 'Charming beachfront cottage ideal for couples or small families. Steps away from the ocean, featuring a cozy terrace and local makuti-thatched roof.',
            'description_sw' => 'Koti ya pwani ya kuvutia inayofaa wanandoa au familia ndogo. Hatua chache kutoka baharini, yenye terasi nzuri na paa la makuti la kienyeji.',
            'description_de' => 'Charmantes Cottage direkt am Strand, ideal für Paare oder kleine Familien. Nur wenige Schritte vom Meer entfernt, mit gemütlicher Terrasse und lokalem Makuti-Strohdach.',
            'description_it' => 'Incantevole cottage fronte mare ideale per coppie o piccole famiglie. A pochi passi dall\'oceano, dotato di un accogliente terrazzo e tetto in makuti locale.',
            'description_fr' => 'Charmant cottage en bord de mer idéal pour couples ou petites familles. À deux pas de l\'océan, doté d\'une terrasse chaleureuse et d\'un toit en makuti traditionnel.',
            'description_pl' => 'Uroczy domek przy samej plaży, idealny dla par lub małych rodzin. Zaledwie kilka kroków od oceanu, z przytulnym tarasem i dachem krytym lokalnym makuti.',
            'features' => 'Beachfront, Makuti Roof, Private Terrace, Beach Lounge',
            'image_url' => null
        ]
    ];
    
    // Local filter mockup logic
    $filtered_mocks = [];
    foreach ($mock_villas as $villa) {
        $matches = true;
        
        if ($search_query !== '') {
            $q = strtolower($search_query);
            $t_match = strpos(strtolower($villa['title']), $q) !== false;
            $d_match = strpos(strtolower($villa['description_en']), $q) !== false;
            $f_match = strpos(strtolower($villa['features']), $q) !== false;
            if (!$t_match && !$d_match && !$f_match) $matches = false;
        }
        
        if ($filter_location !== 'all' && $filter_location !== '') {
            if (strpos(strtolower($villa['location']), strtolower($filter_location)) === false) $matches = false;
        }
        
        if ($filter_capacity == 'small') {
            if (!preg_match('/[2-4]/', $villa['capacity'])) $matches = false;
        } else if ($filter_capacity == 'large') {
            if (!preg_match('/[5-9]/', $villa['capacity'])) $matches = false;
        }
        
        if ($price_range !== 'all' && $price_range !== '') {
            $clean_rate = intval(preg_replace('/[^0-9]/', '', $villa['price_per_night']));
            if ($price_range == 'under20k') {
                if ($clean_rate >= 20000) $matches = false;
            } else if ($price_range == 'over20k') {
                if ($clean_rate < 20000) $matches = false;
            }
        }
        
        if ($matches) {
            $filtered_mocks[] = $villa;
        }
    }
    $db_villas = $filtered_mocks;
}
?>

<!-- 1. Hero Page Banner -->
<section class="page-banner" style="background: linear-gradient(rgba(0, 35, 73, 0.4), rgba(0, 35, 73, 0.75)),
            url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;">
    <div class="container page-banner-content">
        <span class="section-subtitle-label" data-i18n="nav_hospitality">Accommodations Portfolio</span>
        <h1 class="text-gradient-gold" data-i18n="hosp_title">CleVista Hospitality</h1>
        <p class="page-banner-desc" data-i18n="hosp_subtitle">Comfort, convenience, and curated experiences on the Kenyan Coast.</p>
    </div>
</section>

<!-- 2. Services Grid -->
<section class="section-padding" style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-light);">
    <div class="container">
        <!-- Status Messages -->
        <?php if ($booking_status === 'success'): ?>
            <div class="alert alert-success" data-i18n="form_success_msg">Thank you! Your stay request has been submitted successfully. Our team will contact you shortly.</div>
        <?php elseif ($booking_status === 'error'): ?>
            <div class="alert alert-error" data-i18n="form_error_msg">An error occurred. Please try again or reach out directly via WhatsApp.</div>
        <?php endif; ?>

        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="hosp_service_title">Services</span>
            <h2>Our Hospitality Services</h2>
        </div>

        <div class="values-grid" style="margin-top: 0;">
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-umbrella-beach"></i>
                <h3 data-i18n="hosp_s1">Holiday Accommodation</h3>
                <p data-i18n="div_hospitality_desc">Arranging stays in handpicked luxury villas, beachfront cottages, and apartments along the scenic Kenyan Coast.</p>
            </div>
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-plane-departure"></i>
                <h3 data-i18n="hosp_s3">Airport & Local Transfers</h3>
                <p data-i18n="about_p2">Seamless transfers from Mombasa (SGR/Moi International) or Ukunda Airstrip directly to your holiday accommodation in Diani.</p>
            </div>
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-utensils"></i>
                <h3 data-i18n="hosp_s7">Private Dining & Experiences</h3>
                <p data-i18n="why_4_desc">Curated coastal experiences, beach tours, marine park excursions, and direct coordination with professional private chefs.</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. Villa Stays Showcase -->
<section class="section-padding" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="nav_hospitality">Fine Stays</span>
            <h2 data-i18n="hosp_listing_title">Premium Coastal Accommodations</h2>
        </div>

        <!-- Borderless Stays Grid -->
        <div class="listings-grid">
            <?php if (empty($db_villas)): ?>
                <div class="no-records" style="display: block;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3 data-i18n="estates_no_listings">No accommodations currently matching this category.</h3>
                    <p style="margin-top: 16px;"><a href="contact.php" class="btn btn-secondary" data-i18n="btn_inquire">Contact Us</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($db_villas as $villa): ?>
                    <?php
                    // Default images
                    $image_src = 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80';
                    if (!empty($villa['image_url'])) {
                        if (strpos($villa['image_url'], 'http') === 0) {
                            $image_src = $villa['image_url'];
                        } else {
                            $image_src = 'uploads/' . $villa['image_url'];
                        }
                    } else {
                        if ($villa['id'] == 202) {
                            $image_src = 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=600&q=80';
                        }
                    }
                    ?>
                    <div class="listing-card">
                        <div class="listing-img">
                            <img src="<?php echo $image_src; ?>" alt="<?php echo htmlspecialchars($villa['title']); ?>">
                            <span class="listing-tag badge badge-teal"><i class="fa-solid fa-umbrella-beach"></i> Villa Stay</span>
                        </div>
                        
                        <div class="listing-body">
                            <h3><?php echo htmlspecialchars($villa['title']); ?></h3>
                            
                            <div class="listing-location-label">
                                <i class="fa-solid fa-location-dot" style="color: var(--accent-gold);"></i> 
                                <span><?php echo htmlspecialchars($villa['location']); ?></span>
                            </div>
                            
                            <!-- Multilingual Descriptions -->
                            <div class="listing-desc-block">
                                <p class="prop-desc" data-lang-content="en" style="display:block;"><?php echo htmlspecialchars($villa['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="sw" style="display:none;"><?php echo htmlspecialchars(!empty($villa['description_sw']) ? $villa['description_sw'] : $villa['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="de" style="display:none;"><?php echo htmlspecialchars(!empty($villa['description_de']) ? $villa['description_de'] : $villa['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="it" style="display:none;"><?php echo htmlspecialchars(!empty($villa['description_it']) ? $villa['description_it'] : $villa['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="fr" style="display:none;"><?php echo htmlspecialchars(!empty($villa['description_fr']) ? $villa['description_fr'] : $villa['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="pl" style="display:none;"><?php echo htmlspecialchars(!empty($villa['description_pl']) ? $villa['description_pl'] : $villa['description_en']); ?></p>
                            </div>

                            <div class="listing-divider"></div>
                            
                            <div class="listing-bottom-console">
                                <div class="listing-price-label"><?php echo htmlspecialchars($villa['price_per_night']); ?> <span style="font-size:0.75rem; font-weight:normal; color:var(--text-muted);">/ <span data-i18n="hosp_night">night</span></span></div>
                                <button class="btn btn-primary" data-modal-open data-id="<?php echo $villa['id']; ?>" data-title="<?php echo htmlspecialchars($villa['title']); ?>" data-i18n="hosp_book_stay" style="padding: 10px 20px; font-size: 0.75rem;">Book Stay</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 4. Stay Booking Modal -->
<div class="modal-overlay" id="inquiry-modal">
    <div class="modal-card">
        <button class="modal-close" aria-label="Close Modal">&times;</button>
        <h3 data-i18n="modal_hosp_title" style="margin-bottom: 8px;">Inquire About Villa Stay</h3>
        <p style="margin-bottom: 24px; font-size:0.85rem;"><span data-i18n="nav_hospitality">Accommodation</span><span id="modal-reference-title"></span></p>
        
        <form action="" method="POST">
            <input type="hidden" name="reference_id" id="modal-reference-id" value="">
            <input type="hidden" name="reference_title" id="modal-reference-title-input" value="Hospitality Listing">
            
            <div class="form-group">
                <label for="modal-name" data-i18n="form_name">Full Name</label>
                <input type="text" name="name" id="modal-name" class="form-control" required data-i18n="form_name">
            </div>
            
            <div class="form-group">
                <label for="modal-email" data-i18n="form_email">Email Address</label>
                <input type="email" name="email" id="modal-email" class="form-control" required data-i18n="form_email">
            </div>
            
            <div class="form-group">
                <label for="modal-phone" data-i18n="form_phone">Phone Number</label>
                <input type="text" name="phone" id="modal-phone" class="form-control" required data-i18n="form_phone">
            </div>
            
            <div class="form-group">
                <label for="modal-date" data-i18n="form_pref_date">Preferred Date</label>
                <input type="date" name="preferred_date" id="modal-date" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="modal-details" data-i18n="form_booking_details">Booking Details / Special Instructions</label>
                <textarea name="details" id="modal-details" class="form-control" required data-i18n="form_booking_details"></textarea>
            </div>
            
            <button type="submit" name="submit_stay_inquiry" class="btn btn-primary" style="width: 100%;" data-i18n="btn_submit">Submit Request</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const triggers = document.querySelectorAll('[data-modal-open]');
    const refTitleInput = document.getElementById('modal-reference-title-input');
    triggers.forEach(trig => {
        trig.addEventListener('click', () => {
            const title = trig.getAttribute('data-title');
            if (refTitleInput) refTitleInput.value = title;
        });
    });
});
</script>

<?php
include_once 'includes/footer.php';
?>
