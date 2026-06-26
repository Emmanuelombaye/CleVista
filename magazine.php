<?php
/**
 * CleVista Luxury Magazine (Editorial Portal)
 * Renders the stories, lifestyle journals, and expert editorials.
 * Supports individual article views via the ?id parameter.
 */
include_once 'includes/header.php';

// Define the articles registry
$articles = [
    'diani-living' => [
        'title' => "Diani Living: Kenya's White Sand Haven",
        'category' => "Lifestyle",
        'read_time' => "4 Min Read",
        'date' => "June 25, 2026",
        'image' => "uploads/diani_beach_hero.png",
        'author' => "CleVista Editorial Team",
        'excerpt' => "Discover why international investors are choosing Galu and Diani central beach road for luxury developments.",
        'content' => [
            "Diani Beach, situated on the south coast of Kenya, has long been celebrated as one of Africa's premier beach destinations. With its flawless white sands, swaying palms, and the warm turquoise waters of the Indian Ocean, it represents a natural paradise. However, in recent years, a subtle shift has occurred. Diani is transitioning from a sleepy holiday retreat into a thriving hub for ultra-luxury residential and commercial real estate.",
            "The driving force behind this boom is a combination of lifestyle migration and infrastructure developments. The expansion of Diani Airport (Ukunda) has made the region far more accessible, allowing direct flights from Nairobi and international connections. Concurrently, the Mwache Bridge project is set to bypass the Likoni Ferry bottleneck, directly connecting the south coast to Mombasa mainland and international transit routes.",
            "For high-net-worth investors, Diani offers something increasingly rare in global coastal destinations: expansive beachfront parcels, pristine marine ecosystems, and a relaxed, secure environment. Luxury villas in areas like Galu Beach are seeing double-digit capital appreciation, driven by demand for private sanctuaries that offer both exclusivity and modern conveniences.",
            "Our research shows that luxury developments along Diani Central Beach Road are attracting buyers not just from Europe and North America, but also from the Kenyan diaspora and Nairobi's expanding executive class. These buyers are looking for properties that combine traditional coastal aesthetics with modern, state-of-the-art building standards.",
            "CleVista is proud to be at the forefront of this evolution, offering carefully curated plots, bespoke property advisory, and a dedication to preserving the natural beauty that makes Diani a global treasure. Investing here is not just about acquiring square footage; it is about securing a piece of one of the world's most beautiful coastlines."
        ],
        'quotes' => [
            "Diani is transitioning from a sleepy holiday retreat into a thriving hub for ultra-luxury residential and commercial real estate."
        ]
    ],
    'diaspora-protection' => [
        'title' => "Diaspora Asset Protection: Preserving Legacies",
        'category' => "Property Care",
        'read_time' => "5 Min Read",
        'date' => "June 20, 2026",
        'image' => "uploads/property_care_site.png",
        'author' => "CleVista Care Division",
        'excerpt' => "How CleVista Care provides property owners abroad with real-time cleaning, landscaping, and inspections logs.",
        'content' => [
            "For Kenyans living in the diaspora, investing in property back home is a profound milestone. It represents a connection to their roots, a plan for retirement, or a legacy built for future generations. However, managing these investments from thousands of miles away is notoriously difficult. Stories of neglected construction, poor property management, and diverted funds are all too common, creating immense anxiety for overseas owners.",
            "This is the exact challenge that the CleVista Care division was created to solve. By introducing professional, transparent, and technology-driven asset protection, we act as the eyes and ears of property owners on the ground, ensuring that their homes, estates, and lands are preserved in pristine condition.",
            "Our approach is built on regular, structured inspection audits. Instead of relying on casual reports, CleVista Care clients receive comprehensive digital logs containing high-resolution photographs, structural checklists, and maintenance recommendations. Whether it is verifying utility connections, auditing perimeter security, or checking for dampness during the rainy season, every detail is verified and documented.",
            "In addition to maintenance, CleVista Care specializes in aesthetic preservation. Our gardening and landscaping teams ensure that lawns are manicured, tropical gardens are nurtured, and pools are chemically balanced. When owners or their guests return to Kenya, they do not arrive to a dusty, overgrown house; they step into a fully prepared, luxury-grade home.",
            "We believe that trust is built on transparency. By offering clear communication, professional service level agreements, and real-time updates, we give diaspora investors the peace of mind they deserve. Your legacy is safe in our hands."
        ],
        'quotes' => [
            "We act as the eyes and ears of property owners on the ground, ensuring that their homes, estates, and lands are preserved in pristine condition."
        ]
    ],
    'swahili-architecture' => [
        'title' => "Coastal Swahili Modern Architecture",
        'category' => "Architecture",
        'read_time' => "6 Min Read",
        'date' => "June 15, 2026",
        'image' => "uploads/swahili_luxury_villa.png",
        'author' => "CleVista Design Studio",
        'excerpt' => "Exploring architectural integration blending traditional Swahili coral limestone with modern glass villas.",
        'content' => [
            "The architecture of the East African coast is a rich tapestry woven from centuries of cultural exchange. Arabic, Persian, Indian, and African influences blended to create the iconic Swahili style—characterized by thick coral stone walls, intricate plasterwork, high ceilings, and grand hand-carved mvule doors. Today, a new design movement is emerging along the beaches of Diani: Swahili Modernism.",
            "This style maintains the structural logic and historical resonance of traditional Swahili design while introducing the clean lines, expansive glazing, and open floor plans of modern contemporary architecture. The result is a striking aesthetic that feels deeply rooted in place yet thoroughly sophisticated.",
            "One of the key elements of this integration is the use of coral limestone. Historically used for its strength and cooling properties, coral stone is now used as feature walls, contrasted against large sheets of structural glass and minimalist black steel frames. This juxtaposition creates a tactile, earthy texture that anchors the building to its tropical environment.",
            "Natural ventilation is another area where modern design learns from the past. Rather than relying entirely on air conditioning, Swahili Modern villas use open baraza alcoves, high-lofted ceilings, and strategic window placements to capture the Kaskazi and Kusi ocean breezes. Water is also central to the experience; traditional central courtyards with fountains are reimagined as sleek, infinity-edge swimming pools that flow directly from the main living rooms.",
            "At CleVista, we believe that true luxury lies in authentic design. By working with local craftsmen who understand the nuances of coral carving and hardwood cabinetry, we help developers and private clients build homes that celebrate coastal heritage while offering every modern convenience."
        ],
        'quotes' => [
            "Juxtaposing traditional coral stone walls with modern glass and steel creates an authentic aesthetic that feels deeply rooted in place."
        ]
    ]
];

