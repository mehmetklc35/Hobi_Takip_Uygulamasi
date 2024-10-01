<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require '../components/connection.php';
require_once '../components/connection.php';

checkAdminAccess();

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>list_users page</title>
</head>
<body>
    <div class="container mt-4">

        <h2>Kullanıcılar</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kullanıcı Adı</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']);?></td>
                        <td><?php echo htmlspecialchars($user['email']);?></td>
                        <td><?php echo htmlspecialchars($user['role']);?></td>
                        <td><?php echo htmlspecialchars($user['created_at']);?></td>
                        <td>
                        <a href="edit_user.php?id=<?php echo $user['id'];?>" class="btn btn-warning btn-sm">Güncelle</a>
                        <a href="delete_user.php?id=<?php echo $user['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz ?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>
</html>