<?php
include 'includes/common-header.php';
require __DIR__ . '/includes/db.php';

$totalReports = $pdo->query('SELECT COUNT(*) FROM reports')->fetchColumn();
$completedReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='completed'")->fetchColumn();

$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $perPage;
$stmt = $pdo->prepare('SELECT id,batch,address,status,created_at,file_path FROM reports ORDER BY created_at DESC LIMIT ? OFFSET ?');
$stmt->bindValue(1, $perPage, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll();
$totalPages = (int) ceil($totalReports / $perPage);
?>

<div class="container-fluid cms-layout">
    <div class="row h-100">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <!-- Top Navbar -->
            <?php include 'includes/topbar.php' ?>

            <!-- Dashboard Content -->
            <div class="p-2">
                <section class="cms-section py-4">
                    <div class="container">

                        <!-- Top Stats -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <h6>Total Reports <img src="assets/icons/report.png" alt="" width="16"></h6>
                                    <p><?= $totalReports ?></p>
                                    <span class="text-success">100% from last month</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <h6>Completed <img src="assets/icons/check.png" alt="" width="16"></h6>
                                    <p><?= $completedReports ?></p>
                                    <span class="text-success">100% completion rate</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <h6>Processing <img src="assets/icons/clock.png" alt="" width="16"></h6>
                                    <p>0</p>
                                    <span class="text-muted">Currently in progress</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <h6>Failed <img src="assets/icons/warning.png" alt="" width="16"></h6>
                                    <p>0</p>
                                    <span class="text-danger">Requires attention</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload + Generate -->
                        <form class="row g-3" method="POST" action="process-upload.php" enctype="multipart/form-data">

                            <!-- Upload Excel File -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100 uploadfile">
                                    <h5 class="title d-flex align-items-center gap-2">
                                        <img src="assets/icons/upload.png" alt="" width="16">
                                        Upload Excel File
                                    </h5>
                                    <p class="mb-3 text-muted">
                                        Upload your Excel file containing property data to generate bulk valuation
                                        reports
                                    </p>

                                    <label for="fileUpload"
                                        class="upload-box d-flex flex-column align-items-center justify-content-center text-center p-4">
                                        <img src="assets/icons/report.png" alt="Excel" width="40" class="mb-2">
                                        <strong> your Excel file here</strong>
                                        <span class="text-muted">Supports .xlsx and .xls files up to 10MB</span>

                                        <label for="fileUpload"
                                            class="browse-btn mt-3 d-inline-flex align-items-center gap-2">
                                            <img src="assets/icons/upload.png" alt="" width="16">
                                            Browse Files
                                        </label>
                                        <input type="file" id="fileUpload" name="excel" accept=".xlsx,.xls" hidden>
                                    </label>

                                    

                                    <!-- Progress Bar -->
                                    <div class="progress mt-3" style="height: 20px; display: none;"
                                        id="progressContainer">
                                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Generate Reports -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100 generate-card">
                                    <!-- Upload Images Zip -->
                                    <label for="imageZip"
                                        class="upload-box d-flex flex-column align-items-center justify-content-center text-center p-4 mt-3">
                                        <img src="assets/icons/upload.png" alt="Images" width="40" class="mb-2">
                                        <strong>your images ZIP here</strong>
                                        <span class="text-muted">Supports .zip files up to 50MB</span>

                                        <label for="imageZip"
                                            class="browse-btn mt-3 d-inline-flex align-items-center gap-2">
                                            <img src="assets/icons/upload.png" alt="" width="16">
                                            Browse Files
                                        </label>
                                        <input type="file" id="imageZip" name="images" accept=".zip" hidden>
                                    </label>
                                    <h5 class="fw-bold mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-zap w-5 h-5">
                                            <path
                                                d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                            </path>
                                        </svg> Generate Reports
                                    </h5>
                                    <p class="mb-3 text-muted">Upload an Excel file to start generating reports</p>
                                    <button type="submit" class="btn w-100 text-white">
                                        <img src="assets/icons/play-button.png" alt="" width="20px" style="filter:invert(1);"> Generate Bulk Reports
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>

                <!-- Reports Section -->
                <div class="reports-section">
                    <div class="container">
                        <div class="row-g-3">
                            <div class="col-lg-12">
                                <div class="reports-table-wrapper">
                                    <div class="reports-header">
                                        <div class="reports-title-box">
                                            <img src="assets/icons/report.png" alt="Reports" class="title-icon">
                                            <div>
                                                <h2 class="reports-title">Generated Reports</h2>
                                            </div>
                                        </div>
                                        <form class="d-flex" method="get" action="download-all.php">
                                            <input type="text" name="batch" class="form-control" placeholder="Batch"
                                                style="max-width:150px;" required>
                                            <button type="submit" class="download-all-btn ms-2">
                                                <img src="assets/icons/download.png" alt="Download" class="btn-icon">
                                                Download Batch
                                            </button>
                                        </form>
                                    </div>
                                    <table class="reports-table">
                                        <thead>
                                            <tr>
                                                <th>Batch</th>
                                                <th>Property Address</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reports as $r): ?>
                                                <tr data-report-id="<?= $r['id'] ?>">
                                                    <td><?= htmlspecialchars($r['batch']) ?></td>
                                                    <td><?= htmlspecialchars($r['address']) ?></td>
                                                    <td class="status-cell"><span
                                                            class="status <?= htmlspecialchars($r['status']) ?>"><?= htmlspecialchars(ucfirst($r['status'])) ?></span>
                                                    </td>
                                                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                                                    <td class="actions download-cell">
                                                        <?php if ($r['file_path']): ?>
                                                            <a href="download-report.php?id=<?= $r['id'] ?>"><img
                                                                    src="assets/icons/download.png" alt="Download"
                                                                    class="action-icon me-1"></a>
                                                            <a href="regenerate-report.php?id=<?= $r['id'] ?>"><img
                                                                    src="assets/icons/play-button.png" alt="Regenerate"
                                                                    class="action-icon"></a>
                                                        <?php else: ?>
                                                            <div class="progress" style="width:100px;height:20px;">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                    style="width:0%"></div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php if ($totalPages > 1): ?>
                                        <nav aria-label="Reports pagination">
                                            <ul class="pagination">
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a
                                                            class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                                                <?php endfor; ?>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = Array.from(document.querySelectorAll('tr[data-report-id]'));
        let pending = rows.filter(r => r.querySelector('.progress-bar'));
        if (pending.length === 0) return;
        function poll() {
            const ids = pending.map(r => r.dataset.reportId);
            fetch('report-status.php?ids=' + ids.join(','))
                .then(res => res.json())
                .then(data => {
                    pending = pending.filter(row => {
                        const id = row.dataset.reportId;
                        const info = data[id];
                        if (!info) return true;
                        const statusCell = row.querySelector('.status-cell');
                        const downloadCell = row.querySelector('.download-cell');
                        if (info.status === 'completed' && info.file_path) {
                            statusCell.innerHTML = '<span class="status completed">Completed</span>';
                            downloadCell.innerHTML = '<a href="view-report.php?id=' + id + '" target="_blank"><img src="assets/icons/view.png" alt="View" class="action-icon me-1"></a>' +
                                '<a href="download-report.php?id=' + id + '"><img src="assets/icons/download.png" alt="Download" class="action-icon me-1"></a>' +
                                '<a href="regenerate-report.php?id=' + id + '"><img src="assets/icons/play-button.png" alt="Regenerate" class="action-icon"></a>';
                            return false;
                        }
                        if (info.status === 'failed') {
                            statusCell.innerHTML = '<span class="status failed">Failed</span>';
                            downloadCell.textContent = 'Failed';
                            return false;
                        }
                        const bar = downloadCell.querySelector('.progress-bar');
                        if (bar && typeof info.progress !== 'undefined') {
                            bar.style.width = info.progress + '%';
                            bar.textContent = info.progress + '%';
                        }
                        return true;
                    });
                    if (pending.length === 0) clearInterval(timer);
                });
        }
        const timer = setInterval(poll, 3000);
        poll();
    });
</script>
<?php include 'includes/common-footer.php' ?>