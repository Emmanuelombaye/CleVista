<?php
/**
 * CleVista Estates Division Page (Sotheby's Luxury Layout)
 * Handles property searching, parameters filtering (with price range bounds), database parsing, and luxury card rendering.
 */
include_once 'includes/header.php';

// Handle Property Inquiry Submission
$message_status = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_property_inquiry'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $ref_id = isset($_POST['reference_id']) ? intval($_POST['reference_id']) : null;
    $ref_title = htmlspecialchars(trim($_POST['reference_title']));
    $details = htmlspecialchars(trim($_POST['details']));
    
    $subject = "Property Inquiry - " . $ref_title;
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, subject, message, division, reference_id) VALUES (?, ?, ?, ?, ?, 'Estates', ?)");
            $stmt->execute([$name, $email, $phone, $subject, $details, $ref_id]);
            $message_status = 'success';
        } catch (PDOException $e) {
            $message_status = 'error';
        }
    } else {
        $message_status = 'success'; // Fallback success for demo
    }
}

// Prepare parameters from search bar redirects
$search_query = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';
$filter_type = isset($_GET['type']) ? trim($_GET['type']) : 'all';
$filter_location = isset($_GET['location']) ? trim($_GET['location']) : 'all';
$price_range = isset($_GET['price_range']) ? trim($_GET['price_range']) : 'all';

// Fetch properties from database
$db_properties = [];
$db_error = false;

if ($pdo) {
    try {
        $where_clauses = [];
        $params = [];
        
        if ($search_query !== '') {
            $sq = '%' . $search_query . '%';
            $where_clauses[] = "(title LIKE ? OR description_en LIKE ? OR features LIKE ?)";
            $params[] = $sq; $params[] = $sq; $params[] = $sq;
        }
        
        if ($filter_type !== 'all' && $filter_type !== '') {
            $where_clauses[] = "type = ?";
            $params[] = $filter_type;
        }
        
        if ($filter_location !== 'all' && $filter_location !== '') {
            $where_clauses[] = "location LIKE ?";
            $params[] = '%' . $filter_location . '%';
        }
        
        // Note: For actual database records, we store price as varchar (like "KSh 45,000,000").
        // On production, it is recommended to store a numeric_price column for exact sql indexing.
        // For local demo, we fetch all and filter in PHP or query like constraints.
        $query_str = "SELECT * FROM properties";
        if (!empty($where_clauses)) {
            $query_str .= " WHERE " . implode(" AND ", $where_clauses);
        }
        $query_str .= " ORDER BY id DESC";
        
        $stmt = $pdo->prepare($query_str);
        $stmt->execute($params);
        $db_properties = $stmt->fetchAll();
        
        // Filter DB price ranges in PHP if set
        if ($price_range !== 'all' && $price_range !== '') {
            $filtered_db = [];
            foreach ($db_properties as $prop) {
                $clean_price = intval(preg_replace('/[^0-9]/', '', $prop['price']));
                $matches = true;
                if ($price_range == 'under15m') {
                    if ($clean_price >= 15000000) $matches = false;
                } else if ($price_range == '15m-30m') {
                    if ($clean_price < 15000000 || $clean_price > 30000000) $matches = false;
                } else if ($price_range == 'over30m') {
                    if ($clean_price <= 30000000) $matches = false;
                }
                if ($matches) $filtered_db[] = $prop;
            }
            $db_properties = $filtered_db;
        }
    } catch (PDOException $e) {
        $db_error = true;
    }
}

