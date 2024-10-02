<?php
require_once 'connection.php'; 
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
// $stmt, veritabanı işlemlerinde sorguları hazırlamak, 
// parametreleri atamak ve sonuçları almak için kullanılan bir araçtır. 
// Bu, kodun daha düzenli, güvenli ve okunabilir olmasını sağlar. 
?>