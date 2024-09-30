<?php
session_start();

// Kullanıcı oturumunu sonlandır
if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
}

// Ana sayfaya yönlendir
header('location: home.php');
exit();
?>
