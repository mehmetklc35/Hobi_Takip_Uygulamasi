<?php
session_start();
include 'components/connection.php'; // Veritabanı bağlantısı

// Kullanıcının hobilerini al
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM Hobbies WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $hobbies = []; // Kullanıcı giriş yapmamışsa boş hobi listesi
}

// Yeni hobi ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_hobby'])) {
    if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token mismatch');
    }

    $hobby_name = $_POST['hobby_name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url']; // Hobi resmi için alan

    $insertQuery = "INSERT INTO Hobbies (user_id, hobby_name, description, image_url) VALUES (?, ?, ?, ?)";
    $insertStmt = $pdo->prepare($insertQuery);

    if (!$insertStmt->execute([$user_id, $hobby_name, $description, $image_url])) {
        echo "Hobi eklenirken bir hata oluştu.";
    } else {
        header('Location: home.php'); // Sayfayı yenile
        exit();
    }
}

// CSRF token'ı oluştur
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
    <?php include 'components/header.php'; ?> <!-- Header dosyasını dahil ettik --> 

  <div class="container marketing">
    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4 mt-4">
      <img class="bd-placeholder-img rounded-circle" width="140" height="140" src="image/yürüyüş.jpg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em"></text></img>

        <h2>Yürüyüş</h2>
        <p>Hem bedensel hem de zihinsel sağlığa faydalıdır. Yürüyüş, stresi azaltmaya, kilo vermek için yardımcı olmaya, kalp sağlığını korumaya ve genel olarak daha sağlıklı bir yaşam tarzı sürmeye yardımcı olabilir.</p>
        <p><a class="btn btn-secondary" href="#">View details »</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 mt-4">
        <img class="bd-placeholder-img rounded-circle" width="140" height="140" src="image/kitap.jpg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em"></text></img>

        <h2>Kitap Okumak</h2>
        <p> Zihinsel sağlık için önemlidir. Kitap okumak, beyindeki sinir hücreleri arasındaki bağlantıları güçlendirir, zihni açar ve stresi azaltır.</p>
        <p><a class="btn btn-secondary" href="#">View details »</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 mt-4">
      <img class="bd-placeholder-img rounded-circle" width="140" height="140" src="image/fotografcilik.jpg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em"></text></img>

        <h2>Fotoğrafçılık</h2>
        <p>Yaratıcılığı artırmaya yardımcı olabilir. Fotoğrafçılık, estetik zevki geliştirir, detaylara odaklanmayı sağlar ve yeni yerler keşfetmek için bir sebep olabilir.</p>
        <p><a class="btn btn-secondary" href="#">View details »</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">YOGA <span class="text-muted"></span></h2>
        <p class="lead">Hem bedensel hem de zihinsel sağlığa faydalıdır. Yoga, stresi azaltmaya, esnekliği artırmaya, nefes kontrolünü sağlamaya ve genel olarak daha iyi bir ruh haline sahip olmaya yardımcı olabilir.</p>
      </div>
      <div class="col-md-5">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" src="image/yoga.webp" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></img>

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">BAHÇE İŞLERİ <span class="text-muted"></span></h2>
        <p class="lead">Stresi azaltmaya ve doğa ile bağlantı kurmaya yardımcı olabilir. Bahçe işleri, yaratıcılığı artırmaya ve el becerilerini geliştirmeye yardımcı olabilir.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" src="image/bahçe.jpg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></img>

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Diecast Hobisi<span class="text-muted"></span></h2>
        <p class="lead">metal veya plastik modellerin küçük ölçeklerde üretilip koleksiyonlanmasıdır. Genellikle otomobil, motosiklet, kamyon, uçak ve gemi gibi taşıtların küçük detaylı modelleri tercih edilir. Bu hobinin temel amacı, nadir veya özel modelleri bulmak ve koleksiyonlamaktır. Aynı zamanda, modellerin detaylarına odaklanarak gerçek araçlar hakkında daha fazla bilgi edinmek de mümkündür. Diecast hobisi, birçok kişi için hem rahatlatıcı hem de heyecan verici bir hobidir.</p>
      </div>
      <div class="col-md-5">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" src="image/diecast.jpg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></img>

      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div>

    <?php include 'components/footer.php'; ?> <!-- Footer dosyasını dahil ettik -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

