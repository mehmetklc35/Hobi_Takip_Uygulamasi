<?php
session_start();

require '../components/connection.php';
require '../components/function.php';

checkAdminAccess();

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $stmt = $pdo->prepare("DELETE FROM comments WHERE user_id = ?");
    $stmt->execute([$user_id]);

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    header('Location: admin_dashboard.php?page=lists_users');
    exit();

} catch (Exception $e) {
    echo "Kullanıcı silinirken bir hata oluştu: " . $e->getMessage();
}
?>