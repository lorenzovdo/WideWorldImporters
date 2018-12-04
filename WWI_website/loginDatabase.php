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
$inlogTrue = DBQuery("SELECT * FROM `user` WHERE `email` = '".$email."' AND `password` = '".$password."'", null);
if ($inlogTrue) {
    //echo 'gegevens succesvol opgeslagen activeer account nu met de email';
    foreach ($inlogTrue as $key => $value)
    {
        $_SESSION['userinfo']['id'] = $value['userID'];
        $_SESSION['userinfo']['firstname'] = $value['firstname'];
        $_SESSION['userinfo']['infix'] = $value['infix'];
        $_SESSION['userinfo']['lastname'] = $value['lastname'];
        $_SESSION['userinfo']['email'] = $value['email'];
        $_SESSION['userinfo']['postalcode'] = $value['postalcode'];
        $_SESSION['userinfo']['streetname'] = $value['streetname'];
        $_SESSION['userinfo']['housenumber'] = $value['housenumber'];
    }
    header('Location: index.php');
}
else
{
    echo 'gegevens waren niet juist';
    header('Location: index.php');
}
//header('locationindex.php');