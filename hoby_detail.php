<?php
session_start();

require './components/connection.php';
require './components/function.php';

$hoby_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$hoby = getHoby($pdo,$hoby_id);

if(!$hoby){
    echo "Hobi Bulunamadı";
    exit();

}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])){
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    addComment($pdo, $hoby_id, $user_id, $content);

    header("Location: hoby_detail.php?id=$hoby_id");
    exit();
}

$comments = getComments($pdo, $hoby_id);
include './components/header.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>hoby_detail page</title>
</head>
<body>
    <div class="container mt-4">
        <div class="row">         
        
        <div class="col-md-9">
            <h1><?php echo htmlspecialchars($hoby['title']); ?></h1><?php if($hoby['image']): ?>
            <img src="./image/<?php echo htmlspecialchars($hoby['image']); ?>" class="img-fluid" alt="">
            <?php endif; ?>
            <p><?php echo htmlspecialchars($hoby['description']);?></p>
            <div><?php echo htmlspecialchars($hoby['content']); ?></div>

            <h3 class="mt-4">Yorumlar</h3>
            <?php if(!empty($comments)):?>
                <ul class="list-unstyled">
                    <?php foreach($comments as $comment):?>
                        <li class="media mb-3">
                            <div class="media-body">
                                <h5 class="mt-0 mb-1"><?php htmlspecialchars($comment['username']);?></h5>
                                <div><?php echo htmlspecialchars($comment['content']); ?></div>
                                <small class="text-muted"><?php echo $comment['created_at']; ?></small>
                            </div>
                        </li>
                        <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <p>Henüz yorum yapılmamış.</p>
                <?php endif; ?>




            <?php if(isset($_SESSION['user_id'])): ?>
            <form action="hoby_detail.php?id=<?php echo $hoby_id;?>" method="post">
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="4" required placeholder="Yorumunuzu yazın"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Yorum Gönder</button>
            </form>
            <?php else: ?>
                <p>Yorum yapmak için <a href="./user/login.php">giriş</a>yapınız</p>
            <?php endif;?>
        </div>
        </div>
    </div>
</body>
</html>