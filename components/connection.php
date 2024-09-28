<?php
// Veritabanı bağlantı bilgileri
$host = 'localhost'; // Veritabanı sunucusunun adresi (genellikle localhost)
$dbname = 'hobi_takip_uygulaması'; // Veritabanı adı 
$username = 'root'; // Veritabanı kullanıcı adı 
$password = ''; // Veritabanı şifresi

// PDO ile veritabanı bağlantısı
try {
    // PDO nesnesini oluştur
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Hata modunu ayarla
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Bağlantının başarılı olduğunu belirten bir mesaj
    echo "Veritabanına başarıyla bağlandınız.";
} catch (PDOException $e) {
    // Hata oluşursa hata mesajını yakala ve göster
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
