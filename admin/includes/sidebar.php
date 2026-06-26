<?php
/**
 * CleVista Group Limited - Admin Sidebar Component
 * Displays administration section links and highlights current active panel.
 */
$admin_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
    <div class="admin-sidebar-header">
        <span class="admin-sidebar-logo">CLEVISTA</span>
        <span class="admin-sidebar-tag">Control Console</span>
    </div>
    
    <ul class="admin-sidebar-menu">
        <li class="admin-menu-item <?php echo ($admin_page == 'index.php') ? 'active' : ''; ?>">
            <a href="index.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        </li>
        <li class="admin-menu-item <?php echo ($admin_page == 'estates.php') ? 'active' : ''; ?>">
            <a href="estates.php"><i class="fa-solid fa-hotel"></i> Properties</a>
        </li>
        <li class="admin-menu-item <?php echo ($admin_page == 'hospitality.php') ? 'active' : ''; ?>">
            <a href="hospitality.php"><i class="fa-solid fa-umbrella-beach"></i> Stays & Stays</a>
        </li>
        <li class="admin-menu-item <?php echo ($admin_page == 'care.php') ? 'active' : ''; ?>">
            <a href="care.php"><i class="fa-solid fa-screwdriver-wrench"></i> Bookings & Care</a>
        </li>
        <li class="admin-menu-item <?php echo ($admin_page == 'messages.php') ? 'active' : ''; ?>">
            <a href="messages.php"><i class="fa-solid fa-inbox"></i> Inbox Messages</a>
        </li>
        
        <li class="admin-menu-item" style="margin-top: auto; border-top: 1px solid var(--admin-border);">
            <a href="../index.php" target="_blank"><i class="fa-solid fa-globe"></i> View Live Site</a>
        </li>
        <li class="admin-menu-item">
            <a href="logout.php" style="color: var(--status-cancelled);"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
        </li>
    </ul>
</aside>
