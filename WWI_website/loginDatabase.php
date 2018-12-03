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
    echo 'gegevens succesvol opgeslagen activeer account nu met de email';
    header('Location: SignUpPage.php');
}
else
{
    echo 'gegevens waren niet juist';
    header('Location: RegisterPage.php');
}
//header('locationindex.php');