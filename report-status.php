<?php
require __DIR__ . '/includes/db.php';
header('Content-Type: application/json');
$ids = isset($_GET['ids']) ? array_filter(array_map('intval', explode(',', $_GET['ids']))) : [];
if (empty($ids)) {
    echo json_encode([]);
    exit;
}
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, status, file_path, progress FROM reports WHERE id IN ($placeholders)");
$stmt->execute($ids);
$result = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[$row['id']] = [
        'status' => $row['status'],
        'file_path' => $row['file_path'],
        'progress' => (int) $row['progress']
    ];
}
echo json_encode($result);
?>
