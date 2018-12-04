<!DOCTYPE html>
<html>
    <body>
        <?php
        include 'Header.php';
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
        ?>
        <div class="" style="background-color:#EEEEEE; border: 1px solid black; margin-left: 25%; margin-right: 25%; height: 500px;">
            <?php
            if ($payment->isPaid()) {
                echo "<h3>Betaling succesvol verlopen</h3><br>"
                ."<h3>Bedankt dat u gekozen heeft voor Wide World Importers.</h3><br>";
                if(isset($_SESSION['userinfo']))
                {
                    sendMail($_SESSION['userinfo'], $_SESSION['payment_id']);
                }
                else
                {
                    sendMail($_SESSION['anonymousUser'], $_SESSION['payment_id']);
                }
                echo "<p style='text-align: center'>Gegevens:<p>";
             getUserInfo();
            } else {
                echo "Betaling niet succesvol verlopen<br>"
                ."<h3></h3>";
            }
            ?>
        </div>
    </body>
    <?php
    unset($_SESSION['Shoppingcart']);
    unset($_SESSION['UserInfo']);
    include"footer.php";
    ?>
</html>