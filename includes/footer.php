<?php
/**
 * CleVista Group Limited - Shared Page Footer Template
 * Renders contact details, direct WhatsApp actions, division links, and binds scripts.
 */
?>
    <!-- Premium Footer Section -->
    <footer>
        <div class="container footer-grid">
            
            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="index.php" class="logo">
                    <span class="logo-brand">CleVista</span>
                    <span class="logo-sub">Group Limited</span>
                </a>
                <p data-i18n="footer_description">
                    A diversified lifestyle, property, and hospitality company dedicated to creating value, maintaining assets, and curating unforgettable coastal guest experiences.
                </p>
                <div class="social-links">
                    <a href="https://facebook.com/clevistagroup" target="_blank" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com/clevistagroup" target="_blank" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/254796443424" target="_blank" class="social-btn" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Divisions Link Column -->
            <div class="footer-col">
                <h3 data-i18n="footer_divisions">Our Divisions</h3>
                <ul class="footer-links">
                    <li><a href="estates.php"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; margin-right: 8px;"></i> <span data-i18n="nav_estates">Estates</span></a></li>
                    <li><a href="care.php"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; margin-right: 8px;"></i> <span data-i18n="nav_care">Care</span></a></li>
                    <li><a href="hospitality.php"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; margin-right: 8px;"></i> <span data-i18n="nav_hospitality">Hospitality</span></a></li>
                </ul>
            </div>

            <!-- Contacts Info Column -->
            <div class="footer-col">
                <h3 data-i18n="footer_contact">Get in Touch</h3>
                <ul class="footer-info-list">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span data-i18n="contact_address">Diani Beach, Ukunda, Kenya</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+254796443424">+254 796 443 424</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <div style="display: flex; flex-direction: column;">
                            <a href="mailto:info@clevistagroup.com" style="font-size: 0.85rem;">info@clevistagroup.com</a>
                            <a href="mailto:sales@clevistagroup.com" style="font-size: 0.85rem;">sales@clevistagroup.com</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Lower Footer Base -->
        <div class="container footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> CleVista Group Limited. <span data-i18n="footer_rights">All Rights Reserved.</span></p>
            <p>Designed with Excellence</p>
        </div>
    </footer>

    <!-- Multilingual Dictionary Script -->
    <script src="js/translations.js"></script>
    
    <!-- General Script File -->
    <script src="js/main.js"></script>

</body>
</html>
