<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// the message
//$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
//$msg = wordwrap($msg,70);

// send email
//mail("someone@example.com","My subject",$msg);

include 'mollie/vendor/autoload.php';
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_vpxexHnQHrdVnMyqR6qwUdyD8Kcb23");
$payment = $mollie->payments->get($_SESSION['payment_id']);

if($payment->isPaid()) {
    echo "Payment received.";
} else {
    echo "Something went wrong!";
}
?>
