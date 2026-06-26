<?php
/**
 * CleVista Group Limited - Main Landing Page (Sotheby's 100% Layout Replication)
 * Features "Nothing Compares" hero, single-row search bar with advanced filter dropdown,
 * featured properties grid, 6-lifestyle curations, brand statistics, and magazine articles.
 */
include_once 'includes/header.php';

// Fetch Featured Properties (latest 3) from database or Redis cache
require_once __DIR__ . '/includes/redis.php';

$featured_properties = [];
$cached_properties = redis_get('featured_properties');
$cache_hit = false;

if ($cached_properties) {
    $featured_properties = json_decode($cached_properties, true);
    $cache_hit = true;
} else {
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM properties ORDER BY id DESC LIMIT 6");
            $featured_properties = $stmt->fetchAll();
        } catch (PDOException $e) {
            // Table not created yet, fall back to mock data
        }
    }
}

// Fallback Mock Data for Featured Properties if DB/Cache is empty
if (empty($featured_properties)) {
    $featured_properties = [
        [
            'id' => 101,
            'title' => 'Galu Beachfront Acres',
            'type' => 'Land',
            'status' => 'For Sale',
            'price' => 'KSh 45,000,000',
            'location' => 'Galu Beach, Diani',
            'description_en' => 'Prime 2-acre beachfront parcel in Galu, Diani. Ideal for commercial resort or luxury private holiday villas. Clear title, sandy shore, mature baobab trees.',
            'features' => 'Beachfront, 2 Acres, Sandy Shore, Ocean Access',
            'image_url' => 'beachfront_land.png'
        ],
        [
            'id' => 102,
            'title' => 'Bahari Ocean Breeze Villa',
            'type' => 'Property',
            'status' => 'For Sale',
            'price' => 'KSh 28,000,000',
            'location' => 'Diani Beach Road',
            'description_en' => 'Exquisite 4-bedroom Swahili-style modern villa with infinity pool, lush tropical gardens, and rooftop terrace. Secure gated community, 5 minutes walk to the beach.',
            'features' => 'Pool, 4 Bedrooms, Rooftop Terrace, Swahili Design',
            'image_url' => 'swahili_luxury_villa.png'
        ],
        [
            'id' => 103,
            'title' => 'Kikambala Heights Residential',
            'type' => 'Development',
            'status' => 'Invested',
            'price' => 'KSh 12,500,000 (Starting)',
            'location' => 'Kikambala, Coastal Highway',
            'description_en' => 'An emerging gated estate featuring modern 2 & 3 bedroom luxury apartments with panoramic sea views, solar power integration, and high-speed internet.',
            'features' => 'Ocean View, Solar Power, Security, Gym & Pool',
            'image_url' => 'modern_heights_residence.png'
        ]
    ];
}

// Save to cache if we had a cache miss and have properties
if (!$cache_hit && !empty($featured_properties)) {
    redis_set('featured_properties', json_encode($featured_properties), 300); // cache for 5 minutes
}
?>

