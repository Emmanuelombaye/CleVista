<?php
/**
 * CleVista Care Division Page
 * Handles catalog presentation of site preparation, maintenance, cleaning, and booking submissions.
 */
include_once 'includes/header.php';

// Handle Care Booking Submission
$booking_status = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_care_booking'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service_name = htmlspecialchars(trim($_POST['service_name']));
    $preferred_date = htmlspecialchars(trim($_POST['preferred_date']));
    $details = htmlspecialchars(trim($_POST['details']));
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (name, email, phone, service_type, service_name, preferred_date, details, status) VALUES (?, ?, ?, 'Care', ?, ?, ?, 'Pending')");
            $stmt->execute([$name, $email, $phone, $service_name, $preferred_date, $details]);
            $booking_status = 'success';
        } catch (PDOException $e) {
            $booking_status = 'error';
        }
    } else {
        // Fallback for demo when DB configuration is empty
        $booking_status = 'success';
    }
}
?>

<!-- 1. Hero Banner Section -->
<section class="page-banner" style="background: linear-gradient(rgba(0, 35, 73, 0.4), rgba(0, 35, 73, 0.75)),
            url('https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;">
    <div class="container page-banner-content">
        <span class="section-subtitle-label" data-i18n="nav_care" style="color: var(--accent-teal);">Care</span>
        <h1 class="text-gradient-teal" data-i18n="care_title">CleVista Care</h1>
        <p class="page-banner-desc" data-i18n="care_subtitle">Professional property maintenance, improvement, and presentation.</p>
    </div>
</section>

<!-- 2. Services Showcase Grid -->
<section class="section-padding">
    <div class="container">
        <!-- Status Messages -->
        <?php if ($booking_status === 'success'): ?>
            <div class="alert alert-success" data-i18n="form_success_msg">Thank you! Your booking request has been submitted successfully. Our team will contact you shortly.</div>
        <?php elseif ($booking_status === 'error'): ?>
            <div class="alert alert-error" data-i18n="form_error_msg">An error occurred. Please try again or reach out directly via WhatsApp.</div>
        <?php endif; ?>

        <div class="services-section-grid">
            <!-- Left Side: Interactive catalog -->
            <div class="services-list-container">
                <span class="section-subtitle-label" data-i18n="div_care_sub" style="color: var(--accent-teal);">Prepare • Protect • Present</span>
                <h2 data-i18n="care_service_title" style="margin-bottom: 30px;">Our Property Care Services</h2>
                
                <div class="service-item-card">
                    <div class="service-item-icon"><i class="fa-solid fa-compass-drafting"></i></div>
                    <div class="service-item-text">
                        <h3 data-i18n="care_s1">Site preparation & bush clearing</h3>
                        <p data-i18n="div_care_desc">Clearing thick vegetation, leveling ground, and preparing raw plots for construction or sale, preserving strategic indigenous trees.</p>
                    </div>
                </div>
                
                <div class="service-item-card">
                    <div class="service-item-icon" style="color: var(--accent-gold); background: rgba(212, 175, 55, 0.08);"><i class="fa-solid fa-sparkles"></i></div>
                    <div class="service-item-text">
                        <h3 data-i18n="care_s2">Post-construction deep cleaning</h3>
                        <p data-i18n="footer_description">Removing fine dust, cement spots, paint splatters, and construction debris to turn a fresh building into a ready-to-move masterpiece.</p>
                    </div>
                </div>
                
                <div class="service-item-card">
                    <div class="service-item-icon"><i class="fa-solid fa-tree"></i></div>
                    <div class="service-item-text">
                        <h3 data-i18n="care_s4">Landscaping, gardening & lawn care</h3>
                        <p data-i18n="about_p2">Designing beautiful coastal gardens, planting salt-tolerant tropical flowers, establishing lush green lawns, and routine trimming maintenance.</p>
                    </div>
                </div>
                
                <div class="service-item-card">
                    <div class="service-item-icon" style="color: var(--accent-gold); background: rgba(212, 175, 55, 0.08);"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="service-item-text">
                        <h3 data-i18n="care_s6">Property fencing & border walls</h3>
                        <p data-i18n="div_estates_desc">Installing secure chainlink, barbed-wire, or concrete post fences, and stone perimeter walls to mark boundaries and protect investments.</p>
                    </div>
                </div>
                
                <div class="service-item-card">
                    <div class="service-item-icon"><i class="fa-solid fa-eye-dropper"></i></div>
                    <div class="service-item-text">
                        <h3 data-i18n="care_s7">Routine inspections & asset preservation</h3>
                        <p data-i18n="why_4_desc">For diaspora property owners: regular physical site inspections, photo updates, security reports, and small repairs coordination.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Booking Inquiry Form -->
            <div class="form-wrapper" style="border-top: 3px solid var(--accent-teal);">
                <h3 data-i18n="care_booking_title">Request a Care Service Booking</h3>
                <p data-i18n="care_booking_desc">Schedule a detailed site inspection, maintenance project, or cleaning service with our professional crew.</p>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="care-name" data-i18n="form_name">Full Name</label>
                        <input type="text" name="name" id="care-name" class="form-control" required data-i18n="form_name">
                    </div>
                    
                    <div class="form-group">
                        <label for="care-email" data-i18n="form_email">Email Address</label>
                        <input type="email" name="email" id="care-email" class="form-control" required data-i18n="form_email">
                    </div>
                    
                    <div class="form-group">
                        <label for="care-phone" data-i18n="form_phone">Phone Number</label>
                        <input type="text" name="phone" id="care-phone" class="form-control" placeholder="+254 700 000 000" required data-i18n="form_phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="care-service" data-i18n="form_select_service">Select Care Service</label>
                        <select name="service_name" id="care-service" class="form-control" required>
                            <option value="Bush Clearing" data-i18n="care_s1">Site preparation & bush clearing</option>
                            <option value="Post-Construction Cleaning" data-i18n="care_s2">Post-construction deep cleaning</option>
                            <option value="Residential Deep Cleaning" data-i18n="care_s3">Premium residential deep cleaning</option>
                            <option value="Landscaping & Gardening" data-i18n="care_s4">Landscaping, gardening & lawn care</option>
                            <option value="Tree Planting Program" data-i18n="care_s5">Tree planting programs</option>
                            <option value="Property Fencing" data-i18n="care_s6">Property fencing & border walls</option>
                            <option value="Routine Inspection" data-i18n="care_s7">Routine inspections & asset preservation</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="care-date" data-i18n="form_pref_date">Preferred Date</label>
                        <input type="date" name="preferred_date" id="care-date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="care-details" data-i18n="form_booking_details">Booking Details / Special Instructions</label>
                        <textarea name="details" id="care-details" class="form-control" required data-i18n="form_booking_details"></textarea>
                    </div>
                    
                    <button type="submit" name="submit_care_booking" class="btn btn-teal" style="width: 100%;" data-i18n="btn_submit">Submit Request</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include_once 'includes/footer.php';
?>
