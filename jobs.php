<?php
include 'includes/common-header.php';
require __DIR__ . '/includes/db.php';

// Fetch queue jobs with related report info
$stmt = $pdo->query("SELECT q.id AS qid, q.status, q.created_at, q.updated_at, r.address FROM report_queue q JOIN reports r ON q.report_id = r.id ORDER BY q.id DESC");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid cms-layout">
    <div class="row h-100">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <?php include 'includes/topbar.php' ?>

            <div class="p-2">
                <section class="jobs-section">
                    <div class="container">
                        <h1 class="report-title mb-3">Job Queue</h1>

                        <table class="reports-table bg-light table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Property Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jobs as $job): ?>
                                    <?php
                                    $icons = [
                                        'pending' => 'clock.png',
                                        'processing' => 'play-button.png',
                                        'done' => 'check.png',
                                        'failed' => 'warning.png'
                                    ];
                                    $icon = $icons[$job['status']] ?? 'clock.png';
                                    ?>
                                    <tr data-queue-id="<?= $job['qid'] ?>">
                                        <td><?= $job['qid'] ?></td>
                                        <td><?= htmlspecialchars($job['address']) ?></td>
                                        <td class="status-cell">
                                            <span class="job-status <?= htmlspecialchars($job['status']) ?>" data-status="<?= htmlspecialchars($job['status']) ?>">
                                                <img src="assets/icons/<?= $icon ?>" alt="">
                                                <?= htmlspecialchars(ucfirst($job['status'])) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($job['created_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = Array.from(document.querySelectorAll('tr[data-queue-id]'));
    let pending = rows.filter(r => {
        const status = r.querySelector('.job-status').dataset.status;
        return status === 'pending' || status === 'processing';
    });
    if (!pending.length) return;

    function renderStatus(status) {
        const icons = {
            pending: 'clock.png',
            processing: 'play-button.png',
            done: 'check.png',
            failed: 'warning.png'
        };
        const name = status.charAt(0).toUpperCase() + status.slice(1);
        return `<span class="job-status ${status}" data-status="${status}"><img src="assets/icons/${icons[status]}" alt=""> ${name}</span>`;
    }

    function poll() {
        const ids = pending.map(r => r.dataset.queueId);
        fetch('queue-status.php?ids=' + ids.join(','))
            .then(res => res.json())
            .then(data => {
                pending = pending.filter(row => {
                    const id = row.dataset.queueId;
                    const status = data[id];
                    if (!status) return true;
                    const cell = row.querySelector('.status-cell');
                    cell.innerHTML = renderStatus(status);
                    return status === 'pending' || status === 'processing';
                });
                if (!pending.length) clearInterval(timer);
            });
    }

    const timer = setInterval(poll, 3000);
    poll();
});
</script>
<?php include 'includes/common-footer.php' ?>

