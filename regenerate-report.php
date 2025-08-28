<?php
require __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT file_path FROM reports WHERE id = ?');
$stmt->execute([$id]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    http_response_code(404);
    echo 'Report not found';
    exit;
}

if (!empty($report['file_path']) && file_exists($report['file_path'])) {
    unlink($report['file_path']);
}

$pdo->prepare("UPDATE reports SET status='pending', progress=0, file_path=NULL, generated_at=NULL WHERE id=?")
    ->execute([$id]);

$pdo->prepare("INSERT INTO report_queue (report_id, status, created_at) VALUES (?, 'pending', NOW())")
    ->execute([$id]);

header('Location: index.php');
exit;
?>