<!-- 1. Hero Split Section: Search Panel (Navy Block) & Visual Carousel -->
<section class="hero-split">
    <!-- A. Dark Navy Search Panel (directly below header) -->
    <div class="hero-search-panel">
        <div class="container search-panel-container">
            <div class="search-panel-left">
                <h1 data-i18n="hero_title">Find a home that suits your lifestyle.</h1>
            </div>
            
            <div class="search-panel-right">
                <div class="search-console-wrapper">
                    <!-- Text-only tabs to match screenshot exactly -->
                    <ul class="search-tabs">
                        <li class="search-tab-item active" data-search-tab="buy" data-i18n="nav_buy">BUY</li>
                        <li class="search-tab-item" data-search-tab="rent" data-i18n="nav_rent">RENT</li>
                        <li class="search-tab-item" data-search-tab="developments" data-i18n="nav_developments">DEVELOPMENTS</li>
                        <li class="search-tab-item" data-search-tab="sell" data-i18n="nav_sell">SELL</li>
                        <li class="search-tab-item" data-search-tab="agents" data-i18n="nav_agents">AGENTS</li>
                    </ul>
                    
                    <!-- Unified Transparent Bottom-Border Search Form -->
                    <form action="estates.php" method="GET" id="unified-search-form">
                        <!-- Hidden inputs modified dynamically via JS -->
                        <input type="hidden" name="type" id="search-param-type" value="all">
                        <input type="hidden" name="status" id="search-param-status" value="For Sale">
                        <input type="hidden" name="subject" id="search-param-subject" value="">
                        
                        <div class="search-input-line">
                            <i class="fa-solid fa-magnifying-glass search-line-icon"></i>
                            <input type="text" name="search_query" id="search-main-input" class="search-transparent-input" placeholder="Country, City, Address, Postal Code or ID" data-i18n="search_placeholder_buy">
                            <button type="submit" class="search-submit-arrow-btn"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- B. Visual Banner (looping video or high-res image of Diani beach) -->
    <div class="hero-visual-carousel" id="hero-carousel">
        <!-- Slide 1: Galu Beachfront Land -->
        <div class="carousel-slide active" data-title="Galu Beach, Diani" data-details="Kenya &bull; KSh 45,000,000" data-link="estates.php?search_query=Galu">
            <video autoplay loop muted playsinline class="hero-video-bg" poster="uploads/diani_beach_hero.png">
                <source src="https://player.vimeo.com/external/371433846.sd.mp4?s=236da2f3c02227d8787c382976f2b4e79b75560b&profile_id=165&oauth2_token_id=57447761" type="video/mp4">
            </video>
        </div>
        
        <!-- Slide 2: Swahili Luxury Villa -->
        <div class="carousel-slide" data-title="Bahari Ocean Breeze Villa" data-details="Kenya &bull; KSh 28,000,000" data-link="estates.php?search_query=Bahari">
            <video loop muted playsinline class="hero-video-bg" poster="uploads/swahili_luxury_villa.png">
                <source src="https://player.vimeo.com/external/467657929.sd.mp4?s=82c2f703e390c52bb888981f3c3a936495b4526d&profile_id=165&oauth2_token_id=57447761" type="video/mp4">
            </video>
        </div>

        <!-- Slide 3: Modern Heights Residence -->
        <div class="carousel-slide" data-title="Kikambala Heights Residential" data-details="Kenya &bull; KSh 12,500,000 (Starting)" data-link="estates.php?search_query=Kikambala">
            <video loop muted playsinline class="hero-video-bg" poster="uploads/modern_heights_residence.png">
                <source src="https://player.vimeo.com/external/510850877.sd.mp4?s=d0059e8f498c47fcf64560bd7fb8a48b7891bfd6&profile_id=165&oauth2_token_id=57447761" type="video/mp4">
            </video>
        </div>

        <div class="hero-video-overlay"></div>
        
        <!-- Bottom-Left Property Overlay Card (Updated Dynamically via JS) -->
        <div class="container hero-overlay-card-container">
            <div class="hero-overlay-card" id="hero-overlay-card">
                <h2 class="hero-overlay-title" id="carousel-title">Galu Beach, Diani</h2>
                <div class="hero-overlay-details" id="carousel-details">Kenya &bull; KSh 45,000,000</div>
                <a href="estates.php?search_query=Galu" class="hero-overlay-link" id="carousel-link">SEE DETAILS <i class="fa-solid fa-arrow-right" style="font-size:0.75rem; margin-left:4px;"></i></a>
            </div>
        </div>

        <!-- Carousel Indicators (Dots in bottom right to match Sotheby's exactly) -->
        <div class="carousel-indicators">
            <span class="indicator-dot active" data-slide-index="0"></span>
            <span class="indicator-dot" data-slide-index="1"></span>
            <span class="indicator-dot" data-slide-index="2"></span>
        </div>
    </div>
</section>

<!-- 2. Featured Listings (Sotheby's Main Grid Layout) -->
<section class="section-padding" style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-light);">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="nav_estates">Estates Portfolio</span>
            <h2>Featured Properties</h2>
        </div>
        
        <div class="listings-grid">
            <?php foreach ($featured_properties as $prop): ?>
                <?php
                // Image resolutions
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
                    }
                }
                ?>
                <div class="listing-card" onclick="window.location.href='estates.php?search_query=<?php echo urlencode($prop['title']); ?>'">
                    <div class="listing-img">
                        <img src="<?php echo $image_src; ?>" alt="<?php echo htmlspecialchars($prop['title']); ?>">
                        <span class="listing-tag badge badge-gold"><?php echo $prop['type']; ?></span>
                    </div>
                    <div class="listing-body">
                        <h3><?php echo htmlspecialchars($prop['title']); ?></h3>
                        <div class="listing-location-label">
                            <i class="fa-solid fa-location-dot" style="color: var(--accent-gold);"></i> 
                            <span><?php echo htmlspecialchars($prop['location']); ?></span>
                        </div>
                        <div class="listing-desc-block">
                            <p data-lang-content="en" style="display:block;"><?php echo htmlspecialchars(substr($prop['description_en'], 0, 110)) . '...'; ?></p>
                            <p data-lang-content="sw" style="display:none;"><?php echo htmlspecialchars(substr(!empty($prop['description_sw']) ? $prop['description_sw'] : $prop['description_en'], 0, 110)) . '...'; ?></p>
                            <p data-lang-content="de" style="display:none;"><?php echo htmlspecialchars(substr(!empty($prop['description_de']) ? $prop['description_de'] : $prop['description_en'], 0, 110)) . '...'; ?></p>
                            <p data-lang-content="it" style="display:none;"><?php echo htmlspecialchars(substr(!empty($prop['description_it']) ? $prop['description_it'] : $prop['description_en'], 0, 110)) . '...'; ?></p>
                            <p data-lang-content="fr" style="display:none;"><?php echo htmlspecialchars(substr(!empty($prop['description_fr']) ? $prop['description_fr'] : $prop['description_en'], 0, 110)) . '...'; ?></p>
                            <p data-lang-content="pl" style="display:none;"><?php echo htmlspecialchars(substr(!empty($prop['description_pl']) ? $prop['description_pl'] : $prop['description_en'], 0, 110)) . '...'; ?></p>
                        </div>
                        <div class="listing-divider"></div>
                        <div class="listing-bottom-console">
                            <div class="listing-price-label"><?php echo htmlspecialchars($prop['price']); ?></div>
                            <span class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.75rem;" data-i18n="btn_view_details">Details</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 3. Search by Lifestyle Grid (6 Curated Lifestyles) -->