// Fallback Mock Data for Visual Excellence & Local Filtering
if (empty($db_properties) && ($pdo === null || $db_error || count($db_properties) === 0)) {
    $mock_properties = [
        [
            'id' => 101,
            'title' => 'Galu Beachfront Acres',
            'type' => 'Land',
            'status' => 'For Sale',
            'price' => 'KSh 45,000,000',
            'location' => 'Galu Beach, Diani',
            'description_en' => 'Prime 2-acre beachfront parcel in Galu, Diani. Ideal for commercial resort or luxury private holiday villas. Clear title, sandy shore, mature baobab trees.',
            'description_sw' => 'Eneo kuu la ekari 2 mbele ya bahari huko Galu, Diani. Ni bora kwa hoteli ya kibiashara au villa ya kifahari ya likizo ya kibinafsi. Hati safi, pwani ya mchanga, miti mikubwa ya mbuyu.',
            'description_de' => 'Erstklassiges 2 Hektar großes Strandgrundstück in Galu, Diani. Ideal für ein kommerzielles Resort oder luxuriöse private Ferienvillen. Sauberer Titel, Sandstrand, reife Affenbrotbäume.',
            'description_it' => 'Splendido terreno di 2 acri fronte mare a Galu, Diani. Ideale per resort commerciale o ville private di lusso. Titolo pulito, spiaggia sabbiosa, alberi di baobab maturi.',
            'description_fr' => 'Superbe parcelle de 2 acres en bord de mer à Galu, Diani. Idéal pour un complexe commercial ou des villas de vacances de luxe privées. Titre propre, plage de sable, baobabs matures.',
            'description_pl' => 'Doskonała 2-akrowa działka bezpośrednio przy plaży Galu w Diani. Idealna pod luksusowy kurort lub prywatne wille wakacyjne. Uregulowany stan prawny, piaszczysty brzeg, dojrzałe baobaby.',
            'features' => 'Beachfront, 2 Acres, Sandy Shore, Ocean Access',
            'image_url' => null
        ],
        [
            'id' => 102,
            'title' => 'Bahari Ocean Breeze Villa',
            'type' => 'Property',
            'status' => 'For Sale',
            'price' => 'KSh 28,000,000',
            'location' => 'Diani Beach Road',
            'description_en' => 'Exquisite 4-bedroom Swahili-style modern villa with infinity pool, lush tropical gardens, and rooftop terrace. Secure gated community, 5 minutes walk to the beach.',
            'description_sw' => 'Villa ya kipekee ya vyumba 4 ya mtindo wa Kiswahili yenye bwawa la kuogelea, bustani za kitropiki, na rotopu. Eneo salama lenye geti, dakika 5 kutembea hadi pwani.',
            'description_de' => 'Exquisite moderne Villa mit 4 Schlafzimmern im Swahili-Stil, Infinity-Pool, üppigen tropischen Gärten und Dachterrasse. Sichere Wohnanlage, 5 Gehminuten zum Strand.',
            'description_it' => 'Splendida villa moderna in stile Swahili con 4 camere da letto, piscina a sfioro, rigogliosi giardini tropicali e terrazza sul tetto. Complesso custodito, a 5 minuti a piedi dalla spiaggia.',
            'description_fr' => 'Superbe villa moderne de 4 chambres de style swahili avec piscine à débordement, jardins tropicaux luxuriants et toit-terrasse. Résidence fermée et sécurisée, à 5 minutes à pied de la plage.',
            'description_pl' => 'Wykwintna, nowoczesna willa w stylu suahili z 4 sypialniami, basenem typu infinity, bujnym ogrodem tropikalnym i tarasem na dachu. Strzeżone osiedle, 5 minut pieszo do plaży.',
            'features' => 'Pool, 4 Bedrooms, Rooftop Terrace, Swahili Design',
            'image_url' => null
        ],
        [
            'id' => 103,
            'title' => 'Kikambala Heights Residential',
            'type' => 'Development',
            'status' => 'Invested',
            'price' => 'KSh 12,500,000 (Starting)',
            'location' => 'Kikambala, Coastal Highway',
            'description_en' => 'An emerging gated estate featuring modern 2 & 3 bedroom luxury apartments with panoramic sea views, solar power integration, and high-speed internet.',
            'description_sw' => 'Eneo linalochipuka la makazi lenye vyumba vya kisasa vya kifahari vya vyumba 2 na 3 vilivyo na muonekano wa bahari, umeme wa jua, na mtandao wa kasi.',
            'description_de' => 'Eine im Bau befindliche Wohnanlage mit modernen Luxusapartments mit 2 und 3 Schlafzimmern, Panoramablick auf das Meer, Solarenergie und Highspeed-Internet.',
            'description_it' => 'Un complesso residenziale emergente con moderni appartamenti di lusso con 2 e 3 camere da letto con vista panoramica sul mare, energia solare integrata e internet ad alta velocità.',
            'description_fr' => 'Une copropriété résidentielle émergente proposant des appartements de luxe modernes de 2 et 3 chambres avec vue panoramique sur la mer, énergie solaire et internet haut débit.',
            'description_pl' => 'Nowo powstające luksusowe apartamenty z 2 i 3 sypialniami, z panoramicznym widokiem na morze, instalacją fotowoltaiczną i szybkim internetem.',
            'features' => 'Ocean View, Solar Power, Security, Gym & Pool',
            'image_url' => null
        ]
    ];
    
    // Filter Mock Data manually in PHP
    $filtered_mocks = [];
    foreach ($mock_properties as $prop) {
        $matches = true;
        
        if ($search_query !== '') {
            $q = strtolower($search_query);
            $t_match = strpos(strtolower($prop['title']), $q) !== false;
            $d_match = strpos(strtolower($prop['description_en']), $q) !== false;
            $f_match = strpos(strtolower($prop['features']), $q) !== false;
            if (!$t_match && !$d_match && !$f_match) $matches = false;
        }
        
        if ($filter_type !== 'all' && $filter_type !== '') {
            if ($prop['type'] !== $filter_type) $matches = false;
        }
        
        if ($filter_location !== 'all' && $filter_location !== '') {
            if (strpos(strtolower($prop['location']), strtolower($filter_location)) === false) $matches = false;
        }
        
        if ($price_range !== 'all' && $price_range !== '') {
            $clean_price = intval(preg_replace('/[^0-9]/', '', $prop['price']));
            if ($price_range == 'under15m') {
                if ($clean_price >= 15000000) $matches = false;
            } else if ($price_range == '15m-30m') {
                if ($clean_price < 15000000 || $clean_price > 30000000) $matches = false;
            } else if ($price_range == 'over30m') {
                if ($clean_price <= 30000000) $matches = false;
            }
        }
        
        if ($matches) {
            $filtered_mocks[] = $prop;
        }
    }
    $db_properties = $filtered_mocks;
}

