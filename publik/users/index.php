<?php
require_once __DIR__ . '/../../app/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../../app/user-functions.php';
$users = getUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Manajemen User</h1>
    <a href="create.php" class="btn btn-primary mb-3">Tambah User</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['name'] ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <a href="edit.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>