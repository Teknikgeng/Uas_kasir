<?php
require_once __DIR__ . '/../../app/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../../app/backup-functions.php';

$message = null;

if (isset($_POST['backup'])) {
    $file = backupDatabase("localhost", "root", "", "kasir_db", __DIR__);
    $message = "Backup berhasil dibuat: <a href='" . basename($file) . "' download>Download Backup</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Backup Database</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Backup Database</h1>
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <button name="backup" class="btn btn-primary">Buat Backup</button>
    </form>
</body>
</html>