<section class="section-padding" id="lifestyles" style="background-color: var(--bg-light); border-bottom: 1px solid var(--border-light);">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="focus_title">Curations</span>
            <h2>Search by Lifestyle</h2>
        </div>
        
        <div class="lifestyle-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="lifestyle-card" onclick="window.location.href='estates.php?search_query=Beachfront'">
                <img src="uploads/diani_beach_hero.png" alt="Beachfront" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Waterfront / Beachfront</h3>
                    <span>Living on pristine sand</span>
                </div>
            </div>
            
            <div class="lifestyle-card" onclick="window.location.href='hospitality.php'">
                <img src="uploads/swahili_luxury_villa.png" alt="Golf" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Golf & Leisure</h3>
                    <span>Exclusive luxury stays</span>
                </div>
            </div>
            
            <div class="lifestyle-card" onclick="window.location.href='estates.php?type=Development'">
                <img src="uploads/modern_heights_residence.png" alt="Developments" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Gated Developments</h3>
                    <span>Planned secure communities</span>
                </div>
            </div>
            
            <div class="lifestyle-card" onclick="window.location.href='estates.php?type=Land'">
                <img src="uploads/beachfront_land.png" alt="Plots" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Acreage & Plots</h3>
                    <span>Strategic coastal parcels</span>
                </div>
            </div>
            
            <div class="lifestyle-card" onclick="window.location.href='hospitality.php?search_query=Villa'">
                <img src="uploads/swahili_luxury_villa.png" alt="Villas" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Swahili Luxury Villas</h3>
                    <span>Coastal architectural beauty</span>
                </div>
            </div>
            
            <div class="lifestyle-card" onclick="window.location.href='care.php'">
                <img src="uploads/property_care_site.png" alt="Swahili" class="lifestyle-img">
                <div class="lifestyle-overlay">
                    <h3>Historic Lifestyles</h3>
                    <span>Professional property preservation</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Find an Expert (Sales Associate panel) -->
