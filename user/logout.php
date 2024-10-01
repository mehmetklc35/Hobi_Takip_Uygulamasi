<?php
session_start(); // Oturumu başlat

// Oturumu yok et
session_unset(); // Tüm oturum değişkenlerini temizle
session_destroy(); // Oturumu sonlandır

// Kullanıcıyı giriş sayfasına yönlendir
header('Location: login.php');
exit();
?>
