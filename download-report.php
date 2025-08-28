<?php
require __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT file_path FROM reports WHERE id = ? AND file_path IS NOT NULL');
$stmt->execute([$id]);
$file = $stmt->fetchColumn();

if (!$file || !file_exists($file)) {
    http_response_code(404);
    echo 'Report not found';
    exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="report_' . $id . '.pdf"');
readfile($file);
exit;
?>
