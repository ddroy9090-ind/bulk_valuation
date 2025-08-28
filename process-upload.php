<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['excel']['tmp_name'])) {
    http_response_code(400);
    echo 'No file uploaded';
    exit;
}

// Extract images if a zip file is provided
$imageDir = null;
$imageDirRelative = null;
if (!empty($_FILES['images']['tmp_name'])) {
    $zip = new ZipArchive();
    if ($zip->open($_FILES['images']['tmp_name']) === TRUE) {
        $folder = time();
        $imageDirRelative = 'img/uploads/' . $folder;
        $imageDir = __DIR__ . '/pdfhtml/' . $imageDirRelative;
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
        $zip->extractTo($imageDir);
        $zip->close();
    }
}

$spreadsheet = IOFactory::load($_FILES['excel']['tmp_name']);
$rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
$headers = array_map('trim', $rows[1]);
unset($rows[1]);

$map = [
    'BATCH' => 'batch',
    'Date Of Instructions' => 'date_of_instructions',
    'Reliant Reference Number' => 'reliant_reference_number',
    'Bank Reference Number' => 'bank_reference_number',
    'Prepared For' => 'prepared_for',
    'Client Name' => 'client_name',
    'Property Type' => 'property_type',
    'Property Address' => 'address',
    'Location (Coordinates)' => 'location_coordinates',
    'Property Description' => 'property_description',
    'Property Occupancy' => 'property_occupancy',
    'Property Tenure' => 'property_tenure',
    'Property Status' => 'property_status',
    'Developer' => 'developer',
    'Floors' => 'floors',
    'BUA (Sq. M.)' => 'bua_sqm',
    'BUA (Sq. Ft.)' => 'bua_sqft',
    'Land Plot Size (Sq. M.)' => 'land_plot_size_sqm',
    'Land Plot Size (Sq. Ft.)' => 'land_plot_size_sqft',
    'Purpose of Valuation' => 'purpose_of_valuation',
    'Date of Valuation' => 'date_of_valuation',
    'Capacity of Valuer' => 'capacity_of_valuer',
    'Method of Valuation' => 'method_of_valuation',
    'Transaction Range' => 'transaction_range',
    'Adopted Rate per Sq. Ft. (Subject Property)' => 'adopted_rate_per_sqft',
    'Market Value (Rounded)' => 'market_value_rounded',
    'Subject to Valuation' => 'subject_to_valuation',
    'Forced Sale Value (AED)' => 'forced_sale_value_aed',
    'Annual Rent (AED)' => 'annual_rent_aed',
    'Comparable Table (Image)' => 'comparable_image',
];

$columns = implode(',', array_values($map)) . ',status';
$placeholders = ':' . implode(',:', array_values($map)) . ',:status';
$sql = "INSERT INTO reports ($columns, created_at) VALUES ($placeholders, NOW())";
$stmt = $pdo->prepare($sql);

foreach ($rows as $row) {
    if (empty(array_filter($row))) {
        continue; // skip empty rows
    }
    $record = [];
    foreach ($headers as $col => $header) {
        $record[$header] = $row[$col] ?? null;
    }
    $data = [];
    foreach ($map as $header => $colName) {
        $data[$colName] = $record[$header] ?? null;
    }

    $imageName = $data['comparable_image'] ?? null;
    $imagePath = null;
    if ($imageName && $imageDir && $imageDirRelative) {
        $files = glob($imageDir . '/' . pathinfo($imageName, PATHINFO_FILENAME) . '.*');
        if ($files) {
            $imagePath = $imageDirRelative . '/' . basename($files[0]);
        }
    }
    $data['comparable_image'] = $imagePath;

    if (!empty($data['date_of_valuation'])) {
        $ts = strtotime($data['date_of_valuation']);
        $data['date_of_valuation'] = $ts ? date('Y-m-d', $ts) : null;
    }

    if (!empty($data['date_of_instructions'])) {
        $ts = strtotime($data['date_of_instructions']);
        $data['date_of_instructions'] = $ts ? date('Y-m-d', $ts) : null;
    }

    $data['status'] = 'pending';
    $stmt->execute($data);
    $reportId = $pdo->lastInsertId();
    $pdo->prepare('INSERT INTO report_queue (report_id, status, created_at) VALUES (?,?,NOW())')
        ->execute([$reportId, 'pending']);
}

header('Location: index.php?uploaded=1');
exit;
?>
