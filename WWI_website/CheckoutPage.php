<?php
include 'mollie/vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['UserInfo'] = array();
$_SESSION['UserInfo']['Firstname']   = $_POST['firstname'];
$_SESSION['UserInfo']['Infix']       = $_POST['infix'];
$_SESSION['UserInfo']['Lastname']    = $_POST['lastname'];
$_SESSION['UserInfo']['Email']       = $_POST['email'];
$_SESSION['UserInfo']['Postalcode']  = $_POST['postalcode'];
$_SESSION['UserInfo']['Housenumber'] = $_POST['housenumber'];


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