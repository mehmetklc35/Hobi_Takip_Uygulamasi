<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Navbar Örneği</title>
</head>
<body> 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
            <a class="navbar-brand" href="#">
                  <img src="image/hobi.jpg" alt="Logo" style="height: 40px; width: auto;">
                  Hobbies
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                              <a class="nav-link" href="home.php">Ana Sayfa <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="#">Hakkında</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="#">Hizmetler</a>
                        </li>               
                        <li class="nav-item">
                              <a class="nav-link" href="contact.php">İletişim</a>
                        </li>                
                        <?php if (isset($_SESSION['user_id'])): ?>
                              <li class="nav-item">
                                    <form method="POST" action="user/login.php" style="display: inline;">
                                          <button type="submit" class="btn btn-link nav-link">Çıkış Yap</button>
                                    </form>
                              </li>
                        <?php else: ?>
                              <li class="nav-item">
                                    <a class="nav-link" href="user/login.php">Giriş Yap</a>
                              </li>
                        <?php endif; ?>                
                  </ul>
            </div>
      </div>
</nav>      

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
