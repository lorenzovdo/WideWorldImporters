<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['bestellen'])) {
    if (!isset($_SESSION['Shoppingcart'])) {
        $_SESSION['Shoppingcart'] = array();
    }
    if (isset($_SESSION['Shoppingcart'][$_POST['id']])) {
        $aantal = $_SESSION['Shoppingcart'][$_POST['id']][1] + $_POST['aantal'];
        $_SESSION['Shoppingcart'][$_POST['id']][1] = $aantal;
    } else {
        $_SESSION['Shoppingcart'][$_POST['id']] = array();
        $_SESSION['Shoppingcart'][$_POST['id']][0] = $_POST['name'];
        $_SESSION['Shoppingcart'][$_POST['id']][1] = $_POST['aantal'];
        $_SESSION['Shoppingcart'][$_POST['id']][2] = $_POST['prijs'];
    }

    $_POST = array();
}
include 'Header.php';
$product = array();
if (!isset($_GET['product'])) {
    header("Location: index.php");
} else {
    $productid = filter_input(INPUT_GET, "product", FILTER_SANITIZE_NUMBER_INT);
    $result = DBQuery("SELECT S.StockItemID, StockItemName, MarketingComments, UnitPrice, Photo, SH.QuantityOnHand FROM stockitems S JOIN stockitemholdings SH ON S.stockitemID = SH.stockitemID WHERE S.StockItemID=?", array($productid));
    $product['id'] = $result[0]['StockItemID']; // Zucht... DBQuery stuurt een 2d array, dus moet deze vrolijke hack toegepast worden...
    $product['naam'] = $result[0]['StockItemName'];
    $product['prijs'] = $result[0]['UnitPrice'];
    $product['omschrijving'] = $result[0]['MarketingComments'];
    $product['afb'] = $result[0]['Photo'];
    $product['hoeveelheid'] = $result[0]['QuantityOnHand'];
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WWI | <?php echo $product['naam']; ?></title>
    </head>
    <body>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-md-6" style="padding: 2%; background-color: #EEEEEE;">
                <h2 style="margin: 0; padding: 0; padding-bottom: 5%;"><?php echo $product['naam']; ?></h2>
                <div class="row">
                    <div class="col-md-5">
                        <img style="width: 100%; min-height: 200px;" src="Img/default.jpg"/>
                    </div>
                    <div class="col-md-7">
                        <h3>Prijs: €<?php echo $product['prijs']; ?>,-</h3><br/>
                        <p><?php echo $product['omschrijving']; ?></p><br/>
                        <?php if ($product['hoeveelheid'] < 20) { ?>
                            <p><?php echo $product['naam'] ?> is bijna uitverkocht</p><br/>
                        <?php } else {
                            ?>
                            <p>Er zijn nog <?php echo $product['hoeveelheid']; ?> op voorraad</p><br/>
                            <?php
                        }
                        ?>
                        <br/>
                        <form action="ProductPagina.php?product=<?php print($_GET['product']); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="name" value='<?php echo $product['naam']; ?>'>
                            <input type="hidden" name="prijs" value="<?php echo $product['prijs']; ?>">
                            Aantal: <input type="number" name="aantal" value="1" min="1" style="width: 10%;"/>
                            <input type="submit" name="bestellen" value="In winkelmand" style="width:75%; height: 3%; text-align: center; margin-left: 2%;"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%">
            <div class="margincol-sm-6" style="padding: 2%; background-color: #EEEEEE">
                <h4 style="margin: 0; padding: 0; padding-bottom: 5%">Vergelijkbare producten</h4>
            </div>
        </div>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%">
            <?php
            $productnaamverkleind = substr($product['naam'], 0, 4);
            $resultaatvergelijkbareproducten = DBQuery("SELECT StockItemID, StockItemName, unitprice, Photo FROM stockitems WHERE StockItemName LIKE '$productnaamverkleind%' AND StockItemName NOT IN (SELECT StockItemName FROM stockitems WHERE StockItemID = $productid) LIMIT 3", null);
            foreach ($resultaatvergelijkbareproducten as $vergelijkbareproducten) {
                ?>
                <div class="margincol-sm-6" style="padding: 2%; background-color: #EEEEEE">
                    <div class="col" style="height: 250px; padding: 1%; padding-top: 0;" onclick="window.location = 'ProductPage.php?product=<?php print($vergelijkbareproducten['StockItemID']); ?>';">
                        <div style="background-color:#EEEEEE; width: 100%; height:100%;">
                            <table>
                                <tr><td><img src="Img/default.jpg" style="width: 300px; height: 200px;"></td>
                                <tr><td><?php
                                        print($vergelijkbareproducten['StockItemName']);
                                        print("<br>");
                                        print("    -   € " . $vergelijkbareproducten["unitprice"]);
                                        ?> </td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <br/>
        <br/>

        <?php
        $productid = $result[0]['StockItemID'];
        $productchecker = DBQuery("SELECT StockItemID FROM Rating WHERE StockItemID = $productid", null);
        $AVGStars = DBQuery("SELECT AVG(StarRating) FROM Rating WHERE StockItemID = $productid", null);
        $teller = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid", null);
        $onestar = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid AND StarRating = 1", null);
        $twostar = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid AND StarRating = 2", null);
        $threestar = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid AND StarRating = 3", null);
        $fourstar = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid AND StarRating = 4", null);
        $fivestar = DBQuery("SELECT COUNT(StarRating) FROM Rating WHERE StockItemID = $productid AND StarRating = 5", null);
#Berekeningen
        $percantagecalculation = $teller[0]["COUNT(StarRating)"] / 100;
        if ($percantagecalculation > 0) {
            $onestarpercentage = $onestar[0]["COUNT(StarRating)"] / $percantagecalculation;
            $twostarpercentage = $twostar[0]["COUNT(StarRating)"] / $percantagecalculation;
            $threestarpercentage = $threestar[0]["COUNT(StarRating)"] / $percantagecalculation;
            $fourstarpercentage = $fourstar[0]["COUNT(StarRating)"] / $percantagecalculation;
            $fivestarpercentage = $fivestar[0]["COUNT(StarRating)"] / $percantagecalculation;
        }
        ?>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="margincol-sm-6" style="padding: 2%; background-color: #EEEEEE">
                <div class="col" style="height: 700x; width: 800px; padding: 1%; padding-top: 0;">
                    <span class="heading">Gebruikers score</span>
                    <?php
                    $stars = 0;
                    $allstars = $AVGStars[0]["AVG(StarRating)"];
                    while ($stars < 5) {
                        if ($allstars > 0) {
                            ?>
                            <span class="fa fa-star checked"></span>
                            <?php
                            $allstars--;
                            $stars++;
                        } else {
                            ?>
                            <span class="fa fa-star"></span>
                            <?php
                            $stars++;
                        }
                    };
                    ?>
                    <p><?php Print(round($AVGStars[0]["AVG(StarRating)"])); ?> sterren gemiddeld gebasseerd op <?php Print($teller[0]["COUNT(StarRating)"]); ?> klant reviews.</p>
                    <hr style="border:3px solid #f1f1f1">

                    <div class="row"; align="left">
                        <div class="side">
                            <div>5 sterren</div>
                        </div>
                        <div class="middle" align="left">
                            <div class="bar-container">
                                <div class="bar-5" style="margin: 0 auto; width: <?php print($fivestarpercentage); ?>%";></div>
                            </div>
                        </div>
                        <div class="side right">
                            <div><?php Print_R($fivestar[0]["COUNT(StarRating)"]); ?></div>
                        </div>
                        <div class="side">
                            <div>4 sterren</div>
                        </div>
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-4" align="left" style="margin: 0 auto; width: <?php print($fourstarpercentage); ?>%";></div>
                            </div>
                        </div>
                        <div class="side right">
                            <div><?php Print_R($fourstar[0]["COUNT(StarRating)"]); ?></div>
                        </div>
                        <div class="side">
                            <div>3 sterren</div>
                        </div>
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-3" style="margin: 0 auto; width: <?php print($threestarpercentage); ?>%";></div>
                            </div>
                        </div>
                        <div class="side right">
                            <div><?php Print_R($threestar[0]["COUNT(StarRating)"]); ?></div>
                        </div>
                        <div class="side">
                            <div>2 sterren</div>
                        </div>
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-2" style="margin: 0 auto; width:  <?php print($twostarpercentage); ?>%";></div>
                            </div>
                        </div>
                        <div class="side right">
                            <div><?php Print_R($twostar[0]["COUNT(StarRating)"]); ?></div>
                        </div>
                        <div class="side">
                            <div>1 sterren</div>
                        </div>
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-1" style="margin: 0 auto; width: <?php print($onestarpercentage); ?>%";></div>
                            </div>
                        </div>
                        <div class="side right">
                            <div><?php Print_R($onestar[0]["COUNT(StarRating)"]); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="margincol-sm-6" style="padding: 2%; background-color: #EEEEEE">
                <div class="col" style="height: 100%; width: 100%; padding: 1%; padding-top: 0;">
                    <div>
                        <form action="RatingToDatabase.php" method="post">
                            <input type="radio" name="star" value="1"/> 1 ster<br>
                            <input type="radio" name="star" value="2"/> 2 sterren<br>
                            <input type="radio" name="star" value="3"/> 3 sterren<br>
                            <input type="radio" name="star" value="4"/> 4 sterren<br>
                            <input type="radio" name="star" value="5"/> 5 sterren<br><br>
                            <input type="hidden" name="ID" value="<?php print($productid); ?>"/>
                            <input type="submit" value="Versturen">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome Icon Library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            * {
                box-sizing: border-box;
            }


            .heading {
                font-size: 25px;
                margin-right: 25px;
            }

            .fa {
                font-size: 25px;
            }

            .checked {
                color: orange;
            }

            /* Three column layout */
            .side {
                float: left;
                width: 15%;
                margin-top:10px;
            }

            .middle {
                margin-top:10px;
                float: left;
                width: 70%;
            }

            /* Place text to the right */
            .right {
                text-align: right;
            }

            /* Clear floats after the columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }

            /* Individual bars */
            .bar-5 {height: 18px; background-color: #4CAF50;}
            .bar-4 {height: 18px; background-color: #2196F3;}
            .bar-3 {height: 18px; background-color: #00bcd4;}
            .bar-2 {height: 18px; background-color: #ff9800;}
            .bar-1 {height: 18px; background-color: #f44336;}

            /* The bar container */
            .bar-container {
                width: 100%;
                background-color: #f1f1f1;
                text-align: center;
                color: white;
            }

            /* Responsive layout - make the columns stack on top of each other instead of next to each other */
            @media (max-width: 400px) {
                .side, .middle {
                    width: 100%;
                }
                .right {
                    display: none;
                }
            }	
        </style>
    </body>
</head>
<?php
include"footer.php";
?>

</html>