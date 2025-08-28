<div class="col-auto sidebar" id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <button class="icon-btn" id="menuBtn"><img src="assets/icons/menu.png" alt="Menu"></button>
        <a href="index.php"><img src="assets/images/logo/logo.png" alt="Reliant Logo" class="logo"></a>
        <button class="icon-btn hide" id="closeBtn"><img src="assets/icons/close.png" alt="Close"></button>
    </div>

    <!-- Sidebar Menu -->
    <!-- <ul>
        <li>
            <a href="index.php" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                <img src="assets/icons/home.png" alt="Dashboard" class="icon">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="upload-reports.php" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                <img src="assets/icons/upload.png" alt="Upload" class="icon">
                <span>Upload Reports</span>
            </a>
        </li>
        <li>
            <a href="reports.php" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                <img src="assets/icons/report.png" alt="Reports" class="icon">
                <span>Reports Library</span>
            </a>
        </li>
        <li>
            <a href="analytics.php" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                <img src="assets/icons/analytics.png" alt="Analytics" class="icon">
                <span>Analytics</span>
            </a>
        </li>
        <li>
            <a href="settings.php" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                <img src="assets/icons/setting.png" alt="Settings" class="icon">
                <span>Settings</span>
            </a>
        </li>
    </ul> -->

    <ul>
        <li><a href="index.php"><img src="assets/icons/home.png" class="icon" alt=""><span>Dashboard</span></a></li>
        <li><a href="reports-library.php"><img src="assets/icons/report.png" class="icon" alt=""><span>Reports Library</span></a></li>
        <?php if (($_SESSION['role'] ?? '') === 'Admin'): ?>
        <li><a href="users.php"><img src="assets/icons/user.png" class="icon" alt=""><span>Users</span></a></li>
        <?php endif; ?>
    </ul>

</div>