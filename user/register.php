<?php
session_start();
include '../components/connection.php'; // Veritabanı bağlantısı

// Kullanıcı kayıt işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Şifre doğrulama
    if ($password !== $password_confirm) {
        $error = "Şifreler eşleşmiyor.";
    } else {
        // Kullanıcı adı kontrolü
        $query = "SELECT * FROM Users WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $error = "Kullanıcı adı zaten alınmış.";
        } else {
            // E-posta kontrolü
            $emailQuery = "SELECT * FROM Users WHERE email = ?";
            $emailStmt = $pdo->prepare($emailQuery);
            $emailStmt->execute([$email]);

            if ($emailStmt->rowCount() > 0) {
                $error = "E-posta adresi zaten kayıtlı.";
            } else {
                // Kullanıcı kaydetme
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO Users (username, email, password) VALUES (?, ?, ?)";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->execute([$username, $email, $hashed_password]);

                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header('Location: login.php'); 
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Kayıt Ol</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Şifreyi Onayla:</label>
                <input type="password" class="form-control" name="password_confirm" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Kayıt Ol</button>
        </form>

        <a href="login.php" class="btn btn-link mt-3">Zaten bir hesabınız var mı? Giriş yapın</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
