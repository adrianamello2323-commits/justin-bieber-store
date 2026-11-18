<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $nova_quantidade = (int) $_POST['quantidade'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Remove todas as ocorrências deste produto do carrinho
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item_id) use ($id) {
        return $item_id != $id;
    });

    // Nunca deixa ir abaixo de 1 (pra isso já existe o botão "Remover")
    if ($nova_quantidade < 1) {
        $nova_quantidade = 1;
    }

    // Reinsere o produto repetido a nova quantidade de vezes
    for ($i = 0; $i < $nova_quantidade; $i++) {
        $_SESSION['cart'][] = $id;
    }

    // Reindexar o array (essencial depois de array_filter)
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: cart.php");
exit;
?>