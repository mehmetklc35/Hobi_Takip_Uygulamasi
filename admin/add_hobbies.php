<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once '../components/connection.php';
require_once '../components/function.php';

checkAdminAccess();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    try {
        $image = '';
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $image = uploadedImage($_FILES['image']);
        }
        if(add_hobby($pdo, $title,$description,$content,$category_id,$image)){
            echo "Blog başarıyla eklendi!";
            header('Location: ../admin/admin_dashboard.php?page=lists_blog');
            exit();
        }else{
            echo "Blog eklenirken bir hata oluştu!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/ngvt5c1mjw32mf013yl78j12sixv644beta6cqbw4l0mx8h1/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
      tinymce.init({
        selector: '#content',
        apiKey: 'ngvt5c1mjw32mf013yl78j12sixv644beta6cqbw4l0mx8h1',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      });
    </script>
    <title>admin_hobbies page</title>
</head>
<body>
<div class="container mt-4">
    <h2>Yeni BLog Ekle</h2>
    <form action="add_hobbies.php" method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="title">Başlık</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Açıklama</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group mb-3">
            <label for="content">İçerik</label>
            <textarea id="content" name="content"></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="image">Resim</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <?php
                    $stmt = $pdo->query("SELECT * FROM categories");
                    $categories = $stmt->fetchAll();
                    foreach($categories as $category){
                        echo "<option value=\"{$category['id']}\">{$category['name']}</option>";
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Hobi Ekle</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim.js/4.0.3/Slim.min.js" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" referrerpolicy="no-referrer"></script>
</body>
</html>