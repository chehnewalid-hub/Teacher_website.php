<?php
// ================================
// db.php
// Database connection file
// ================================

$host = "localhost";
$db_name = "english_teacher_site";
$username = "root";      // عدّل إذا لزم
$password = "";          // عدّل إذا لزم

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>