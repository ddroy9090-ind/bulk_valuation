<?php
include 'includes/common-header.php';
require __DIR__ . '/includes/db.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $perPage;
$baseSql = 'FROM reports WHERE file_path IS NOT NULL';
$params = [];
if ($q !== '') {
    $baseSql .= ' AND (batch LIKE ? OR address LIKE ?)';
    $params = ["%$q%", "%$q%"];
}
$totalStmt = $pdo->prepare('SELECT COUNT(*) ' . $baseSql);
$totalStmt->execute($params);
$total = $totalStmt->fetchColumn();
$totalPages = (int) ceil($total / $perPage);
$sql = 'SELECT id,batch,address,status,created_at,file_path ' . $baseSql . ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
$stmt = $pdo->prepare($sql);
$idx = 1;
foreach ($params as $p) {
    $stmt->bindValue($idx++, $p);
}
$stmt->bindValue($idx++, $perPage, PDO::PARAM_INT);
$stmt->bindValue($idx++, $offset, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll();
?>
<div class="container-fluid cms-layout">
    <div class="row h-100">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <?php include 'includes/topbar.php' ?>

            <div class="p-2">
                <section class="reports-wrapper">
                    <div class="container">

                        <!-- Title -->
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-8">
                                <div class="report-library">
                                    <h1 class="report-title">Reports Library</h1>
                                    <p>Browse and manage all your generated valuation reports</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <button class="btn btn-light action-btn me-2">
                                    <img src="assets/icons/filter.png" width="16" alt=""> Filter
                                </button>
                                <button class="btn btn-danger action-btn">
                                    <img src="assets/icons/download.png" width="16" alt=""> Download All
                                </button>
                            </div>
                        </div>

                        <!-- Search & Actions -->
                        <div class="row mb-4 align-items-center justify-content-center">
                            <div class="col-lg-12">
                                <form method="get">
                                    <div class="search-bar-two">
                                        <input type="text" name="q" class="form-control search-box"
                                            placeholder="Search batch or address" value="<?= htmlspecialchars($q) ?>">
                                        <button style="border: none;" type="submit"><span><img
                                                    src="assets/icons/search.png" alt="" width="14"></span></button>
                                    </div>
                                </form>
                            </div>

                        </div>


                        <!-- Summary Cards -->
                        <div class="row g-3 mb-4 d-none">
                            <div class="col-md-4">
                                <div class="summary-card">
                                    <div>
                                        <p class="mb-1">Total Reports</p>
                                        <h5 class="fw-bold mb-1">3</h5>
                                        <small>Generated reports</small>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-file-text h-4 w-4 text-muted-foreground"
                                        data-lov-id="src/pages/ReportsLibrary.tsx:137:16" data-lov-name="FileText"
                                        data-component-path="src/pages/ReportsLibrary.tsx" data-component-line="137"
                                        data-component-file="ReportsLibrary.tsx" data-component-name="FileText"
                                        data-component-content="%7B%22className%22%3A%22h-4%20w-4%20text-muted-foreground%22%7D">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card">
                                    <div>
                                        <p class="mb-1">Total Value</p>
                                        <h5 class="fw-bold mb-1">$7.5M</h5>
                                        <small>Combined valuations</small>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-dollar-sign h-4 w-4 text-muted-foreground"
                                        data-lov-id="src/pages/ReportsLibrary.tsx:148:16" data-lov-name="DollarSign"
                                        data-component-path="src/pages/ReportsLibrary.tsx" data-component-line="148"
                                        data-component-file="ReportsLibrary.tsx" data-component-name="DollarSign"
                                        data-component-content="%7B%22className%22%3A%22h-4%20w-4%20text-muted-foreground%22%7D">
                                        <line x1="12" x2="12" y1="2" y2="22"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card">
                                    <div>
                                        <p class="mb-1">This Month</p>
                                        <h5 class="fw-bold mb-1">12</h5>
                                        <small>Reports generated</small>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-calendar h-4 w-4 text-muted-foreground"
                                        data-lov-id="src/pages/ReportsLibrary.tsx:159:16" data-lov-name="Calendar"
                                        data-component-path="src/pages/ReportsLibrary.tsx" data-component-line="159"
                                        data-component-file="ReportsLibrary.tsx" data-component-name="Calendar"
                                        data-component-content="%7B%22className%22%3A%22h-4%20w-4%20text-muted-foreground%22%7D">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                        <path d="M3 10h18"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Report List Cards -->
                        <div class="row g-3">
                            <!-- Card 1 -->
                            <?php foreach ($reports as $r): ?>
                                <div class="col-md-4 d-flex"> <!-- d-flex add kiya -->
                                    <div class="report-card flex-fill d-flex flex-column">
                                        <!-- flex-fill aur flex-column -->
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="status-badge"><?= htmlspecialchars(ucfirst($r['status'])) ?></span>
                                            <span class="text-muted small"><?= htmlspecialchars($r['batch']) ?></span>
                                        </div>
                                        <p class="mb-3 d-flex align-items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="#d01f28" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-4 h-4 text-muted-foreground me-1">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <span style="font-size: 13px;"><?= htmlspecialchars($r['address']) ?></span>
                                        </p>
                                        <!-- <h6 class="price">N/A</h6>
                                        <p class="mb-3"><small>Client: John Smith</small></p> -->
                                        <p class="mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="#d01f28" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar w-4 h-4 me-1">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>

                                            <small><?= htmlspecialchars($r['created_at']) ?></small>
                                        </p>

                                        <!-- Push buttons to bottom -->
                                        <div class="mt-auto d-flex justify-content-end gap-2">
                                            <a href="view-report.php?id=<?= $r['id'] ?>" target="_blank"
                                                class="btn btn-light btn-sm view-btn d-none">
                                                <img src="assets/icons/view.png" width="14" alt=""> View
                                            </a>
                                            <a href="download-report.php?id=<?= $r['id'] ?>"
                                                class="btn btn-danger btn-sm download-btn">
                                                <img src="assets/icons/download.png" width="14" alt=""> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Reports pagination">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link"
                                                href="?q=<?= urlencode($q) ?>&page=<?= $i ?>"><?= $i ?></a></li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/common-footer.php' ?>