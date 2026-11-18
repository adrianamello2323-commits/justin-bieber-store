<?php
session_start();
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"]=[];
}
if (isset($_POST["id"])){
    $id= (int) $_POST["id"];
    $_SESSION["cart"][]=$id;
    echo "ok";
}