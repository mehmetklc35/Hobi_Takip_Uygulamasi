<?php
session_start();
require '../components/connection.php';
require '../components/function.php';

checkAdminAccess();

$hobbies_id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;

$stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->execute([$hobbies_id]);
header('Location: admin_dashboard.php?page=lists_hobbies');
exit();
?>