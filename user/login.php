<?php
session_start();
include '../components/connection.php';
include '../components/function.php';

// Hata mesajını tanımla
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST verilerini kontrol et
    if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = authenticatedUser($pdo, $email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: ../home.php');
            exit();
        } else {
            $error = "Geçersiz e-posta veya şifre.";
        }
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Giriş Yap</h2>

                <!-- Hata mesajını göster -->
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Giriş formu -->
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Şifre</label>
                        <input type="password" class="form-control" name="password" required placeholder="Şifre" id="password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                </form>

                <!-- Kayıt ol bağlantısı -->
                <div class="text-center mt-3">
                    <p>Henüz bir hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

