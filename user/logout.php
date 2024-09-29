<?php
session_start();

// Tüm oturum değişkenlerini temizle
$_SESSION = [];

// Oturumun sonlandırılması
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendir
header('Location: login.php');
exit();
?>