<section class="section-padding" style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-light);">
    <div class="container" style="max-width: 900px;">
        <div class="cta-banner" style="border-radius: 0; background: var(--bg-light); border: 1px solid var(--border-gold); padding: 50px; text-align: left;">
            <div class="why-grid" style="grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: center;">
                <div>
                    <span class="section-subtitle-label" data-i18n="nav_contact">Local Experts</span>
                    <h3 style="font-family:'Playfair Display'; font-size:2.2rem; margin-bottom:12px; color: var(--sir-blue);">Connect with a Local Agent</h3>
                    <p style="font-size:0.9rem; margin-bottom:0;" data-i18n="why_3_desc">Our sales representatives possess a deep understanding of Diani, Ukunda, and coastal properties, ensuring client transparency and satisfaction.</p>
                </div>
                <div style="text-align: right;">
                    <a href="contact.php" class="btn btn-primary" data-i18n="nav_contact" style="width: 100%;">Contact Expert</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Statistics Panel (Editorial Brand Stats) -->
<section class="brand-stats-section" id="brand">
    <div class="container brand-stats-grid">
        <div>
            <div class="brand-stat-number">KSh 1.2B+</div>
            <div class="brand-stat-label">Property Value Managed</div>
        </div>
        <div>
            <div class="brand-stat-number">100+</div>
            <div class="brand-stat-label">Properties Maintained</div>
        </div>
        <div>
            <div class="brand-stat-number">5,000+</div>
            <div class="brand-stat-label">Guest Nights Booked</div>
        </div>
        <div>
            <div class="brand-stat-number">10+ Yrs</div>
            <div class="brand-stat-label">Kenyan Coast Service</div>
        </div>
    </div>
</section>