// Determine if we are reading a specific article
$article_id = isset($_GET['id']) ? trim($_GET['id']) : null;
$current_article = null;

if ($article_id && isset($articles[$article_id])) {
    $current_article = $articles[$article_id];
}
?>

<!-- Custom CSS for the Magazine Layout to guarantee absolute premium aesthetic -->
<style>
    .magazine-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }
    
    .magazine-banner {
        background-color: var(--sir-blue);
        color: #fff;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }
    .magazine-banner h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 300;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }
    .magazine-banner p {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    
    /* Article Reader Layout */
    .article-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 60px 20px;
    }
    
    .article-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .article-meta {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--accent-gold);
        margin-bottom: 16px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    
    .article-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        line-height: 1.25;
        color: var(--sir-blue);
        margin-bottom: 20px;
        font-weight: 300;
    }
    
    .article-author-date {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--sir-text-grey);
    }
    
    .article-hero-image {
        width: 100%;
        height: 500px;
        overflow: hidden;
        margin-bottom: 50px;
    }
    
    .article-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .article-body-content {
        font-family: 'Georgia', serif;
        font-size: 1.15rem;
        line-height: 1.8;
        color: #2c2c2c;
    }
    
    .article-body-content p {
        margin-bottom: 30px;
    }
    
    /* First letter drop cap */
    .article-body-content p:first-of-type::first-letter {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        float: left;
        line-height: 1;
        padding-right: 12px;
        color: var(--sir-blue);
        font-weight: 300;
    }
    
    .article-quote {
        border-left: 2px solid var(--accent-gold);
        padding-left: 30px;
        margin: 40px 0;
        font-style: italic;
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--sir-blue);
        line-height: 1.4;
    }
    
    .back-to-magazine {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--sir-blue);
        text-decoration: none;
        margin-bottom: 40px;
        transition: color var(--transition);
    }
    .back-to-magazine:hover {
        color: var(--sir-gold);
    }
    
    /* Suggested Articles section */
    .suggested-section {
        border-top: 1px solid #e0e0e0;
        padding-top: 60px;
        margin-top: 60px;
    }
    .suggested-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--sir-blue);
        margin-bottom: 40px;
        text-align: center;
        font-weight: 300;
    }

    @media (max-width: 768px) {
        .magazine-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .article-title {
            font-size: 2rem;
        }
        .article-hero-image {
            height: 300px;
        }
    }
</style>

