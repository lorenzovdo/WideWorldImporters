<?php

session_start();
include 'Functions.php';
//print_r($_POST);
if($_POST['submit'] == '+'){
    increaseNumberInShoppingcart($_POST['id']);
}
elseif($_POST['submit'] == '-'){
    decreaseNumberInShoppingcart($_POST['id']);
}
header('Location: Shoppingcart.php');

