<?php
require __DIR__ . '/includes/db.php';

$batch = isset($_GET['batch']) ? trim($_GET['batch']) : '';
if ($batch === '') {
    http_response_code(400);
    echo 'Batch number is required';
    exit;
}

$tmpFile = tempnam(sys_get_temp_dir(), 'reports');
$zip = new ZipArchive();
$zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$stmt = $pdo->prepare('SELECT id, file_path FROM reports WHERE batch = ? AND file_path IS NOT NULL');
$stmt->execute([$batch]);
$zipName = 'reports_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $batch) . '.zip';

$found = false;
while ($row = $stmt->fetch()) {
    if (!empty($row['file_path']) && file_exists($row['file_path'])) {
        $zip->addFile($row['file_path'], 'report_' . $row['id'] . '.pdf');
        $found = true;
    }
}
$zip->close();

if (!$found) {
    unlink($tmpFile);
    http_response_code(404);
    echo 'Batch number does not exist';
    exit;
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipName . '"');
readfile($tmpFile);
unlink($tmpFile);
exit;
?>
