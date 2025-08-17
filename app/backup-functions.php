<?php
function backupDatabase($host, $user, $pass, $dbname, $savePath) {
    $filename = $savePath . "/backup_" . date("Y-m-d_H-i-s") . ".sql";
    $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$dbname} > {$filename}";
    system($command);
    return $filename;
}