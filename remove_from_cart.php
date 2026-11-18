<?php
session_start();

if (isset($_POST["id"])) {
 $id=$_POST["id"];
    
    


    $key = array_search((int)$id, $_SESSION["cart"]);

    if ($key !== false) {
        unset($_SESSION["cart"][$key]);
    }

    $_SESSION["cart"] = array_values($_SESSION["cart"]);
}

header("Location: cart.php");
exit;