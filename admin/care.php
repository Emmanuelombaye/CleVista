<?php
/**
 * CleVista Group Limited - Booking Requests Manager
 * Handles confirmation workflow for care services and hospitality accommodations, 
 * including direct WhatsApp client engagement.
 */
include_once __DIR__ . '/includes/header.php';

$success_msg = null;
$error_msg = null;

// 1. Handle Status Transitions
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    
    $allowed_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
    if (in_array($status, $allowed_statuses)) {
        try {
            $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $success_msg = "Booking request status updated to '{$status}' successfully.";
        } catch (PDOException $e) {
            $error_msg = "Error updating status: " . $e->getMessage();
        }
    }
}

// 2. Handle Booking Deletions
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$delete_id]);
        $success_msg = "Booking request record removed successfully.";
    } catch (PDOException $e) {
        $error_msg = "Error deleting record: " . $e->getMessage();
    }
}

// 3. Fetch Bookings
$bookings = [];
try {
    $bookings = $pdo->query("SELECT * FROM bookings ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $error_msg = "Could not fetch bookings list: " . $e->getMessage();
}
?>

<div class="admin-header">
    <div>
        <h1>Service Bookings</h1>
        <p style="color: var(--admin-text-muted);">Manage requests for CleVista Care & Hospitalitystays</p>
    </div>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-error" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="admin-card-panel">
    <h2>All Booking Requests</h2>
    
    <div class="admin-table-container" style="margin-top: 20px;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date Received</th>
                    <th>Client Contact</th>
                    <th>Division</th>
                    <th>Service / Villa</th>
                    <th>Preferred Date</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--admin-text-muted);">No booking requests found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $book): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($book['created_at'])); ?></td>
                            <td>
                                <div style="font-weight: 600;"><?php echo htmlspecialchars($book['name']); ?></div>
                                <div style="font-size: 0.8rem; color: var(--admin-text-muted);"><?php echo htmlspecialchars($book['email']); ?></div>
                                <div style="font-size: 0.8rem; margin-top: 4px;">
                                    <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($book['phone']); ?>
                                    
                                    <!-- Clean WhatsApp Direct click generator -->
                                    <?php
                                    // Remove special characters leaving numeric values (like +254 796... -> 254796...)
                                    $clean_phone = preg_replace('/[^0-9]/', '', $book['phone']);
                                    // Default prefix country code if needed (assuming Kenya if starting with 0)
                                    if (strpos($clean_phone, '0') === 0) {
                                        $clean_phone = '254' . substr($clean_phone, 1);
                                    }
                                    ?>
                                    <a href="https://wa.me/<?php echo $clean_phone; ?>?text=Hello%20<?php echo urlencode($book['name']); ?>,%20this%20is%20CleVista%20Group%20regarding%20your%20<?php echo urlencode($book['service_name']); ?>%20booking." 
                                       target="_blank" style="color: #2ecc71; margin-left: 8px; font-weight: 600;">
                                        <i class="fa-brands fa-whatsapp"></i> Chat
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php
                                $div_class = 'badge-teal';
                                if ($book['service_type'] == 'Hospitality') $div_class = 'badge-gold';
                                ?>
                                <span class="badge <?php echo $div_class; ?>" style="font-size: 0.7rem;"><?php echo $book['service_type']; ?></span>
                            </td>
                            <td><div style="font-weight:600;"><?php echo htmlspecialchars($book['service_name']); ?></div></td>
                            <td style="font-weight: 500;"><?php echo date('Y-m-d', strtotime($book['preferred_date'])); ?></td>
                            <td>
                                <div style="max-width: 250px; font-size: 0.85rem; color: var(--admin-text-muted); overflow-wrap: break-word;">
                                    <?php echo nl2br(htmlspecialchars($book['details'])); ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                $status_class = 'badge-pending';
                                if ($book['status'] == 'Confirmed') $status_class = 'badge-confirmed';
                                else if ($book['status'] == 'Completed') $status_class = 'badge-completed';
                                else if ($book['status'] == 'Cancelled') $status_class = 'badge-cancelled';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $book['status']; ?></span>
                            </td>
                            <td>
                                <div class="action-buttons" style="flex-direction: column; gap: 4px;">
                                    <div style="display:flex; gap: 4px;">
                                        <a href="care.php?id=<?php echo $book['id']; ?>&status=Confirmed" class="action-btn" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(46, 204, 113, 0.3); color: #2ecc71;" title="Confirm Booking"><i class="fa-solid fa-check"></i> Confirm</a>
                                        <a href="care.php?id=<?php echo $book['id']; ?>&status=Completed" class="action-btn" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(52, 152, 219, 0.3); color: #3498db;" title="Mark Completed"><i class="fa-solid fa-circle-check"></i> Done</a>
                                    </div>
                                    <div style="display:flex; gap: 4px;">
                                        <a href="care.php?id=<?php echo $book['id']; ?>&status=Cancelled" class="action-btn action-btn-danger" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(231, 76, 60, 0.3);" title="Cancel Booking"><i class="fa-solid fa-ban"></i> Cancel</a>
                                        <a href="care.php?delete=<?php echo $book['id']; ?>" class="action-btn action-btn-danger" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(231, 76, 60, 0.3);" onclick="return confirm('Are you sure you want to delete this booking request record?');" title="Delete Booking"><i class="fa-solid fa-trash"></i> Delete</a>
                                    </div>
                                </div>
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
