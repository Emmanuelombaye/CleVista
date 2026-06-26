<?php
/**
 * CleVista Group Limited - Shared Page Header Template (Sotheby's Luxury Layout)
 * Connects database, handles PHP sessions, defines SEO structure, and renders navigation and top utility bar.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CleVista Group Limited is a premier integrated property, care, and hospitality brand based in Diani, Kenya. Offering strategic land acquisition, professional maintenance, and curated coastal stays.">
    <meta name="keywords" content="CleVista, CleVista Estates, CleVista Care, CleVista Hospitality, Diani land for sale, Diani villas, Kenya coastal real estate, property cleaning Diani, Diani airport transfers">
    <meta name="author" content="CleVista Group Limited">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
    <title>CleVista Group | Own. Care. Experience.</title>

    <!-- External Fonts & Icon Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- 1. Sotheby's-Inspired Utility Top Bar -->
    <div class="top-bar">
        <div class="container top-bar-container">
            <div class="top-bar-left">
                <!-- Left side empty to match Sotheby's layout exactly -->
            </div>
            
            <div class="top-bar-right" style="display:flex; gap:20px; align-items:center; font-family:'Inter',sans-serif; font-size:0.75rem; letter-spacing:1px;">
                <!-- Language selector -->
                <div class="lang-selector">
                    <button class="lang-trigger" id="active-lang-trigger" aria-label="Select Language" style="padding: 0; color: var(--text-light); gap: 6px;">
                        <img id="active-lang-flag" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg" alt="English Flag" style="width: 14px; height: 10px; object-fit: cover;">
                        <span id="active-lang-text">English</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.6rem; margin-left: 2px;"></i>
                    </button>
                    <div class="lang-dropdown" style="right: auto; left: 0;">
                        <button class="lang-btn active" data-lang="en">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg" alt="English">
                            English
                        </button>
                        <button class="lang-btn" data-lang="sw">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/ke.svg" alt="Swahili">
                            Swahili
                        </button>
                        <button class="lang-btn" data-lang="de">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/de.svg" alt="German">
                            Deutsch
                        </button>
                        <button class="lang-btn" data-lang="it">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/it.svg" alt="Italian">
                            Italiano
                        </button>
                        <button class="lang-btn" data-lang="fr">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/fr.svg" alt="French">
                            Français
                        </button>
                        <button class="lang-btn" data-lang="pl">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/pl.svg" alt="Polish">
                            Polski
                        </button>
                    </div>
                </div>
                <span style="color:rgba(255,255,255,0.15);">|</span>
                <a href="admin/index.php" style="color:var(--text-light);" data-i18n="nav_portal">Join / Log In</a>
                <span style="color:rgba(255,255,255,0.15);">|</span>
                <a href="contact.php" style="color:var(--text-light); display:flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-gear" style="font-size: 0.7rem; color: rgba(255,255,255,0.65);"></i>
                    <span data-i18n="nav_preferences">Preferences</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Main Luxury Floating Navbar -->
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo">
                <span class="logo-brand">CleVista</span>
                <span class="logo-sub">Own. Care. Experience.</span>
            </a>

            <!-- Restructured Navigation Links to match screenshot exactly -->
            <ul class="nav-menu">
                <li class="nav-item-mobile-only logo-mobile-menu">
                    <span class="logo-brand">CleVista</span>
                    <span class="logo-sub">Own. Care. Experience.</span>
                </li>
                <li class="nav-menu-item">
                    <a href="estates.php" class="nav-link" data-i18n="nav_search"><i class="fa-solid fa-magnifying-glass" style="font-size:0.75rem; margin-right:8px; color:rgba(255,255,255,0.7);"></i>Search</a>
                    <span class="nav-subtitle">Find Land & Properties</span>
                </li>
                <li class="nav-menu-item">
                    <a href="estates.php" class="nav-link" data-i18n="nav_properties">Properties</a>
                    <span class="nav-subtitle">Explore Our Listings</span>
                </li>
                <li class="nav-menu-item">
                    <a href="contact.php" class="nav-link" data-i18n="nav_agents">Agents</a>
                    <span class="nav-subtitle">Connect With Local Experts</span>
                </li>
                <li class="nav-menu-item">
                    <a href="magazine.php" class="nav-link" data-i18n="nav_stories">Stories</a>
                    <span class="nav-subtitle">Luxury Lifestyle Journal</span>
                </li>
                <li class="nav-menu-item btn-sell-wrapper">
                    <a href="contact.php?subject=Listing%20My%20Property" class="btn-sell-with-us nav-link" style="margin-left: 8px;" data-i18n="nav_sell_with_us">
                        Sell With Us
                    </a>
                    <span class="nav-subtitle">Partner With Our Agency</span>
                </li>
                
                <!-- Mobile only utility links (Join/Log In, Language Selection) at the bottom -->
                <li class="nav-item-mobile-only mobile-utility-links">
                    <a href="admin/index.php" class="mobile-utility-link" data-i18n="nav_portal">Join / Log In</a>
                    <span style="color:rgba(255,255,255,0.25);">|</span>
                    <a href="contact.php" class="mobile-utility-link" style="display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-gear" style="font-size:0.7rem; color:rgba(255,255,255,0.6);"></i>
                        <span data-i18n="nav_preferences">Preferences</span>
                    </a>
                </li>
                <li class="nav-item-mobile-only mobile-lang-options">
                    <button class="mobile-lang-btn" data-lang="en">EN</button>
                    <button class="mobile-lang-btn" data-lang="sw">SW</button>
                    <button class="mobile-lang-btn" data-lang="de">DE</button>
                    <button class="mobile-lang-btn" data-lang="it">IT</button>
                    <button class="mobile-lang-btn" data-lang="fr">FR</button>
                    <button class="mobile-lang-btn" data-lang="pl">PL</button>
                </li>
            </ul>

            <!-- Mobile Hamburger menu -->
            <button class="mobile-nav-toggle" aria-label="Toggle Navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
