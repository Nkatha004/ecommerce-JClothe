<?php
if(!isset($_SESSION)) { 
    session_start(); 
}

unset($_SESSION["cart_item"]);
header("location:".base_url(). "/clothes/cart");
?>