<?php if ($current_article): ?>
    <!-- ==============================================
         ARTICLE READER VIEW
         ============================================== -->
    <article class="article-container">
        <a href="magazine.php" class="back-to-magazine">
            <i class="fa-solid fa-arrow-left"></i> Back to Magazine
        </a>
        
        <div class="article-header">
            <div class="article-meta">
                <span><?php echo htmlspecialchars($current_article['category']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($current_article['read_time']); ?></span>
            </div>
            <h1 class="article-title"><?php echo htmlspecialchars($current_article['title']); ?></h1>
            <div class="article-author-date">
                By <strong><?php echo htmlspecialchars($current_article['author']); ?></strong> &nbsp;|&nbsp; <?php echo htmlspecialchars($current_article['date']); ?>
            </div>
        </div>
        
        <div class="article-hero-image">
            <img src="<?php echo htmlspecialchars($current_article['image']); ?>" alt="<?php echo htmlspecialchars($current_article['title']); ?>">
        </div>
        
        <div class="article-body-content">
            <?php 
            $paragraphs = $current_article['content'];
            // Render first paragraph with drop cap styling
            echo "<p>" . $paragraphs[0] . "</p>";
            
            // Render quote if exists
            if (!empty($current_article['quotes'][0])) {
                echo "<blockquote class='article-quote'>\"" . htmlspecialchars($current_article['quotes'][0]) . "\"</blockquote>";
            }
            
            // Render the rest of the paragraphs
            for ($i = 1; $i < count($paragraphs); $i++) {
                echo "<p>" . $paragraphs[$i] . "</p>";
            }
            ?>
        </div>
        
        <!-- Suggested Reads -->
        <div class="suggested-section">
            <h3 class="suggested-title">More Stories & Insights</h3>
            <div class="magazine-grid">
                <?php foreach ($articles as $key => $art): 
                    if ($key === $article_id) continue; // Skip current article
                ?>
                    <a href="magazine.php?id=<?php echo $key; ?>" class="listing-card" style="text-decoration: none;">
                        <div class="listing-img" style="height:200px;">
                            <img src="<?php echo htmlspecialchars($art['image']); ?>" alt="<?php echo htmlspecialchars($art['title']); ?>">
                        </div>
                        <div class="listing-body" style="padding:16px 0;">
                            <span style="font-family:'Inter'; font-size:0.7rem; text-transform:uppercase; color:var(--accent-gold); letter-spacing:1px; margin-bottom:8px; display:block;">
                                <?php echo htmlspecialchars($art['category']); ?>
                            </span>
                            <h4 style="font-family:'Playfair Display'; font-size:1.2rem; color: var(--sir-blue); margin-bottom:8px; font-weight:300;">
                                <?php echo htmlspecialchars($art['title']); ?>
                            </h4>
                            <p style="font-size:0.85rem; color: var(--sir-text-grey);">
                                <?php echo htmlspecialchars($art['excerpt']); ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </article>

<?php else: ?>
    <!-- ==============================================
         MAGAZINE ARCHIVE VIEW (GRID)
         ============================================== -->
    <div class="magazine-banner">
        <div class="container">
            <p>CleVista Editorial Journal</p>
            <h1>Luxury Magazine</h1>
        </div>
    </div>
    
    <section class="section-padding" style="background-color: var(--bg-white); padding-top:0;">
        <div class="container">
            <div class="magazine-grid">
                <?php foreach ($articles as $key => $art): ?>
                    <a href="magazine.php?id=<?php echo $key; ?>" class="listing-card" style="text-decoration: none;">
                        <div class="listing-img" style="height:240px;">
                            <img src="<?php echo htmlspecialchars($art['image']); ?>" alt="<?php echo htmlspecialchars($art['title']); ?>">
                        </div>
                        <div class="listing-body" style="padding:20px 0;">
                            <span style="font-family:'Inter'; font-size:0.75rem; text-transform:uppercase; color:var(--accent-gold); letter-spacing:1.5px; margin-bottom:10px; display:block;">
                                <?php echo htmlspecialchars($art['category']); ?> &nbsp;•&nbsp; <?php echo htmlspecialchars($art['read_time']); ?>
                            </span>
                            <h4 style="font-family:'Playfair Display'; font-size:1.4rem; color: var(--sir-blue); margin-bottom:10px; font-weight:300;">
                                <?php echo htmlspecialchars($art['title']); ?>
                            </h4>
                            <p style="font-size:0.9rem; color: var(--sir-text-grey); line-height: 1.6;">
                                <?php echo htmlspecialchars($art['excerpt']); ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
include_once 'includes/footer.php';
?>