<!-- 6. CleVista Luxury Magazine (Editorial grid) -->
<section class="section-padding" id="magazine" style="background-color: var(--bg-white);">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle-label" data-i18n="nav_portal">Publications</span>
            <h2>CleVista Editorial Magazine</h2>
        </div>
        
        <div class="listings-grid">
            <a href="magazine.php?id=diani-living" class="listing-card" style="text-decoration: none;">
                <div class="listing-img" style="height:200px;">
                    <img src="uploads/diani_beach_hero.png" alt="Diani Living">
                </div>
                <div class="listing-body" style="padding:16px 0;">
                    <span style="font-family:'Inter'; font-size:0.7rem; text-transform:uppercase; color:var(--accent-gold); letter-spacing:1px; margin-bottom:8px; display:block;">Lifestyle</span>
                    <h4 style="font-family:'Playfair Display'; font-size:1.2rem; color: var(--sir-blue); margin-bottom:8px;">Diani Living: Kenya's White Sand Haven</h4>
                    <p style="font-size:0.85rem; color: var(--sir-text-grey);">Discover why international investors are choosing Galu and Diani central beach road for luxury developments.</p>
                </div>
            </a>
            
            <a href="magazine.php?id=diaspora-protection" class="listing-card" style="text-decoration: none;">
                <div class="listing-img" style="height:200px;">
                    <img src="uploads/property_care_site.png" alt="Asset Protection">
                </div>
                <div class="listing-body" style="padding:16px 0;">
                    <span style="font-family:'Inter'; font-size:0.7rem; text-transform:uppercase; color:var(--accent-gold); letter-spacing:1px; margin-bottom:8px; display:block;">Property Care</span>
                    <h4 style="font-family:'Playfair Display'; font-size:1.2rem; color: var(--sir-blue); margin-bottom:8px;">Diaspora Asset Protection: Preserving Legacies</h4>
                    <p style="font-size:0.85rem; color: var(--sir-text-grey);">How CleVista Care provides property owners abroad with real-time cleaning, landscaping, and inspections logs.</p>
                </div>
            </a>
            
            <a href="magazine.php?id=swahili-architecture" class="listing-card" style="text-decoration: none;">
                <div class="listing-img" style="height:200px;">
                    <img src="uploads/swahili_luxury_villa.png" alt="Architecture">
                </div>
                <div class="listing-body" style="padding:16px 0;">
                    <span style="font-family:'Inter'; font-size:0.7rem; text-transform:uppercase; color:var(--accent-gold); letter-spacing:1px; margin-bottom:8px; display:block;">Architecture</span>
                    <h4 style="font-family:'Playfair Display'; font-size:1.2rem; color: var(--sir-blue); margin-bottom:8px;">Coastal Swahili Modern Architecture</h4>
                    <p style="font-size:0.85rem; color: var(--sir-text-grey);">Exploring architectural integration blending traditional Swahili coral limestone with modern glass villas.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Client scripts to toggle search tabs dynamically for the unified console -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabItems = document.querySelectorAll('.search-tab-item');
    const searchForm = document.getElementById('unified-search-form');
    const mainInput = document.getElementById('search-main-input');
    const paramType = document.getElementById('search-param-type');
    const paramStatus = document.getElementById('search-param-status');
    const paramSubject = document.getElementById('search-param-subject');
    
    if (tabItems.length > 0 && searchForm && mainInput) {
        tabItems.forEach(item => {
            item.addEventListener('click', () => {
                // Update active tab highlight style
                tabItems.forEach(t => t.classList.remove('active'));
                item.classList.add('active');
                
                const tab = item.getAttribute('data-search-tab');
                const lang = localStorage.getItem('clevista_lang') || 'en';
                const dict = (typeof translationData !== 'undefined' && translationData[lang]) ? translationData[lang] : {};
                
                // Reset hidden fields
                paramType.value = 'all';
                paramStatus.value = 'For Sale';
                paramSubject.value = '';
                
                if (tab === 'buy') {
                    searchForm.action = 'estates.php';
                    mainInput.setAttribute('data-i18n', 'search_placeholder_buy');
                    mainInput.placeholder = dict['search_placeholder_buy'] || 'Country, City, Address, Postal Code or ID';
                    paramStatus.value = 'For Sale';
                } else if (tab === 'rent') {
                    searchForm.action = 'hospitality.php';
                    mainInput.setAttribute('data-i18n', 'search_placeholder_rent');
                    mainInput.placeholder = dict['search_placeholder_rent'] || 'Search stays, holiday rentals...';
                    paramStatus.value = 'Rent';
                } else if (tab === 'developments') {
                    searchForm.action = 'estates.php';
                    mainInput.setAttribute('data-i18n', 'search_placeholder_developments');
                    mainInput.placeholder = dict['search_placeholder_developments'] || 'Search gated communities, coastal parcels...';
                    paramType.value = 'Development';
                } else if (tab === 'sell') {
                    searchForm.action = 'contact.php';
                    mainInput.setAttribute('data-i18n', 'search_placeholder_sell');
                    mainInput.placeholder = dict['search_placeholder_sell'] || 'Property type, size, location...';
                    paramSubject.value = 'Listing My Property';
                } else if (tab === 'agents') {
                    searchForm.action = 'contact.php';
                    mainInput.setAttribute('data-i18n', 'search_placeholder_agents');
                    mainInput.placeholder = dict['search_placeholder_agents'] || 'Contact local agent by name or location...';
                    paramSubject.value = 'Agent consultation';
                }
            });
        });
    }
});
</script>

<?php
include_once 'includes/footer.php';
?>
