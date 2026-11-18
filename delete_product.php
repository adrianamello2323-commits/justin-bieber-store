<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    echo "Acesso negado.";
    exit;
}

require 'db.php';

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: admin.php");
exit;