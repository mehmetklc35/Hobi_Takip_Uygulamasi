<?php
session_start();
require '../components/connection.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password){
        $error = "Şifreler uyuşmuyor.";
    }else{
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->fetch()){
            $error = "Bu e-posta adresi zaten kayıtlı.";
        }else{
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password) VALUES(?,?,?)");
            $stmt->execute([$username,$email,$hashed_password]);

            echo "Kayıt başarılı! Giriş Yapabilirsiniz.";
            header('Refresh: 2; URL=login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Kayıt Ol</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Kayıt Ol</h2>
        <?php if(isset($error)):?>
            <div class="alert alert-danger"><?php echo $error ?></div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">E-Posta</label>
                <input type="text" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password" class="form-label">Şifre Onayla</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Kayıt Ol</button>
            <p class="mt-3">Zaten hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
        </form>
    </div>
</body>
</html>