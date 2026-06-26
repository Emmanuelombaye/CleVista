<?php
/**
 * CleVista Group Limited - Admin Dashboard Main Overview
 * Displays key statistical metrics and recent submissions from tables.
 */
include_once __DIR__ . '/includes/header.php';

// Fetch Counts
$count_properties = 0;
$count_villas = 0;
$count_inquiries = 0;
$count_pending_bookings = 0;

try {
    $count_properties = $pdo->query("SELECT COUNT(*) FROM properties")->fetchColumn();
    $count_villas = $pdo->query("SELECT COUNT(*) FROM villas")->fetchColumn();
    $count_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
    $count_pending_bookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();
    
    // Fetch Recent Activity lists
    $recent_inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5")->fetchAll();
    $recent_bookings = $pdo->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    // If table structure isn't ready
    $recent_inquiries = [];
    $recent_bookings = [];
}
?>

<div class="admin-header">
    <div>
        <h1>Dashboard</h1>
        <p style="color: var(--admin-text-muted);">Overview of system actions and leads</p>
    </div>
    
    <div class="admin-user-profile">
        <div class="admin-user-avatar">AD</div>
        <div>
            <div style="font-weight: 600;"><?php echo htmlspecialchars($active_user); ?></div>
            <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><?php echo htmlspecialchars($active_email); ?></div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="stat-info">
            <h3>Active Properties</h3>
            <div class="stat-number"><?php echo $count_properties; ?></div>
        </div>
        <div class="stat-icon"><i class="fa-solid fa-hotel"></i></div>
    </div>
    
    <div class="admin-stat-card">
        <div class="stat-info">
            <h3>Active Stays</h3>
            <div class="stat-number"><?php echo $count_villas; ?></div>
        </div>
        <div class="stat-icon" style="color: var(--admin-accent-teal);"><i class="fa-solid fa-umbrella-beach"></i></div>
    </div>
    
    <div class="admin-stat-card">
        <div class="stat-info">
            <h3>Total Inquiries</h3>
            <div class="stat-number"><?php echo $count_inquiries; ?></div>
        </div>
        <div class="stat-icon"><i class="fa-solid fa-inbox"></i></div>
    </div>
    
    <div class="admin-stat-card">
        <div class="stat-info">
            <h3>Pending Bookings</h3>
            <div class="stat-number"><?php echo $count_pending_bookings; ?></div>
        </div>
        <div class="stat-icon" style="color: var(--status-pending);"><i class="fa-solid fa-clock"></i></div>
    </div>
</div>

<!-- Recent Inquiries Section -->
<div class="admin-card-panel">
    <div class="admin-card-header">
        <h2>Recent Inquiries</h2>
        <a href="messages.php" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.8rem;">View All Inquiries</a>
    </div>
    
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email / Phone</th>
                    <th>Division</th>
                    <th>Subject</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent_inquiries)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No inquiries received yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent_inquiries as $inq): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($inq['created_at'])); ?></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($inq['name']); ?></td>
                            <td>
                                <div><?php echo htmlspecialchars($inq['email']); ?></div>
                                <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><?php echo htmlspecialchars($inq['phone']); ?></div>
                            </td>
                            <td><span class="badge badge-gold" style="font-size: 0.7rem;"><?php echo $inq['division']; ?></span></td>
                            <td><?php echo htmlspecialchars($inq['subject']); ?></td>
                            <td>
                                <?php
                                $status_class = 'badge-pending';
                                if ($inq['status'] == 'Read') $status_class = 'badge-completed';
                                else if ($inq['status'] == 'Replied') $status_class = 'badge-confirmed';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $inq['status']; ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Bookings Section -->
<div class="admin-card-panel">
    <div class="admin-card-header">
        <h2>Recent Service Bookings</h2>
        <a href="care.php" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.8rem;">View All Bookings</a>
    </div>
    
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date Received</th>
                    <th>Client Name</th>
                    <th>Division</th>
                    <th>Service / Villa</th>
                    <th>Preferred Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent_bookings)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No service bookings submitted yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent_bookings as $book): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($book['created_at'])); ?></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($book['name']); ?></td>
                            <td>
                                <?php
                                $div_class = 'badge-teal';
                                if ($book['service_type'] == 'Hospitality') $div_class = 'badge-gold';
                                ?>
                                <span class="badge <?php echo $div_class; ?>" style="font-size: 0.7rem;"><?php echo $book['service_type']; ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($book['service_name']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($book['preferred_date'])); ?></td>
                            <td>
                                <?php
                                $status_class = 'badge-pending';
                                if ($book['status'] == 'Confirmed') $status_class = 'badge-confirmed';
                                else if ($book['status'] == 'Completed') $status_class = 'badge-completed';
                                else if ($book['status'] == 'Cancelled') $status_class = 'badge-cancelled';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $book['status']; ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
</body>
</html>
