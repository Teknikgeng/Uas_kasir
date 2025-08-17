<?php
require_once _DIR_ . '/../../app/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT t.*, u.name AS cashier_name
    FROM transactions t
    JOIN users u ON t.user_id = u.id
    WHERE t.id = ?
");
$stmt->execute([$id]);
$transaction = $stmt->fetch();

$stmtItems = $pdo->prepare("
    SELECT ti.*, p.name
    FROM transaction_items ti
    JOIN products p ON ti.product_id = p.id
    WHERE ti.transaction_id = ?
");
$stmtItems->execute([$id]);
$items = $stmtItems->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk #<?= $transaction['id'] ?></title>
</head>
<body onload="window.print()">
    <h3>Kasir: <?= $transaction['cashier_name'] ?></h3>
    <p>Tanggal: <?= $transaction['created_at'] ?></p>
    <hr>
    <table width="100%">
        <?php foreach($items as $i): ?>
        <tr>
            <td><?= $i['name'] ?> (x<?= $i['qty'] ?>)</td>
            <td align="right">Rp<?= number_format($i['subtotal']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    <p>Total: Rp<?= number_format($transaction['total']) ?></p>
    <p>Bayar: Rp<?= number_format($transaction['paid']) ?></p>
    <p>Kembali: Rp<?= number_format($transaction['change']) ?></p>
    <hr>
    <p>Terima kasih!</p>
</body>
</html>