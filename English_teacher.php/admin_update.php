<?php
require 'db.php';
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$status = $_GET['status'] ?? 'new';

if($id > 0 && in_array($status, ['new','replied'])){
    $stmt = $pdo->prepare("UPDATE requests SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);
}

header('Location: admin.php');
exit;
?>