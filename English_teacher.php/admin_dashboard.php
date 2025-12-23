<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$stmt = $pdo->query("
    SELECT requests.*, services.name AS service_name
    FROM requests
    JOIN services ON services.id = requests.service_id
    ORDER BY created_at DESC
");

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Admin Dashboard</h2>
<a href="admin_logout.php">Logout</a>
<hr>

<table border="1" cellpadding="8">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Service</th>
        <th>Message</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach ($requests as $req): ?>
    <tr>
        <td><?php echo htmlspecialchars($req['full_name']); ?></td>
        <td><?php echo htmlspecialchars($req['email']); ?></td>
        <td><?php echo htmlspecialchars($req['service_name']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($req['message'])); ?></td>
        <td><?php echo $req['status']; ?></td>
        <td>
            <form action="admin_update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $req['id']; ?>">
                <select name="status">
                    <option value="new">new</option>
                    <option value="replied">replied</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>