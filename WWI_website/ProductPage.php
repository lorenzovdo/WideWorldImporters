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
    $result = DBQuery("SELECT StockItemID, StockItemName, MarketingComments, UnitPrice, Photo FROM stockitems WHERE StockItemID=?", array($productid));
    $product['id'] = $result[0]['StockItemID']; // Zucht... DBQuery stuurt een 2d array, dus moet deze vrolijke hack toegepast worden...
    $product['naam'] = $result[0]['StockItemName'];
    $product['prijs'] = $result[0]['UnitPrice'];
    $product['omschrijving'] = $result[0]['MarketingComments'];
    $product['afb'] = $result[0]['Photo'];
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WWI | <?php echo $product['naam']; ?></title>
    </head>
    <body>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-md-6" style="padding: 2%; background-color: #EEEEEE;"><!--style="background-color:#AAAAAA"-->
                <h2 style="margin: 0; padding: 0; padding-bottom: 5%;"><?php echo $product['naam']; ?></h2>
                <div class="row">
                    <div class="col-md-5">
                        <img style="width: 100%; min-height: 200px;" src="Img/default.jpg"/>
                    </div>
                    <div class="col-md-7">
                        <h3>Prijs: €<?php echo $product['prijs']; ?>,-</h3><br/>
                        <p><?php echo $product['omschrijving']; ?></p><br/>
                        <br/>
                        <form action="ProductPage.php?product=<?php print($_GET['product']); ?>" method="post">
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
    </body>
    <?php
    include"footer.php";
    ?>
</html>