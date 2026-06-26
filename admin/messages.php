<?php
/**
 * CleVista Group Limited - Inquiries Inbox Message Manager
 * Handles confirmation and status workflows for general messages and property callback requests.
 */
include_once __DIR__ . '/includes/header.php';

$success_msg = null;
$error_msg = null;

// 1. Handle Status Transitions
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    
    $allowed_statuses = ['New', 'Read', 'Replied'];
    if (in_array($status, $allowed_statuses)) {
        try {
            $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $success_msg = "Inquiry message status updated to '{$status}' successfully.";
        } catch (PDOException $e) {
            $error_msg = "Error updating status: " . $e->getMessage();
        }
    }
}

// 2. Handle Message Deletions
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$delete_id]);
        $success_msg = "Inquiry message deleted successfully.";
    } catch (PDOException $e) {
        $error_msg = "Error deleting record: " . $e->getMessage();
    }
}

// 3. Fetch Inquiries
$inquiries = [];
try {
    $inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $error_msg = "Could not fetch inquiries list: " . $e->getMessage();
}
?>

<div class="admin-header">
    <div>
        <h1>Inbox Messages</h1>
        <p style="color: var(--admin-text-muted);">Manage contact messages and property interest callbacks</p>
    </div>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-error" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="admin-card-panel">
    <h2>All Inquiries</h2>
    
    <div class="admin-table-container" style="margin-top: 20px;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date Received</th>
                    <th>Client Contact</th>
                    <th>Division</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($inquiries)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--admin-text-muted);">No inquiries found in your inbox.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($inq['created_at'])); ?></td>
                            <td>
                                <div style="font-weight: 600;"><?php echo htmlspecialchars($inq['name']); ?></div>
                                <div style="font-size: 0.8rem; color: var(--admin-text-muted);"><?php echo htmlspecialchars($inq['email']); ?></div>
                                <div style="font-size: 0.8rem; margin-top: 4px;">
                                    <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($inq['phone']); ?>
                                    
                                    <!-- Clean WhatsApp Direct click generator -->
                                    <?php
                                    $clean_phone = preg_replace('/[^0-9]/', '', $inq['phone']);
                                    if (strpos($clean_phone, '0') === 0) {
                                        $clean_phone = '254' . substr($clean_phone, 1);
                                    }
                                    ?>
                                    <a href="https://wa.me/<?php echo $clean_phone; ?>?text=Hello%20<?php echo urlencode($inq['name']); ?>,%20this%20is%20CleVista%20Group%20regarding%20your%20inquiry%20about%20<?php echo urlencode($inq['subject']); ?>." 
                                       target="_blank" style="color: #2ecc71; margin-left: 8px; font-weight: 600;">
                                        <i class="fa-brands fa-whatsapp"></i> Chat
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php
                                $badge_class = 'badge-gold';
                                if ($inq['division'] == 'Care') $badge_class = 'badge-teal';
                                else if ($inq['division'] == 'Hospitality') $badge_class = 'badge-gold';
                                ?>
                                <span class="badge <?php echo $badge_class; ?>" style="font-size: 0.7rem;"><?php echo $inq['division']; ?></span>
                            </td>
                            <td><div style="font-weight:600;"><?php echo htmlspecialchars($inq['subject']); ?></div></td>
                            <td>
                                <div style="max-width: 300px; font-size: 0.85rem; color: var(--admin-text-muted); overflow-wrap: break-word;">
                                    <?php echo nl2br(htmlspecialchars($inq['message'])); ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                $status_class = 'badge-pending';
                                if ($inq['status'] == 'Read') $status_class = 'badge-completed';
                                else if ($inq['status'] == 'Replied') $status_class = 'badge-confirmed';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $inq['status']; ?></span>
                            </td>
                            <td>
                                <div class="action-buttons" style="flex-direction: column; gap: 4px;">
                                    <div style="display:flex; gap: 4px;">
                                        <a href="messages.php?id=<?php echo $inq['id']; ?>&status=Read" class="action-btn" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(52, 152, 219, 0.3); color: #3498db;" title="Mark Read"><i class="fa-solid fa-envelope-open"></i> Read</a>
                                        <a href="messages.php?id=<?php echo $inq['id']; ?>&status=Replied" class="action-btn" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(46, 204, 113, 0.3); color: #2ecc71;" title="Mark Replied"><i class="fa-solid fa-reply"></i> Replied</a>
                                    </div>
                                    <a href="messages.php?delete=<?php echo $inq['id']; ?>" class="action-btn action-btn-danger" style="padding: 4px 8px; font-size: 0.75rem; border-color: rgba(231, 76, 60, 0.3); justify-content:center;" onclick="return confirm('Are you sure you want to delete this inquiry message?');" title="Delete Message"><i class="fa-solid fa-trash"></i> Delete Message</a>
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
