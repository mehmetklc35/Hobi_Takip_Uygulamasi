<?php
session_start();
require '../components/connection.php';
require '../components/function.php';

checkAdminAccess();

$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($blog_id > 0){
    $stmt = $pdo->prepare("SELECT * FROM hobbies WHERE id = ?");
    $stmt->execute([$hobbies_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$hobbies){
        echo "Hobi bulunamadı";
        exit();
    }
}else{
    echo "Geçersiz Hobi ID'si";
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active']: 0;

    try {
        $image = null;
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $image = uploadedImage($_FILES['image']);
        }
        if(updateHoby($pdo, $hoby_id, $title, $description,$category_id,$is_active,$image)){
            header('Location: admin_dashboard.php?page=lists_hobbies');
            exit();
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
    <title>edit_hobbies page</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Hobileri Güncelle</h2>
        <form action="edit_hobbies.php?id=<?php echo $hoby_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Başlık</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>">
            </div>
            <div class="form-group">
                <label for="description">Açıklama</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($blog['description']); ?>">
            </div>
            <div class="form-group">
                <label for="description">içerik</label>
                <textarea type="content" class="form-control" id="content" name="content" value="<?php echo htmlspecialchars($blog['description']); ?>"></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select class="form-select" name="category_id" id="category_id">
                    <?php
                        $stmt = $pdo->query("SELECT * FROM categories");
                        $categories = $stmt->fetchAll();
                        foreach ($categories as $category){
                            $selected = $category['id']==$hobbies['category_id'] ? 'selected' : '';
                            echo "<option value=\"{$category['id']}\"$selected>{$category['name']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="is_active">Aktif</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="1" <?php echo $hobbies['is_active'] ? 'selected' : ''; ?>>Evet</option>
                    <option value="0" <?php echo !$hobbies['is_active'] ? 'selected' : ''; ?>>Hayır</option>
                </select>
            </div>
            <div class="form-group mt-2">
                <label for="image">Resim</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                <?php if($blog['image']): ?>
                    <img src="./image/<?php echo htmlspecialchars($hobbies['image']); ?>" alt="" class="img-fluid mt-3" style="max-width: 150px">
                 <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Hobileri Güncelle</button>
        </form>
    </div>
</body>
</html>