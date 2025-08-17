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
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Penjualan</h2>
    <?php if ($start && $end): ?>
        <p>Periode: <?= $start ?> s/d <?= $end ?></p>
    <?php elseif ($start): ?>
        <p>Mulai dari: <?= $start ?></p>
    <?php elseif ($end): ?>
        <p>Sampai: <?= $end ?></p>
    <?php else: ?>
        <p>Semua Transaksi</p>
    <?php endif; ?>

    <table>
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