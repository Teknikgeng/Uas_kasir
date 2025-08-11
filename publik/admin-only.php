<?php
require_once _DIR_ . '/../app/auth.php';
requireLogin();
requireRole('admin'); // hanya admin yang bisa masuk
?>
<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
</head>
<body>
    <h1>Halo Admin <?= $_SESSION['user']['name'] ?></h1>
    <a href="logout.php">Logout</a>
</body>
</html>