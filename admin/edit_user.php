<?php
session_start();

require '../components/connection.php';
require '../components/function.php';
checkAdminAccess();

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ? ");

    $stmt->execute([$username, $email, $role, $user_id]);

    header('Location: admin_dashboard.php?page=lists_users');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if(!$user){
    echo "Kullanıcı Bulunamadı!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Kullanıcı Güncelleme</h2>

        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
                <div class="form-group mb-3">
                    <label for="username">Kullanıcı Adı:</label>
                    <input type="text" class="form-control" name ="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">E Posta:</label>
                    <input type="email" class="form-control" name ="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="role">Kullanıcı Rolü:</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?> >Admin</option>
                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?> >User</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Kullanıcıyı Güncelle</button>
                
        </form>
    </div>
</body>
</html>