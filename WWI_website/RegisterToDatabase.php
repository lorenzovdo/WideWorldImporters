<?php

session_start();
include 'Functions.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
$infix = filter_input(INPUT_POST, "infix", FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
$birthdate = $_POST["birthdate"];
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$passwordOne = filter_input(INPUT_POST, "passwordone", FILTER_SANITIZE_STRING);
$passwordTwo = filter_input(INPUT_POST, "passwordtwo", FILTER_SANITIZE_STRING);
$postalcode = filter_input(INPUT_POST, "postalcode", FILTER_SANITIZE_STRING);
$streetname = filter_input(INPUT_POST, "streetname", FILTER_SANITIZE_STRING);
$housenumber = filter_input(INPUT_POST, "housenumber", FILTER_SANITIZE_STRING);

if ($passwordOne == $passwordTwo) {
    PDODBConn();
    $emailAvailable = DBQuery("SELECT * FROM `user` WHERE `email` = '".$email."'",null);
    if(!$emailAvailable) {
        PDODBConn();
        $makeUser = DBQuery("INSERT INTO `user` (`userID`,"
                . "`firstname`,"
                . "`infix`,"
                . "`lastname`,"
                . "`birthdate`,"
                . "`email`,"
                . "`password`,"
                . "`postalcode`,"
                . "`streetname`,"
                . "`housenumber`) values"
                . "(NULL,"
                . "'" . $firstname . "',"
                . "'" . $infix . "',"
                . "'" . $lastname . "',"
                . "'" . $birthdate . "',"
                . "'" . $email . "',"
                . "'" . $passwordOne . "',"
                . "'" . $postalcode . "',"
                . "'" . $streetname . "',"
                . "'" . $housenumber . "')", null);
        echo 'gegevens succesvol opgeslagen activeer account nu met de email';
        sendRegisterMail($firstname,$infix,$lastname,$email);
        header('Location: LoginAndRegister.php');
    } else {
        echo 'Email adres is al in gebruik';
        header('Location: RegisterPage.php');
    }
} else {
    echo 'Wachtwoord was niet correct';
    header('Location: RegisterPage.php');
}
//header('locationindex.php');