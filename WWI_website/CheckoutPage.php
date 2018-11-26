<?php
include 'mollie/vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['UserInfo'] = array();
$_SESSION['UserInfo']['Firstname']   = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
$_SESSION['UserInfo']['Infix']       = filter_input(INPUT_POST, "infix", FILTER_SANITIZE_STRING);
$_SESSION['UserInfo']['Lastname']    = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
$_SESSION['UserInfo']['Email']       = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$_SESSION['UserInfo']['Postalcode']  = filter_input(INPUT_POST, "postalcode", FILTER_SANITIZE_STRING);
$_SESSION['UserInfo']['Housenumber'] = filter_input(INPUT_POST, "housenumber", FILTER_SANITIZE_NUMBER_INT);


$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_vpxexHnQHrdVnMyqR6qwUdyD8Kcb23");

$totaalPrijs = null;
foreach ($_SESSION["Shoppingcart"] as $key => $value) {
    $totaalPrijs = $totaalPrijs + ($value[1] * $value[2]);
}
$totaalPrijs = (string) number_format($totaalPrijs, 2);

$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "EUR",
        "value" => $totaalPrijs
    ],
    "description" => "Betaling WWI",
    "redirectUrl" => "http://localhost/WWI_website/BankCheckoutPage.php",
    "method" => "ideal"
]);

$_SESSION['payment_id'] = $payment->id;

header("Location: " . $payment->getCheckoutUrl(), true, 303);
?>