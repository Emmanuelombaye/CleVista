<?php
/**
 * CleVista Group Limited - Database Setup & Initializer
 * Automatically creates the database, table schema, and seeds a default admin user.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';

$setup_messages = [];
$setup_success = false;

// 1. Check/Create database if connections initially failed in db.php
if ($pdo === null) {
    try {
        // Attempt connection to the MySQL server without selecting the database
        $temp_pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        // Create database
        $temp_pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $setup_messages[] = "Database '" . DB_NAME . "' created successfully (or already existed).";
        
        // Reconnect to the database using the standard variable
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        $setup_messages[] = "Fatal Error creating database: " . $e->getMessage();
    }
} else {
    $setup_messages[] = "Connected to existing database '" . DB_NAME . "' successfully.";
}

// 2. Read and execute schema.sql if connection is active
if ($pdo) {
    try {
        $schema_file = __DIR__ . '/../schema.sql';
        if (file_exists($schema_file)) {
            $sql = file_get_contents($schema_file);
            
            // Execute schema commands
            $pdo->exec($sql);
            $setup_messages[] = "Database tables and schema generated successfully.";
            
            // 3. Seed default administrator account if none exists
            $stmt = $pdo->query("SELECT COUNT(*) FROM users");
            $user_count = $stmt->fetchColumn();
            
            if ($user_count == 0) {
                $default_username = 'admin';
                $default_password = 'adminpassword';
                $default_email = 'admin@clevistagroup.com';
                $hash = password_hash($default_password, PASSWORD_DEFAULT);
                
                $insert_stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
                $insert_stmt->execute([$default_username, $hash, $default_email]);
                
                $setup_messages[] = "Default administrator user seeded successfully:<br>
                                     <strong>Username:</strong> admin<br>
                                     <strong>Password:</strong> adminpassword<br>
                                     <em>(Please change this password after logging in)</em>";
            } else {
                $setup_messages[] = "Administrative users already exist in the database. Seed skipped.";
            }

            // 4. Seed 40 realistic properties if empty
            $stmt = $pdo->query("SELECT COUNT(*) FROM properties");
            $prop_count = $stmt->fetchColumn();
            
            if ($prop_count == 0) {
                $seeds = [];
                
                // A. Core Premium Hand-Crafted Properties (first 5)
                $seeds[] = [
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
                    'image_url' => 'beachfront_land.png'
                ];
                
                $seeds[] = [
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
                    'image_url' => 'swahili_luxury_villa.png'
                ];
                
                $seeds[] = [
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
                    'image_url' => 'modern_heights_residence.png'
                ];
                
                $seeds[] = [
                    'title' => 'Vipingo Ridge Golf Estate',
                    'type' => 'Development',
                    'status' => 'For Sale',
                    'price' => 'KSh 48,000,000',
                    'location' => 'Vipingo Ridge, Kilifi',
                    'description_en' => 'Premium golf villa at Vipingo Ridge. Enjoy access to the 18-hole championship golf course, swimming pools, clubhouse, and private airstrip. Panoramic coastal views.',
                    'description_sw' => 'Villa ya gofu ya kiwango cha juu huko Vipingo Ridge. Furahia ufikiaji wa uwanja wa gofu wa mashindano ya mashimo 18, mabwawa ya kuogelea, na uwanja wa ndege wa kibinafsi.',
                    'description_de' => 'Premium-Golfvilla in Vipingo Ridge. Genießen Sie Zugang zum 18-Loch-Meisterschaftsgolfplatz, den Swimmingpools, dem Clubhaus und der privaten Landebahn.',
                    'description_it' => 'Villa da golf premium a Vipingo Ridge. Goditi l\'accesso al campo da golf a 18 buche, piscine, club house e pista di atterraggio privata. Vista panoramica sulla costa.',
                    'description_fr' => 'Villa de golf haut de gamme à Vipingo Ridge. Profitez de l\'accès au parcours de golf de championnat de 18 trous, aux piscines, au club-house et à la piste d\'atterrissage.',
                    'description_pl' => 'Luksusowa willa przy polu golfowym w Vipingo Ridge. Dostęp do 18-dołkowego mistrzowskiego pola golfowego, basenów, klubu i prywatnego pasa startowego.',
                    'features' => 'Golf Course, 4 Bedrooms, Clubhouse, Ocean Views, Security',
                    'image_url' => 'property_care_site.png'
                ];

                $seeds[] = [
                    'title' => 'Shela Beach House Retreat',
                    'type' => 'Property',
                    'status' => 'For Sale',
                    'price' => 'KSh 65,000,000',
                    'location' => 'Shela, Lamu Island',
                    'description_en' => 'A stunning classic Lamu house situated in Shela. Offers beautifully restored Swahili architecture, spacious open courtyards, and a rooftop with views over the channel.',
                    'description_sw' => 'Nyumba nzuri ya kitamaduni ya Lamu iliyopo Shela. Inatoa usanifu ulioboreshwa wa Kiswahili, nyua kubwa za wazi, na rotopu yenye muonekano mzuri wa bahari.',
                    'description_de' => 'Ein atemberaubendes klassisches Lamu-Haus in Shela. Bietet wunderschön restaurierte Swahili-Architektur, weitläufige offene Innenhöfe und eine Dachterrasse.',
                    'description_it' => 'Una splendida casa classica di Lamu situata a Shela. Offre un\'architettura Swahili splendidamente restaurata, ampi cortili aperti e terrazza panoramica.',
                    'description_fr' => 'Une superbe maison classique de Lamu située à Shela. Offre une architecture swahili magnifiquement restaurée, de spacieuses cours ouvertes et un toit-terrasse.',
                    'description_pl' => 'Wspaniały tradycyjny dom na Lamu w Shela. Pięknie odrestaurowana architektura suahili, przestronne otwarte dziedzińce i taras z widokiem na kanał.',
                    'features' => 'Beach View, Swahili Architecture, 5 Bedrooms, Courtyard',
                    'image_url' => 'diani_beach_hero.png'
                ];
                
                // B. Programmatic Generation of 35 More Listings
                $prefixes = ['Royal Palms', 'Ocean Breeze', 'Coral Reef', 'Baobab Gardens', 'Silver Dunes', 'Bahari Crest', 'Swahili Sanctuary', 'Savannah Mist', 'Kaskazi', 'Marina Bay', 'Siri Oasis', 'Horizon View', 'Jumuiya', 'Mbuyuni', 'Bofa Luxury', 'Tamarind', 'Golden Crest', 'Sunset Dunes', 'Maweni', 'Msafiri'];
                $locations = [
                    'Diani Beach Road', 'Galu Beach, Diani', 'Tiwi Coast', 'Shimoni Marine Port', 
                    'Msambweni Coast', 'Nyali, Mombasa', 'Kikambala Coast', 'Vipingo Ridge', 
                    'Watamu Cove', 'Kilifi Creek', 'Lamu Old Town', 'Bofa Beach, Kilifi', 'Shanzu, Mombasa'
                ];
                
                for ($i = 0; $i < 35; $i++) {
                    $prefix = $prefixes[$i % count($prefixes)] . ' ' . ($i + 1);
                    $location = $locations[$i % count($locations)];
                    
                    // Determine type and status pattern
                    if ($i % 3 == 0) {
                        $type = 'Land';
                        $status = 'For Sale';
                        $price_val = 5000000 + ($i * 1250000);
                        $price = 'KSh ' . number_format($price_val);
                        $title = $prefix . ' Plot';
                        $image = 'beachfront_land.png';
                        $features = 'Title Deed, Water Connection, Road Access, Ocean View';
                        $desc = "Excellent premium land investment parcel located in {$location}. Ready for immediate residential development, offering clear ownership certificates and good access.";
                    } elseif ($i % 3 == 1) {
                        $type = 'Property';
                        $status = ($i % 5 == 0) ? 'For Rent' : 'For Sale';
                        if ($status == 'For Rent') {
                            $price_val = 120000 + ($i * 5000);
                            $price = 'KSh ' . number_format($price_val) . ' / Month';
                        } else {
                            $price_val = 18000000 + ($i * 1500000);
                            $price = 'KSh ' . number_format($price_val);
                        }
                        $title = $prefix . ' Villa';
                        $image = 'swahili_luxury_villa.png';
                        $features = 'Private Pool, Fully Furnished, Gated, Backup Generator, Gardens';
                        $desc = "Magnificent modern coastal villa situated in {$location}. Features state-of-the-art amenities, Swahili architectural accents, an infinity pool, and mature tropical landscaping.";
                    } else {
                        $type = 'Development';
                        $status = ($i % 4 == 0) ? 'Invested' : 'For Sale';
                        $price_val = 10000000 + ($i * 1100000);
                        $price = 'KSh ' . number_format($price_val) . ' (Starting)';
                        $title = $prefix . ' Heights';
                        $image = 'modern_heights_residence.png';
                        $features = 'Gym, Swimming Pool, High Speed Elevators, Solar Panels, 24/7 Security';
                        $desc = "A premium master-planned gated development in {$location}. Comprises luxury apartments and townhomes with scenic ocean views and eco-friendly infrastructure.";
                    }
                    
                    $seeds[] = [
                        'title' => $title,
                        'type' => $type,
                        'status' => $status,
                        'price' => $price,
                        'location' => $location,
                        'description_en' => $desc,
                        'description_sw' => $desc . ' (Tafsiri ya Kiswahili itafuata hivi karibuni.)',
                        'description_de' => $desc . ' (Deutsche Übersetzung folgt in Kürze.)',
                        'description_it' => $desc . ' (La traduzione italiana seguirà a breve.)',
                        'description_fr' => $desc . ' (La traduction française suivra bientôt.)',
                        'description_pl' => $desc . ' (Polskie tłumaczenie pojawi się wkrótce.)',
                        'features' => $features,
                        'image_url' => $image
                    ];
                }
                
                // Insert into DB
                $insert_stmt = $pdo->prepare("INSERT INTO properties (title, type, status, price, location, description_en, description_sw, description_de, description_it, description_fr, description_pl, features, image_url) VALUES (:title, :type, :status, :price, :location, :description_en, :description_sw, :description_de, :description_it, :description_fr, :description_pl, :features, :image_url)");
                
                foreach ($seeds as $seed) {
                    $insert_stmt->execute($seed);
                }
                
                $setup_messages[] = "Successfully seeded " . count($seeds) . " premium properties into the database.";
            } else {
                $setup_messages[] = "Properties table already contains " . $prop_count . " entries. Seeding skipped.";
            }

            // 5. Seed 6 realistic short-term stays/villas if empty
            $stmt_v = $pdo->query("SELECT COUNT(*) FROM villas");
            $villas_count = $stmt_v->fetchColumn();
            
            if ($villas_count == 0) {
                $villas_seeds = [
                    [
                        'title' => 'Villa Mbuyuni Luxury Retreat',
                        'price_per_night' => 'KSh 45,000',
                        'capacity' => '8 Guests (4 Bedrooms)',
                        'location' => 'Diani Beach Road',
                        'description_en' => 'Stunning ocean-view holiday villa with a private swimming pool, Swahili architecture, dedicated private chef, fully air-conditioned, and manicured private gardens.',
                        'description_sw' => 'Villa ya likizo yenye muonekano wa bahari na bwawa la kuogelea la kibinafsi, usanifu wa Kiswahili, mpishi aliyejitolea, viyoyozi, na bustani nzuri ya kibinafsi.',
                        'description_de' => 'Atemberaubende Ferienvilla mit Meerblick, privatem Pool, Swahili-Architektur, eigenem Koch, voll klimatisiert und gepflegten privaten Gärten.',
                        'description_it' => 'Splendida villa per vacanze vista mare con piscina privata, architettura Swahili, chef dedicato, aria condizionata e giardini privati curati.',
                        'description_fr' => 'Superbe villa de vacances avec vue sur l\'océan, piscine privée, architecture swahilie, chef privé, climatisation et jardins privés arborés.',
                        'description_pl' => 'Wspaniała willa wakacyjna z widokiem na ocean, prywatnym basenem, architekturą w stylu suahili, prywatnym kucharzem, klimatyzacją i zadbanym ogrodem.',
                        'features' => 'Private Pool, Personal Chef, AC, WiFi, Beach Access',
                        'image_url' => 'swahili_luxury_villa.png'
                    ],
                    [
                        'title' => 'Bahari Sea Breeze Honeymoon Suite',
                        'price_per_night' => 'KSh 22,000',
                        'capacity' => '2 Guests (1 Bedroom)',
                        'location' => 'Galu Beach, Diani',
                        'description_en' => 'Romantic beachfront cottage designed for couples. Steps away from the ocean, featuring a cozy terrace and local makuti-thatched roof, modern bathroom, and private hot tub.',
                        'description_sw' => 'Koti ya pwani ya kimapenzi iliyoundwa kwa wanandoa. Hatua chache kutoka baharini, yenye terasi ya kupumzikia na paa la makuti la kienyeji, na beseni la maji moto la kibinafsi.',
                        'description_de' => 'Romantisches Cottage am Strand für Paare. Nur wenige Schritte vom Meer entfernt, mit gemütlicher Terrasse, traditionellem Makuti-Dach und privatem Whirlpool.',
                        'description_it' => 'Romantico cottage fronte mare progettato per coppie. A pochi passi dall\'oceano, con un\'accogliente terrazza, tetto in makuti locale e vasca idromassaggio privata.',
                        'description_fr' => 'Cottage romantique en bord de mer conçu pour les couples. À quelques pas de l\'océan, avec une terrasse confortable, un toit en makuti et un jacuzzi privé.',
                        'description_pl' => 'Romantyczny domek przy plaży zaprojektowany dla par. Kilka kroków od oceanu, z przytulnym tarasem, tradycyjnym dachem z makuti i prywatnym jacuzzi.',
                        'features' => 'Beachfront, Hot Tub, Makuti Roof, AC, Breakfast Included',
                        'image_url' => 'beachfront_land.png'
                    ],
                    [
                        'title' => 'Kikambala Ocean Vista Penthouse',
                        'price_per_night' => 'KSh 18,500',
                        'capacity' => '4 Guests (2 Bedrooms)',
                        'location' => 'Kikambala Coast',
                        'description_en' => 'Modern luxury penthouse apartment featuring panoramic sea views, solar power integration, high-speed elevator, and shared infinity pool.',
                        'description_sw' => 'Ghorofa ya juu ya kifahari ya kisasa yenye muonekano mzuri wa bahari, matumizi ya umeme wa jua, lifti ya mwendo kasi, na bwawa kubwa la kuogelea.',
                        'description_de' => 'Modernes Luxus-Penthouse-Apartment mit Panoramablick auf das Meer, Solarenergie, Highspeed-Aufzug und gemeinsamem Infinity-Pool.',
                        'description_it' => 'Moderno attico di lusso con vista panoramica sul mare, energia solare integrata, ascensore ad alta velocità e piscina a sfioro in comune.',
                        'description_fr' => 'Penthouse de luxe moderne avec vue panoramique sur la mer, énergie solaire, ascenseur rapide et piscine à débordement commune.',
                        'description_pl' => 'Nowoczesny luksusowy penthouse z panoramicznym widokiem na morze, panelem fotowoltaicznym, windą i wspólnym basenem typu infinity.',
                        'features' => 'Sea View, Elevator, Solar Energy, Pool, Gym Access',
                        'image_url' => 'modern_heights_residence.png'
                    ],
                    [
                        'title' => 'Tiwi Cliffs Cliffside Cottage',
                        'price_per_night' => 'KSh 30,000',
                        'capacity' => '6 Guests (3 Bedrooms)',
                        'location' => 'Tiwi Beach',
                        'description_en' => 'Stunning cottage positioned on the cliffs of Tiwi. Enjoy direct beach access, private plunge pool, and local Swahili decor.',
                        'description_sw' => 'Koti nzuri iliyopo kwenye majabali ya Tiwi. Furahia ufikiaji wa moja kwa moja wa pwani, bwawa dogo la kibinafsi, na mapambo ya kienyeji ya Kiswahili.',
                        'description_de' => 'Atemberaubendes Cottage auf den Klippen von Tiwi. Genießen Sie direkten Strandzugang, einen privaten Plunge-Pool und traditionelles Swahili-Dekor.',
                        'description_it' => 'Splendido cottage arroccato sulle scogliere di Tiwi. Goditi l\'accesso diretto alla spiaggia, una piccola piscina privata e decorazioni in stile Swahili.',
                        'description_fr' => 'Superbe cottage situé sur les falaises de Tiwi. Profitez d\'un accès direct à la plage, d\'une petite piscine privée et d\'une décoration swahilie.',
                        'description_pl' => 'Wspaniały domek położony na klifach w Tiwi. Bezpośredni dostęp do plaży, prywatny minibasenu i tradycyjny wystrój suahili.',
                        'features' => 'Cliffside, Plunge Pool, Direct Beach Access, Housekeeper',
                        'image_url' => 'diani_beach_hero.png'
                    ],
                    [
                        'title' => 'Shimoni Reef Divers Lodge',
                        'price_per_night' => 'KSh 12,000',
                        'capacity' => '4 Guests (2 Bedrooms)',
                        'location' => 'Shimoni Marine Port',
                        'description_en' => 'Cozy coastal lodge ideal for marine sanctuary visitors and scuba divers. Near Kisite-Mpunguti Marine Park.',
                        'description_sw' => 'Loji nzuri ya pwani inayofaa kwa wageni wa hifadhi ya bahari na wapiga mbizi. Karibu na Hifadhi ya Bahari ya Kisite-Mpunguti.',
                        'description_de' => 'Gemütliche Küstenlodge, ideal für Besucher des Meeresschutzgebiets und Taucher. In der Nähe des Kisite-Mpunguti-Meeresparks.',
                        'description_it' => 'Accogliente lodge costiero ideale per visitatori del santuario marino e subacquei. Vicino al Parco Marino Kisite-Mpunguti.',
                        'description_fr' => 'Lodge côtier confortable idéal pour les visiteurs du sanctuaire marin et les plongeurs. Près du parc marin de Kisite-Mpunguti.',
                        'description_pl' => 'Przytulny domek na wybrzeżu, idealny dla nurków i turystów odwiedzających sanktuarium morskie. Blisko Parku Morskiego Kisite-Mpunguti.',
                        'features' => 'Near Marine Park, Boat Trips, Scuba Support, Ocean Breeze',
                        'image_url' => 'property_care_site.png'
                    ],
                    [
                        'title' => 'Msambweni Palm Oasis Villa',
                        'price_per_night' => 'KSh 38,000',
                        'capacity' => '8 Guests (4 Bedrooms)',
                        'location' => 'Msambweni Coast',
                        'description_en' => 'Secluded eco-friendly luxury villa surrounded by palm forests. Private beach cove access and private chef services.',
                        'description_sw' => 'Villa ya kifahari na ya kirafiki kwa mazingira iliyozungukwa na misitu ya minazi. Ufikiaji wa pwani ya kibinafsi na huduma za mpishi.',
                        'description_de' => 'Abgeschiedene umweltfreundliche Luxusvilla umgeben von Palmenwäldern. Zugang zu einer privaten Bucht und Kochservice.',
                        'description_it' => 'Villa di lusso ecologica e appartata circondata da palmeti. Accesso privato alla caletta e servizi di uno chef privato.',
                        'description_fr' => 'Villa de luxe écologique et isolée entourée de palmeraies. Accès à une crique privée et services d\'un chef cuisinier.',
                        'description_pl' => 'Ustronna, ekologiczna luksusowa willa otoczona lasem palmowym. Dostęp do prywatnej zatoczki i usługi prywatnego kucharza.',
                        'features' => 'Private Cove, Solar Powered, Eco-friendly, Chef, Pool',
                        'image_url' => 'swahili_luxury_villa.png'
                    ]
                ];
                
                $insert_stmt_v = $pdo->prepare("INSERT INTO villas (title, price_per_night, capacity, location, description_en, description_sw, description_de, description_it, description_fr, description_pl, features, image_url) VALUES (:title, :price_per_night, :capacity, :location, :description_en, :description_sw, :description_de, :description_it, :description_fr, :description_pl, :features, :image_url)");
                
                foreach ($villas_seeds as $v_seed) {
                    $insert_stmt_v->execute($v_seed);
                }
                
                $setup_messages[] = "Successfully seeded " . count($villas_seeds) . " premium stays/villas into the database.";
            } else {
                $setup_messages[] = "Villas table already contains " . $villas_count . " entries. Seeding skipped.";
            }

            $setup_success = true;
        } else {
            $setup_messages[] = "Error: Schema file 'schema.sql' not found in root directory.";
        }
    } catch (PDOException $e) {
        $setup_messages[] = "Error importing schema: " . $e->getMessage();
    }
} else {
    $setup_messages[] = "Setup failed because database connection could not be established. Check DB_HOST, DB_USER, DB_PASS configuration in 'includes/db.php'.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleVista Group | Database Setup Tool</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 40px 20px; background-color: #070B13;">

    <div class="form-wrapper" style="width: 100%; max-width: 580px; box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 24px;">
            <i class="fa-solid fa-database" style="font-size: 3rem; color: var(--accent-gold); margin-bottom: 16px;"></i>
            <h2 style="font-family: 'Outfit', sans-serif; color: #fff;">CleVista Database Installer</h2>
            <p>Automated database initialization tool</p>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); border-radius: var(--radius-sm); padding: 20px; margin-bottom: 30px;">
            <h4 style="margin-bottom: 12px; font-family: 'Outfit'; color: var(--accent-gold);">Setup Log:</h4>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 0.9rem;">
                <?php foreach ($setup_messages as $message): ?>
                    <li style="display: flex; align-items: start; gap: 10px;">
                        <i class="fa-solid fa-circle-check" style="color: <?php echo (strpos($message, 'Error') !== false || strpos($message, 'failed') !== false) ? '#e74c3c' : '#2ecc71'; ?>; margin-top: 3px;"></i>
                        <span><?php echo $message; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if ($setup_success): ?>
            <a href="login.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block;">Go to Admin Login <i class="fa-solid fa-right-to-bracket"></i></a>
        <?php else: ?>
            <a href="setup.php" class="btn btn-secondary" style="width: 100%; text-align: center; display: block;"><i class="fa-solid fa-rotate-right"></i> Retry Database Installation</a>
        <?php endif; ?>
    </div>

</body>
</html>
