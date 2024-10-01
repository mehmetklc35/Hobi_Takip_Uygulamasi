<?php
session_start();

require '../components/connection.php';
require_once '../components/function.php';

checkAdminAccess();

$comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);

    header('Location: admin_dashboard.php?page=lists_comments');
    exit();
} catch (Exception $e) {
    echo "Yorum silinirken bir hata oluştu: " . $e->getMessage();
}
?>