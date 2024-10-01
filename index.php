<?php
session_start();
include './components/connection.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Aktif hobileri almak için sorgu
$query = "SELECT * FROM hobbies WHERE is_active = :is_active"; 
$params = ['is_active' => 1];

if ($category_id) {
    $query .= " AND category_id = :category_id";
    $params['category_id'] = $category_id; 
}

// LIMIT ve OFFSET'i doğrudan sorguya ekleyin
$query .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

// PDO için hazırlık
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$hobbiesList = $stmt->fetchAll(PDO::FETCH_ASSOC); // Burada $hobbiesList kullanılmakta

// Toplam hobi sayısını almak için
$totalQuery = "SELECT COUNT(*) FROM hobbies WHERE is_active = :is_active";
$totalParam = ['is_active' => 1];

if ($category_id) {
    $totalQuery .= " AND category_id = :category_id";
    $totalParam['category_id'] = $category_id;
}

$totalStmt = $pdo->prepare($totalQuery);
$totalStmt->execute($totalParam);
$totalHobbies = $totalStmt->fetchColumn(); 
$totalPages = ceil($totalHobbies / $limit);

include './components/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>index sayfası</title>
</head>
<body>
      <div class="container mt-4">
            <div class="row">          
                  <div class="col-md-9">
                        <?php if ($hobbiesList): // Eğer hobi listesi varsa ?>
                            <?php foreach($hobbiesList as $hobby): ?>
                              <div class="card mb-3">
                                    <div class="row g-0">
                                          <div class="col-md-4">
                                                <?php if($hobby['image']): ?>
                                                      <img src="./image/<?php echo htmlspecialchars($hobby['image']); ?>" class="img-fluid rounded" alt="">
                                                <?php endif; ?>
                                          </div>
                                          <div class="col-md-8">
                                                <div class="card-body">
                                                      <h5 class="card-title"><?php echo htmlspecialchars($hobby['title']); ?></h5>
                                                      <p class="card-text"><?php echo htmlspecialchars(substr($hobby['content'], 0, 100)); ?>...</p>
                                                      <a href="hoby_detail.php?id=<?php echo $hobby['id']; ?>" class="btn btn-primary">Devamını Oku</a>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div>Hiç hobi bulunamadı.</div>
                        <?php endif; ?>

                        <nav aria-label="Page navigation">
                              <ul class="pagination">
                                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                          <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                                <a href="?page=<?php echo $i; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?>" class="page-link">
                                                      <?php echo $i; ?>
                                                </a>
                                          </li>
                                    <?php endfor; ?>

                                    <?php if($page < $totalPages): ?>
                                          <li class="page-item">
                                                <a href="?page=<?php echo $page + 1; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?>" aria-label="Next" class="page-link">
                                                      <span aria-hidden="true">&raquo;</span>
                                                </a>
                                          </li>
                                    <?php endif; ?>
                              </ul>
                        </nav>

                  </div>
            </div>
      </div>
</body>
</html>
