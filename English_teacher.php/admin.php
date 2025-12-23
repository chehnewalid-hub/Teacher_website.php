<?php
// ================================
// admin.php
// Admin Dashboard
// ================================
require 'db.php';

// تحقق من تسجيل الدخول (هنا مثال بسيط، لاحقًا يمكن إضافة نظام Login حقيقي)
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// جلب جميع الطلبات
$stmt = $pdo->query("SELECT r.id, r.full_name, r.email, r.message, r.status, r.created_at, s.name AS service_name
                     FROM requests r
                     JOIN services s ON r.service_id = s.id
                     ORDER BY r.created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
th { background: #222; color: #fff; }
.status-new { color: red; font-weight: bold; }
.status-replied { color: green; font-weight: bold; }
</style>
</head>
<body>
<h1>Admin Dashboard</h1>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Service</th>
<th>Message</th>
<th>Status</th>
<th>Created At</th>
<th>Action</th>
</tr>
<?php foreach($requests as $req): ?>
<tr>
<td><?= $req['id'] ?></td>
<td><?= htmlspecialchars($req['full_name']) ?></td>
<td><?= htmlspecialchars($req['email']) ?></td>
<td><?= htmlspecialchars($req['service_name']) ?></td>
<td><?= nl2br(htmlspecialchars($req['message'])) ?></td>
<td class="status-<?= $req['status'] ?>"><?= $req['status'] ?></td>
<td><?= $req['created_at'] ?></td>
<td>
<a href="admin_update.php?id=<?= $req['id'] ?>&status=replied">Mark as Replied</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>