// Calculate pagination metrics
$limit = 6;
$total_properties = count($db_properties);
$total_pages = max(1, ceil($total_properties / $limit));
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $limit;

// Slice the properties array to only show the current page's listings
$db_properties = array_slice($db_properties, $offset, $limit);
?>

<!-- 1. Hero Page Banner -->
<section class="page-banner" style="background: linear-gradient(rgba(0, 35, 73, 0.4), rgba(0, 35, 73, 0.75)),
            url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;">
    <div class="container page-banner-content">
        <span class="section-subtitle-label" data-i18n="nav_estates">Estates Portfolio</span>
        <h1 class="text-gradient-gold" data-i18n="estates_title">CleVista Estates</h1>
        <p class="page-banner-desc" data-i18n="estates_subtitle">Secure property investments creating long-term value.</p>
    </div>
</section>

<!-- 2. Services Grid -->
<section class="section-padding" style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-light);">
    <div class="container">
        <!-- Status Messages -->
        <?php if ($message_status === 'success'): ?>
            <div class="alert alert-success" data-i18n="form_success_msg">Thank you! Your inquiry has been submitted successfully. Our team will contact you shortly.</div>
        <?php elseif ($message_status === 'error'): ?>
            <div class="alert alert-error" data-i18n="form_error_msg">An error occurred. Please try again or reach out directly via WhatsApp.</div>
        <?php endif; ?>

        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="estates_service_title">Services</span>
            <h2>Our Real Estate Services</h2>
        </div>

        <div class="values-grid" style="margin-top: 0;">
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-map"></i>
                <h3 data-i18n="est_s1">Land acquisition and sales</h3>
                <p data-i18n="div_estates_desc">Identifying, marketing, and facilitating access to strategic property opportunities while supporting clients through every stage of ownership.</p>
            </div>
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-house-chimney-window"></i>
                <h3 data-i18n="est_s2">Residential & Commercial Sales</h3>
                <p data-i18n="about_p2">Helping individuals and businesses secure quality property investments that create long-term value and support their future aspirations.</p>
            </div>
            <div class="value-card" style="border-radius: 0; background: var(--bg-light); border-color: var(--border-light);">
                <i class="fa-solid fa-compass"></i>
                <h3 data-i18n="est_s4">Property Advisory & Consultancy</h3>
                <p data-i18n="why_4_desc">We focus on creating sustainable outcomes that support both immediate needs and future growth through strategic investment opportunities.</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. Property Catalogue -->
