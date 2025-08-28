<?php
session_start();

// agar user login nahi hai to login page par bhejo
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// agar logout par click kare to session destroy
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<div class="top-navbar">
    <h2>Bulk Valuation Reports &nbsp; <span> &nbsp; Reliant Surveyors</span></h2>
    <div class="right-nav">
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <span><img src="assets/icons/search.png" alt="" width="14"></span>
        </div>
        <div class="user-menu" id="userMenu">
            <img src="assets/icons/profile.png" alt="User">
            <!-- yahan session ka username show hoga -->
            <h6><?php echo htmlspecialchars($_SESSION['username']); ?></h6>
            <ul class="dropdown-menu" id="dropdownMenu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="?logout=true">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
