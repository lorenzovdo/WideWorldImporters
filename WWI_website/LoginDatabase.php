<?php

session_start();
include 'Functions.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
PDODBConn();
$inlogTrue = DBQuery("SELECT * FROM `user` WHERE `email` = '" . $email . "'", null);
if ($inlogTrue) {
    //print_r($inlogTrue);
    $verified = password_verify($password, $inlogTrue[0]['password']);
    //echo 'gegevens succesvol opgeslagen activeer account nu met de email';
    if ($verified) {
        $_SESSION['userinfo']['id'] = $inlogTrue[0]['userID'];
        $_SESSION['userinfo']['firstname'] = $inlogTrue[0]['firstname'];
        $_SESSION['userinfo']['infix'] = $inlogTrue[0]['infix'];
        $_SESSION['userinfo']['lastname'] = $inlogTrue[0]['lastname'];
        $_SESSION['userinfo']['email'] = $inlogTrue[0]['email'];
        $_SESSION['userinfo']['postalcode'] = $inlogTrue[0]['postalcode'];
        $_SESSION['userinfo']['streetname'] = $inlogTrue[0]['streetname'];
        $_SESSION['userinfo']['housenumber'] = $inlogTrue[0]['housenumber'];
        if ($_POST['submit'] == 'Login') {
            header('Location: ConfirmPage.php');
        } else {
            header('Location: index.php');
        }
    } else {
        echo 'gegevens waren niet juist';
        header('Location: index.php');
    }
} else {
    echo 'gegevens waren niet juist';
    header('Location: index.php');
}
//header('locationindex.php');