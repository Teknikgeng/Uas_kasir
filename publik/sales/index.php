<?php
require_once _DIR_ . '/../../app/auth.php';
requireLogin();

require_once _DIR_ . '/../../app/product-functions.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$products = getProducts();
$cart = $_SESSION['cart'];

$total = array_sum(array_map(function($item) {
    return $item['price'] * $item['qty'];
}, $cart));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Transaksi Penjualan</h1>

    <!-- Form tambah item -->
    <form method="POST" action="add-item.php" class="row g-2 mb-3">
        <div class="col-md-6">
            <select name="product_id" class="form-select" required>
                <option value="">Pilih Produk</option>
                <?php foreach($products as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?> - Rp<?= number_format($p['price']) ?> (Stok: <?= $p['stock'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="qty" class="form-control" placeholder="Qty" required min="1">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Tambah</button>
        </div>
    </form>

    <!-- Tabel Keranjang -->
    <table class="table table-bordered">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
        <?php foreach($cart as $id => $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= number_format($item['price']) ?></td>
            <td><?= $item['qty'] ?></td>
            <td><?= number_format($item['price'] * $item['qty']) ?></td>
            <td>
                <a href="remove-item.php?id=<?= $id ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3">Total</th>
            <th colspan="2">Rp<?= number_format($total) ?></th>
        </tr>
    </table>

    <!-- Form pembayaran -->
    <?php if ($total > 0): ?>
    <form method="POST" action="checkout.php">
        <div class="mb-3">
            <label>Bayar</label>
            <input type="number" name="paid" class="form-control" required min="<?= $total ?>">
        </div>
        <button class="btn btn-success w-100">Simpan Transaksi & Cetak Struk</button>
    </form>
    <?php endif; ?>
</body>
</html>