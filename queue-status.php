<?php
require __DIR__ . '/includes/db.php';
header('Content-Type: application/json');

$ids = isset($_GET['ids']) ? array_filter(array_map('intval', explode(',', $_GET['ids']))) : [];
if (empty($ids)) {
    echo json_encode([]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, status FROM report_queue WHERE id IN ($placeholders)");
$stmt->execute($ids);
$out = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $out[$row['id']] = $row['status'];
}
echo json_encode($out);