<section class="section-padding" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="nav_estates">Portfolios</span>
            <h2 data-i18n="estates_listing_title">Strategic Property Listings</h2>
        </div>

        <!-- Filter Buttons (Triggers JavaScript toggles) -->
        <div class="filter-container">
            <button class="filter-btn <?php echo ($filter_type == 'all') ? 'active' : ''; ?>" data-filter="all" data-i18n="estates_filter_all">All Properties</button>
            <button class="filter-btn <?php echo ($filter_type == 'Land') ? 'active' : ''; ?>" data-filter="Land" data-i18n="estates_filter_land">Land / Plots</button>
            <button class="filter-btn <?php echo ($filter_type == 'Property') ? 'active' : ''; ?>" data-filter="Property" data-i18n="estates_filter_property">Houses & Villas</button>
            <button class="filter-btn <?php echo ($filter_type == 'Development') ? 'active' : ''; ?>" data-filter="Development" data-i18n="estates_filter_development">Developments</button>
        </div>

        <!-- Borderless Listings Grid -->
        <div class="listings-grid">
            <?php if (empty($db_properties)): ?>
                <div class="no-records" style="display: block;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3 data-i18n="estates_no_listings">No properties currently matching this category.</h3>
                    <p style="margin-top: 16px;"><a href="contact.php" class="btn btn-secondary" data-i18n="btn_inquire">Contact Us</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($db_properties as $prop): ?>
                    <?php
                    // Set badges classes
                    $tag_class = 'badge-gold';
                    if ($prop['type'] == 'Property') $tag_class = 'badge-teal';
                    
                    // Default image choices
                    $image_src = 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80';
                    if (!empty($prop['image_url'])) {
                        if (strpos($prop['image_url'], 'http') === 0) {
                            $image_src = $prop['image_url'];
                        } else {
                            $image_src = 'uploads/' . $prop['image_url'];
                        }
                    } else {
                        if ($prop['type'] == 'Land') {
                            $image_src = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=600&q=80';
                        } else if ($prop['type'] == 'Development') {
                            $image_src = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80';
                        }
                    }
                    ?>
                    <div class="listing-card" data-type="<?php echo $prop['type']; ?>">
                        <div class="listing-img">
                            <img src="<?php echo $image_src; ?>" alt="<?php echo htmlspecialchars($prop['title']); ?>">
                            <span class="listing-tag badge <?php echo $tag_class; ?>"><?php echo $prop['type']; ?></span>
                        </div>
                        
                        <div class="listing-body">
                            <h3><?php echo htmlspecialchars($prop['title']); ?></h3>
                            
                            <div class="listing-location-label">
                                <i class="fa-solid fa-location-dot" style="color: var(--accent-gold);"></i> 
                                <span><?php echo htmlspecialchars($prop['location']); ?></span>
                            </div>
                            
                            <!-- Multilingual Description Blocks -->
                            <div class="listing-desc-block">
                                <p class="prop-desc" data-lang-content="en" style="display:block;"><?php echo htmlspecialchars($prop['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="sw" style="display:none;"><?php echo htmlspecialchars(!empty($prop['description_sw']) ? $prop['description_sw'] : $prop['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="de" style="display:none;"><?php echo htmlspecialchars(!empty($prop['description_de']) ? $prop['description_de'] : $prop['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="it" style="display:none;"><?php echo htmlspecialchars(!empty($prop['description_it']) ? $prop['description_it'] : $prop['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="fr" style="display:none;"><?php echo htmlspecialchars(!empty($prop['description_fr']) ? $prop['description_fr'] : $prop['description_en']); ?></p>
                                <p class="prop-desc" data-lang-content="pl" style="display:none;"><?php echo htmlspecialchars(!empty($prop['description_pl']) ? $prop['description_pl'] : $prop['description_en']); ?></p>
                            </div>

                            <div class="listing-divider"></div>
                            
                            <div class="listing-bottom-console">
                                <div class="listing-price-label"><?php echo htmlspecialchars($prop['price']); ?></div>
                                <button class="btn btn-primary" data-modal-open data-id="<?php echo $prop['id']; ?>" data-title="<?php echo htmlspecialchars($prop['title']); ?>" data-i18n="estates_request_callback" style="padding: 10px 20px; font-size: 0.75rem;">Inquire</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="no-records" style="display: none;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3 data-i18n="estates_no_listings">No properties currently matching this category.</h3>
                    <p style="margin-top: 16px;"><a href="contact.php" class="btn btn-secondary" data-i18n="btn_inquire">Contact Us</a></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Links -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination-wrapper" style="display: flex; justify-content: center; align-items: center; margin-top: 50px; gap: 8px;">
                <?php
                // Build query arguments for pagination links to preserve filters
                $query_args = $_GET;
                ?>
                
                <!-- Previous Button -->
                <?php if ($page > 1): ?>
                    <?php $query_args['page'] = $page - 1; ?>
                    <a href="?<?php echo http_build_query($query_args); ?>" class="pagination-link btn btn-secondary" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--border-light); font-size: 0.8rem; background: var(--bg-white); color: var(--text-dark); transition: all 0.25s ease;"><i class="fa-solid fa-chevron-left" style="font-size: 0.7rem;"></i></a>
                <?php else: ?>
                    <span class="pagination-link disabled" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--border-light); font-size: 0.8rem; background: var(--bg-light); color: var(--text-muted); opacity: 0.5; cursor: not-allowed;"><i class="fa-solid fa-chevron-left" style="font-size: 0.7rem;"></i></span>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                    <?php $query_args['page'] = $p; ?>
                    <?php if ($p == $page): ?>
                        <span class="pagination-link active" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--accent-gold); font-size: 0.8rem; background: var(--accent-gold); color: #fff; font-weight: 600;"><?php echo $p; ?></span>
                    <?php else: ?>
                        <a href="?<?php echo http_build_query($query_args); ?>" class="pagination-link" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--border-light); font-size: 0.8rem; background: var(--bg-white); color: var(--text-dark); text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-gold)'; this.style.color='var(--accent-gold)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.color='var(--text-dark)';"><?php echo $p; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <!-- Next Button -->
                <?php if ($page < $total_pages): ?>
                    <?php $query_args['page'] = $page + 1; ?>
                    <a href="?<?php echo http_build_query($query_args); ?>" class="pagination-link btn btn-secondary" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--border-light); font-size: 0.8rem; background: var(--bg-white); color: var(--text-dark); transition: all 0.25s ease;"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i></a>
                <?php else: ?>
                    <span class="pagination-link disabled" style="padding: 10px 18px; display: flex; align-items: center; justify-content: center; border-radius: 0; min-width: 44px; border: 1px solid var(--border-light); font-size: 0.8rem; background: var(--bg-light); color: var(--text-muted); opacity: 0.5; cursor: not-allowed;"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- 4. Callback Inquiry Modal -->
<div class="modal-overlay" id="inquiry-modal">
    <div class="modal-card">
        <button class="modal-close" aria-label="Close Modal">&times;</button>
        <h3 data-i18n="modal_estate_title" style="margin-bottom: 8px;">Inquire About Property</h3>
        <p style="margin-bottom: 24px; font-size:0.85rem;"><span data-i18n="nav_estates">Property Selected</span><span id="modal-reference-title"></span></p>
        
        <form action="" method="POST">
            <input type="hidden" name="reference_id" id="modal-reference-id" value="">
            <input type="hidden" name="reference_title" id="modal-reference-title-input" value="Estates Listing">
            
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
                <label for="modal-details" data-i18n="form_message">Message / Details</label>
                <textarea name="details" id="modal-details" class="form-control" required data-i18n="form_message"></textarea>
            </div>
            
            <button type="submit" name="submit_property_inquiry" class="btn btn-primary" style="width: 100%;" data-i18n="btn_submit">Submit Request</button>
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
