<?php
session_start();
include 'components/connection.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini al
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Veritabanına kaydet
    $query = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query); // Burada $db yerine $pdo kullanmalısınız

    if ($stmt->execute([$name, $email, $message])) {
        echo "Mesajınız başarıyla gönderildi!";
    } else {
        echo "Mesaj gönderilirken bir hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Sayfası</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
      <?php include 'components/header.php'; ?>
    <div class="container mt-5">
        <h1>İletişim</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Adınız:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Mesajınız:</label>
                <textarea class="form-control" name="message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gönder</button>
        </form>
    </div>
    <?php include 'components/footer.php'; ?>
</body>
</html>
