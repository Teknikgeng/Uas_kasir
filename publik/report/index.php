<?php
require_once _DIR_ . '/../../app/auth.php';
requireLogin();

require_once _DIR_ . '/../../app/report-functions.php';

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

$transactions = getSalesReport($start, $end);
$totalOmset = array_sum(array_column($transactions, 'total'));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Laporan Penjualan</h1>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="date" name="start" value="<?= $start ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="end" value="<?= $end ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="print.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-success w-100" target="_blank">Cetak</a>
        </div>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Total</th>
            <th>Bayar</th>
            <th>Kembali</th>
        </tr>
        <?php foreach ($transactions as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['created_at'] ?></td>
            <td><?= $t['cashier_name'] ?></td>
            <td>Rp<?= number_format($t['total']) ?></td>
            <td>Rp<?= number_format($t['paid']) ?></td>
            <td>Rp<?= number_format($t['change']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h4>Total Omset: Rp<?= number_format($totalOmset) ?></h4>
</body>
</html>