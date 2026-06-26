<?php
/**
 * CleVista Group Limited - Contact Page
 * Handles contact details, direct WhatsApp actions, and general inquiry form submission to database.
 */
include_once 'includes/header.php';

// Handle Contact Form Submission
$message_status = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact_message'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $division = htmlspecialchars(trim($_POST['division']));
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, subject, message, division, status) VALUES (?, ?, ?, ?, ?, ?, 'New')");
            $stmt->execute([$name, $email, $phone, $subject, $message, $division]);
            $message_status = 'success';
        } catch (PDOException $e) {
            $message_status = 'error';
        }
    } else {
        // Fallback for demo when database is not yet running
        $message_status = 'success';
    }
}
?>

<!-- 1. Hero Banner Section -->
<section class="page-banner" style="background: linear-gradient(rgba(0, 35, 73, 0.4), rgba(0, 35, 73, 0.75)),
            url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;">
    <div class="container page-banner-content">
        <span class="section-subtitle-label" data-i18n="nav_contact">Contact</span>
        <h1 class="text-gradient-gold" data-i18n="contact_header">Contact CleVista Group</h1>
        <p class="page-banner-desc" data-i18n="contact_subheader">Have questions or ready to partner with us? Reach out directly or send an online inquiry.</p>
    </div>
</section>

<!-- 2. Contact Grid Details & Forms -->
<section class="section-padding">
    <div class="container">
        <!-- Status Messages -->
        <?php if ($message_status === 'success'): ?>
            <div class="alert alert-success" data-i18n="form_success_msg">Thank you! Your message has been submitted successfully. Our team will contact you shortly.</div>
        <?php elseif ($message_status === 'error'): ?>
            <div class="alert alert-error" data-i18n="form_error_msg">An error occurred. Please try again or reach out directly via WhatsApp.</div>
        <?php endif; ?>

        <div class="booking-grid">
            
            <!-- Left Column: Contact info panel -->
            <div class="contact-info-panel">
                <span class="section-subtitle-label" data-i18n="contact_info_title">Information</span>
                <h2 data-i18n="contact_info_title">Contact Information</h2>
                
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="contact-card-details">
                        <h4 data-i18n="contact_address">Diani Beach, Ukunda, Kenya</h4>
                        <p>Diani Beach Road, South Coast Kenya</p>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-card-icon" style="color:var(--accent-teal); background:rgba(20,143,119,0.08);"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="contact-card-details">
                        <h4 data-i18n="contact_whatsapp">Call / WhatsApp Us</h4>
                        <a href="https://wa.me/254796443424" target="_blank" style="font-weight: 600; color:var(--accent-teal);">+254 796 443 424</a>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="contact-card-details">
                        <h4 data-i18n="footer_contact">Email Contacts</h4>
                        <p><span data-i18n="contact_email_info">General</span>: <a href="mailto:info@clevistagroup.com">info@clevistagroup.com</a></p>
                        <p><span data-i18n="contact_email_sales">Sales</span>: <a href="mailto:sales@clevistagroup.com">sales@clevistagroup.com</a></p>
                    </div>
                </div>

                <div class="map-placeholder">
                    <i class="fa-solid fa-earth-africa"></i>
                    <span>Diani / Ukunda, Kenya</span>
                    <p style="margin-top: 4px; font-size: 0.8rem; color: var(--text-muted);">Serving Diani, Ukunda, & South Coast Kenya</p>
                </div>
            </div>

            <!-- Right Column: Interactive general message form -->
            <div class="form-wrapper">
                <h3 data-i18n="form_form_title">Send a Message</h3>
                <p data-i18n="contact_subheader">Fill in the form below and a CleVista representative will get back to you immediately.</p>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="contact-name" data-i18n="form_name">Full Name</label>
                        <input type="text" name="name" id="contact-name" class="form-control" required data-i18n="form_name">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email" data-i18n="form_email">Email Address</label>
                        <input type="email" name="email" id="contact-email" class="form-control" required data-i18n="form_email">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-phone" data-i18n="form_phone">Phone Number</label>
                        <input type="text" name="phone" id="contact-phone" class="form-control" placeholder="+254 700 000 000" required data-i18n="form_phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-division" data-i18n="form_select_division">Select Division</label>
                        <select name="division" id="contact-division" class="form-control" required>
                            <option value="General" data-i18n="form_div_general">General Inquiry</option>
                            <option value="Estates" data-i18n="form_div_estates">CleVista Estates (Land & Properties)</option>
                            <option value="Care" data-i18n="form_div_care">CleVista Care (Property Care & Services)</option>
                            <option value="Hospitality" data-i18n="form_div_hospitality">CleVista Hospitality (Villa Stays & Tours)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-subject" data-i18n="form_subject">Subject</label>
                        <input type="text" name="subject" id="contact-subject" class="form-control" required data-i18n="form_subject">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-message" data-i18n="form_message">Message / Details</label>
                        <textarea name="message" id="contact-message" class="form-control" required data-i18n="form_message"></textarea>
                    </div>
                    
                    <button type="submit" name="submit_contact_message" class="btn btn-primary" style="width: 100%;" data-i18n="btn_submit">Submit Request</button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php
include_once 'includes/footer.php';
?>
