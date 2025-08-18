<?php
require_once __DIR__ . '/../../app/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../../app/product-functions.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Data Produk</h1>
    <a href="create.php" class="btn btn-primary mb-3">Tambah Produk</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Nama</th>
            <th>SKU</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php foreach($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['category_name'] ?></td>
            <td><?= $p['name'] ?></td>
            <td><?= $p['sku'] ?></td>
            <td><?= number_format($p['price']) ?></td>
            <td><?= $p['stock'] ?></td>
            <td>
                <?php if ($p['image']): ?>
                    <img src="/uploads/<?= $p['image'] ?>" width="50">
                <?php endif; ?>
            </td>
            <td>
                <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>