<?php

session_start();
include 'Functions.php';

$UserID = $_SESSION['userinfo']['id'];
$stars = $_POST['star'];
$ID = $_POST['ID'];
DBQuery("INSERT INTO rating (UserID, StockItemID, StarRating) VALUES ($UserID, $ID, $stars)",null);
header("location: ProductPage.php?product=$ID");
        exit();
?>