<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configure dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true); // better HTML5 parsing
$options->set('chroot', realpath(__DIR__ . '/pdfhtml'));

// Determine if the pcntl extension is available (not on Windows)
$canFork = function_exists('pcntl_fork');

// Limit of parallel workers (falls back to single process without pcntl)
$maxProcesses = $canFork ? 2 : 1;
$children = [];

if (!$canFork) {
    echo "pcntl extension not available, running in single-process mode" . PHP_EOL;
}

// Shared job handler used by both forked and single-process modes
$handleJob = function ($job) use ($pdo, $options) {
    $start = microtime(true);
    try {
        $report = $job; // available inside template
        ob_start();
        include __DIR__ . '/pdfhtml/index.php';
        $html = ob_get_clean();
        $pdo->prepare("UPDATE reports SET progress=30 WHERE id=?")
            ->execute([$job['id']]);

        $dompdf = new Dompdf($options);
        $basePath = rtrim(realpath(__DIR__ . '/pdfhtml/'), DIRECTORY_SEPARATOR) . '/';
        $dompdf->setBasePath($basePath);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdo->prepare("UPDATE reports SET progress=70 WHERE id=?")
            ->execute([$job['id']]);

        $dir = __DIR__ . '/storage/reports';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $filePath = $dir . '/report_' . $job['id'] . '.pdf';
        file_put_contents($filePath, $dompdf->output());

        $pdo->prepare("UPDATE reports SET file_path=?, generated_at=NOW(), status='completed', progress=100 WHERE id=?")
            ->execute([$filePath, $job['id']]);
        $pdo->prepare("UPDATE report_queue SET status='done', updated_at=NOW() WHERE id=?")
            ->execute([$job['qid']]);

        $time = round(microtime(true) - $start, 2);
        echo "Report {$job['id']} generated in {$time}s" . PHP_EOL;
    } catch (Exception $e) {
        $pdo->prepare("UPDATE reports SET status='failed', progress=100 WHERE id=?")
            ->execute([$job['id']]);
        $pdo->prepare("UPDATE report_queue SET status='failed', updated_at=NOW() WHERE id=?")
            ->execute([$job['qid']]);
        $time = round(microtime(true) - $start, 2);
        echo "Report {$job['id']} failed after {$time}s: {$e->getMessage()}" . PHP_EOL;
    }
};

while (true) {
    // clean up finished child processes if forking is supported
    if ($canFork) {
        foreach ($children as $pid => $unused) {
            $res = pcntl_waitpid($pid, $status, WNOHANG);
            if ($res > 0) {
                unset($children[$pid]);
            }
        }
    }

    // If we are already running max workers, wait a moment
    if ($canFork && count($children) >= $maxProcesses) {
        usleep(500000); // 0.5s
        continue;
    }

    $job = $pdo->query("SELECT q.id as qid, r.* FROM report_queue q JOIN reports r ON q.report_id=r.id WHERE q.status='pending' ORDER BY q.id ASC LIMIT 1")->fetch();
    if (!$job) {
        // If no work and no children, sleep longer
        if (empty($children)) {
            sleep(5);
        } else {
            usleep(500000);
        }
        continue;
    }

    // mark as processing and set initial progress
    $pdo->prepare("UPDATE report_queue SET status='processing', updated_at=NOW() WHERE id=?")
        ->execute([$job['qid']]);
    $pdo->prepare("UPDATE reports SET progress=10 WHERE id=?")
        ->execute([$job['id']]);

    if ($canFork) {
        $pid = pcntl_fork();
        if ($pid == -1) {
            // Fork failed
            $pdo->prepare("UPDATE reports SET status='failed', progress=100 WHERE id=?")
                ->execute([$job['id']]);
            $pdo->prepare("UPDATE report_queue SET status='failed', updated_at=NOW() WHERE id=?")
                ->execute([$job['qid']]);
            continue;
        } elseif ($pid) {
            // Parent process: track child and continue loop
            $children[$pid] = true;
            continue;
        }

        $handleJob($job);
        exit(0); // child exits
    } else {
        // No pcntl available - handle job synchronously
        $handleJob($job);
        continue;
    }
}
?>
