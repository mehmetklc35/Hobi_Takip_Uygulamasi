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
      <!-- Navbar Başlangıcı -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                  <a class="navbar-brand" href="#">Logo</a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                              <li class="nav-item active">
                                    <a class="nav-link" href="#">Ana Sayfa <span class="sr-only">(şu anki sayfa)</span></a>
                              </li>
                              <li class="nav-item">
                                    <a class="nav-link" href="#">Hakkında</a>
                              </li>
                              <li class="nav-item">
                                    <a class="nav-link" href="#">Hizmetler</a>
                              </li>
                              <li class="nav-item">
                                    <a class="nav-link" href="#">İletişim</a>
                              </li>
                        </ul>
                  </div>
            </div>
      </nav>
    <!-- Navbar Bitişi -->

      <div class="container mt-5">
            <h1>Hoş Geldiniz!</h1>
            <p>Bu sayfa, Bootstrap ile oluşturulmuş bir navbar içermektedir.</p>
      </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
