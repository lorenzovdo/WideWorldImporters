<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'header.php';
if (isset($_POST['firstname'])) {
    createAnonymousUser();
}
?>
<html>
    <body>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-md-7"><!--style="background-color:#AAAAAA"-->
                <div class="row">
                    <div class="col-12" style="height: 200 px; padding: 1%; padding-top: 0;">
                        <div style="background-color:#999999; width: 100%; height:100%;">
                            <?php getUserInfo();?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    foreach ($_SESSION["Shoppingcart"] as $key => $value) {
                        print('<div class="col-12" style="height: 200 px; padding: 1%; padding-top: 0;">'
                                . '<div style="background-color:#999999; width: 100%; height:100%;">'
                                . '<img style="width: 30%;" src="Img/default.jpg">'
                                . '<div class="col-8" style="float: right;"><p> Product: ' . $value[0] . '</p>'
                                . '<p style="display: inline-block;"> Aantal: '. $value[1] . '</p>'
                                . '<p> Prijs per stuk: €' . $value[2] . '</p>'
                                . '<p> Totaal product: €' . number_format($value[2] * $value[1], 2) . '</p></div>'
                                . '</div>'
                                . '</div>');
                    }
                    ?>
                </div>
                <form action="CheckoutPage.php" method="post">
                    <input class="col-4"type="submit" value="Verder"style="margin-bottom: 2%;margin-top: 2%">
                </form>
            </div>
    </body>
</html>
