<?php
// includes/common-header.php
// Put this at top of pages where you include header (before any output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Optional: include auth helpers
require_once __DIR__ . '/auth.php';
require_login();

// You can add global meta, CSS links here if desired
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reliant CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css" media="all">

</head>

<body>
