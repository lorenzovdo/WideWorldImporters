<?php
include 'Functions.php';
session_start();
if(filter_input(INPUT_POST, "firstname")==="" || filter_input(INPUT_POST, "lastname")==="" || filter_input(INPUT_POST, "email")==="" ||
        filter_input(INPUT_POST, "postalcode")==="" || filter_input(INPUT_POST, "firstname")==="housenumber" || !postalcodeCheck(filter_input(INPUT_POST, "postalcode"))){
    $_SESSION["invalidData"] = true;
    header('Location: SignUpWithoutAccount.php');
    
}else{
    header('Location: ConfirmPage.php');
}
