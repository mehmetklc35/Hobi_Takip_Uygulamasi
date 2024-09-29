<?php
session_start();
include 'components/connection.php'; // Veritabanı bağlantısı

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

// Kullanıcının hobilerini al
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM Hobbies WHERE user_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Yeni hobi ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_hobby'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token mismatch');
    }

    $hobby_name = $_POST['hobby_name'];
    $description = $_POST['description'];

    $insertQuery = "INSERT INTO Hobbies (user_id, hobby_name, description) VALUES (?, ?, ?)";
    $insertStmt = $db->prepare($insertQuery);
    
    if (!$insertStmt->execute([$user_id, $hobby_name, $description])) {
        echo "Hobi eklenirken bir hata oluştu.";
    } else {
        header('Location: include/home.php'); // Sayfayı yenile
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hobi Takip Uygulaması</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Hobi Takip Uygulaması</h1>
        <h2>Hoş geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <h3>Hobilerim</h3>
        <ul class="list-group mb-4">
            <?php foreach ($hobbies as $hobby): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($hobby['hobby_name']); ?></strong>: 
                    <?php echo htmlspecialchars($hobby['description']); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3>Yeni Hobi Ekle</h3>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="hobby_name">Hobi Adı:</label>
                <input type="text" class="form-control" name="hobby_name" required>
            </div>
            <div class="form-group">
                <label for="description">Açıklama:</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <button type="submit" name="add_hobby" class="btn btn-primary">Ekle</button>
        </form>

        <a href="logout.php" class="btn btn-danger mt-4">Çıkış Yap</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
