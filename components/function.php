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
function get_hobbies() {
    global $pdo; 
    $sql = "SELECT * FROM hobbies"; // Parametreli sorgu
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);// Tüm sonuçları al
}

// Hobi güncelleme fonksiyonu
function update_hobby($id, $hobby_name, $description) {
    global $pdo; 
    $sql = "UPDATE hobbies SET name = :name, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'name' => $hobby_name, 'description' => $description]);
}

// Hobi silme fonksiyonu
function delete_hobby($id) {
    global $pdo; 
    $sql = "DELETE FROM hobbies WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// $stmt, veritabanı işlemlerinde sorguları hazırlamak, 
// parametreleri atamak ve sonuçları almak için kullanılan bir araçtır. 
// Bu, kodun daha düzenli, güvenli ve okunabilir olmasını sağlar. 
?>