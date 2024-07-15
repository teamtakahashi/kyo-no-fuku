<?php
$serverName = "kyofuku.database.windows.net";
$database = "kyoufuku_db";
$username = "oomoto";
$password = "FStKV6rvFqypNdG";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
