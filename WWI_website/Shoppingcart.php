<?php
include 'Header.php';
?>
<html>
    <body>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-md-7"><!--style="background-color:#AAAAAA"-->
                <div class="row">
                    <?php
                    foreach ($_SESSION["Shoppingcart"] as $key => $value) {
                        print('<div class="col-12" style="height: 200 px; padding: 1%; padding-top: 0;">'
                                . '<div style="background-color:#999999; width: 100%; height:100%;">'
                                    . '<img style="width: 30%;" src="Img/default.jpg">'
                                    . '<div class="col-8" style="float: right;"><p> Product: ' . $value[0] . '</p>'
                                    . '<p style="display: inline-block;"> Aantal: <form action="ManageShoppingcart.php" method="post">'
                                                    . '<input type="hidden" name="id" value="'.$key.'"/>'
                                                    . '<input type="submit" name="submit" value="-"/>'
                                                . '</form>' . $value[1] . ''
                                                . '<form action="ManageShoppingcart.php" method="post">'
                                                    . '<input type="hidden" name="id" value="'.$key.'"/>'
                                                    . '<input type="submit" name="submit" value="+"/>'
                                                . '</form></p>'
                                    . '<p> Prijs per stuk: €' . $value[2] . '</p>'
                                    . '<p> Totaal product: €' . number_format($value[2] * $value[1],2) . '</p></div>' 
                                . '</div>'
                            . '</div>');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-2" style="padding-right: 2%;">
                <div style="background-color:#EEEEEE; border: 1px solid black;">
                    <h3 style="text-align:center;">Totaalprijs</h3>
                    <?php
                    $totaalPrijs = null;
                    foreach ($_SESSION["Shoppingcart"] as $key => $value) {
                        $totaalPrijs = $totaalPrijs + number_format($value[2] * $value[1],2);
                    }
                    print('<p>Subtotaal: €' . number_format($totaalPrijs,2) . '</p>'
                    .'<p>Verzending: Gratis</p>'
                    .'<div class="dropdown-divider"></div>'
                    .'<p>Totaalprijs (inclusief btw): €' . number_format($totaalPrijs,2) . '</p>');
                    ?>
                    <a class="button" href="SignUpPage.php">Door naar kassa</a>
                </div>
            </div>
        </div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>
