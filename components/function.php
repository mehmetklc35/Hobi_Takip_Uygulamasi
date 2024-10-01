<?php

require_once 'connection.php'; 

// Hobi ekleme fonksiyonu
function add_hobby($hobby_name, $description) {
    global $pdo; // Fonksiyonlar içinde $pdo değişkenine erişim sağlamak için bunu global olarak tanımlıyoruz.
    $sql = "INSERT INTO hobbies (name, description) VALUES (:name, :description)";
    $stmt = $pdo->prepare($sql); // Sorguyu hazırla
    $stmt->execute(['name' => $hobby_name, 'description' => $description]);// Parametreleri atayıp sorguyu çalıştır
}

// Hobileri listeleme fonksiyonu
function getHoby($pdo, $hoby_id){
    $stmt = $pdo->prepare("SELECT * FROM hobbies WHERE id = ?");
    $stmt->execute([$hoby_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Hobi güncelleme fonksiyonu
function updateHoby($pdo,$hoby_id,$title,$description,$category_id,$is_active,$image = NULL){
    $query = "UPDATE hobbies SET title = :title, description = :description, category_id = :category_id, is_active = :is_active";
    $params = [
        ':title' => $title,
        ':description' => $description,
        ':category_id' => $category_id,
        ':is_active' => $is_active,
        ':hoby_id' => $hobbies_id
    ];

    if($image !== null){
        $query .= ", image = :image";
        $params[':image'] = $image;
    }

    $query .= " WHERE id = :hoby_id";

    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}

// Hobi silme fonksiyonu
function delete_hobby($id) {
    global $pdo; 
    $sql = "DELETE FROM hobbies WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

function authenticatedUser($pdo,$email,$password){
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        return $user;
    }
    return false;
}

function uploadedImage($file, $uploadDir = '../uploads/'){
    $image = $file['name'];
    $imageTmpName = $file['tmp_name'];
    $imagePath = $uploadDir . basename($image);

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)); 

    if (!in_array($imageExtension, $allowedExtensions)) {
        throw new Exception("Geçersiz dosya türü. Sadece jpg, jpeg, png ve gif dosyaları kabul edilir.");
    }

    if ($file['size'] > 2000000) {
        throw new Exception("Resim boyutu 2MB'den büyük olamaz!");
    }

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($imageTmpName, $imagePath)) {
        throw new Exception("Resim yükleme başarısız.");
    }

    return basename($image);
}

function checkAdminAccess(){
    if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
        header('Location: ../user/login.php');
        exit();
    }
}

function addComment($pdo, $hoby_id, $user_id, $content){
    $query = "INSERT INTO comments (hoby_id, user_id, content, created_at) VALUES (:hoby_id, :user_id, :content, NOW())";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':hoby_id', $hoby_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $content);
    return $stmt->execute();
}



function getComments($pdo,$blog_id){
    $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id =users.id WHERE hoby_id = ? ORDER BY created_at DESC");
    $stmt->execute([$hoby_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllHobbies($pdo){
    $stmt = $pdo->prepare("SELECT hobbies.*, categories.name as category_name FROM hobbies JOIN categories ON hobbies.category_id = categories.id ORDER BY hobbies.created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// $stmt, veritabanı işlemlerinde sorguları hazırlamak, 
// parametreleri atamak ve sonuçları almak için kullanılan bir araçtır. 
// Bu, kodun daha düzenli, güvenli ve okunabilir olmasını sağlar. 
?>