<?php
// Authentication helper functions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensure the user is logged in. Redirects to login.php if not.
 */
function require_login(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Ensure the current user has one of the allowed roles.
 *
 * @param string|array $roles Allowed role or roles
 */
function require_role($roles): void
{
    require_login();
    $role = $_SESSION['role'] ?? '';
    if (!in_array($role, (array) $roles, true)) {
        header('Location: index.php');
        exit;
    }
}

?>

