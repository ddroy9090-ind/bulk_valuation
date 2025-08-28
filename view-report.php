<?php
require __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM reports WHERE id = ?');
$stmt->execute([$id]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    http_response_code(404);
    echo 'Report not found';
    exit;
}

// Determine the correct base path for assets relative to this script.
// This ensures images and other resources load correctly even when the
// application is hosted in a subdirectory rather than the web root.
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$baseHref = $basePath . '/pdfhtml/';

include __DIR__ . '/pdfhtml/index.php';

