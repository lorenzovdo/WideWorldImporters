<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['bestellen'])) {
    if (!isset($_SESSION['Shoppingcart'])) {
        $_SESSION['Shoppingcart'] = array();
    }
    if (isset($_SESSION['Shoppingcart'][$_POST['id']])) {
		if(isset($_POST['aantal'])) {
			$_POST['aantal'] = 0;
		}
        $aantal = $_SESSION['Shoppingcart'][$_POST['id']][1] + $_POST['aantal'];
        $_SESSION['Shoppingcart'][$_POST['id']][1] = $aantal;
    } else {
        $_SESSION['Shoppingcart'][$_POST['id']] = array();
        $_SESSION['Shoppingcart'][$_POST['id']][0] = $_POST['name'];
        $_SESSION['Shoppingcart'][$_POST['id']][1] = $_POST['aantal'];
        $_SESSION['Shoppingcart'][$_POST['id']][2] = $_POST['prijs'];
		$_SESSION['Shoppingcart'][$_POST['id']][3] = $_POST['mainimage'];
    }

    $_POST = array();
}
include 'Header.php';
if (!isset($_GET['product'])) {
    header("Location: index.php");
	exit();
}
$productid = filter_input(INPUT_GET, "product", FILTER_SANITIZE_NUMBER_INT);
$product = getProductInfo($productid);
$productmedia = getProductMedia($productid);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WWI | <?php echo $product['naam']; ?></title>
    </head>
    <body>
        <div class="row justify-content-md-center main-container">
            <div class="col-md-7 rounded shadow" style="padding: 1%; background-color: #EEEEEE;">
                <div class="row">
                    <div class="col-md-6">
						<div id="carouselExampleIndicators" class="carousel slide product-carousel" data-ride="carousel">
							<ol class="carousel-indicators product-carousel-indicators">
								<?php
								for($i=0; $i < count($productmedia["img"]); $i++) {
									if($i == 0) {
										print('<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" class="active"></li>');
									} else {
										print('<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'"></li>');
									}
								}
								?>
							</ol>
							<div class="carousel-inner">
								<?php
								for($i=0; $i < count($productmedia["img"]); $i++) { ?>
									<div class="carousel-item<?php if($i == 0) { print(" active"); } ?>">
										<img class="d-block w-100" src="<?php print($productmedia['img'][$i]); ?>" alt="Image">
									</div>
								<?php } ?>
							</div>
							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
                    </div>
                    <div class="col-md-6">
						<h3 style="padding-bottom: 5%;"><?php echo $product['naam']; ?></h3>
                        <h4>Prijs(Inclusief BTW): €<?php echo $product['prijs']; ?>,-</h4><br/>
                        <p><?php echo $product['omschrijving']; ?></p><br/>
                        <?php if($product['hoeveelheid']<20){?>
                        <p><?php echo $product['naam']?> is bijna uitverkocht</p><br/>
                        <?php
                        } else{?>
                            <p>Er zijn nog <?php echo $product['hoeveelheid']; ?> op voorraad</p><br/>
                        <?php
                        }
                        ?>
                        <br/>
                        <form class="product-form" action="ProductPage.php?product=<?php print($_GET['product']); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="name" value='<?php echo $product['naam']; ?>'>
                            <input type="hidden" name="prijs" value="<?php echo $product['prijs']; ?>">
							<input type="hidden" name="mainimage" value="<?php echo $product['mainimage']; ?>">
                            Aantal: <input type="number" name="aantal" value="1" min=1 max=<?php echo $product['hoeveelheid']; ?> style="width: 10%;"/>
							<input class="btn btn-primary" type="submit" name="bestellen" value="Aan winkelwagen toevoegen"/>
                        </form>
                    </div>
                </div>
				<?php
				if(count($productmedia["video"]) > 0) { ?>
					<hr class="product-divider">
					<div class="row">
						<div class="col-md-12 mx-auto product-video">
							<h4>Video</h4>
								<?php
								foreach($productmedia["video"] as $filename => $type) { ?>
									<video class="w-50" controls>
										<source src="<?php print($filename); ?>" type="<?php print($type); ?>">
										<!--<source src="mov_bbb.ogg" type="video/ogg">-->
										Your browser does not support HTML5 video.
									</video><br>
								<?php } ?>
						</div>
					</div>
				<?php } ?>
				<hr class="product-divider">
				<div class="row justify-content-md-center">
					<div class="col-sm-6 text-center" style="padding: 2%; background-color: #EEEEEE">
						<h4>Vergelijkbare producten</h4>
					</div>
        		</div>
				<div class="row justify-content-md-center">
					<?php
					$productnaamverkleind = substr($product['naam'], 0, 4);
					$resultaatvergelijkbareproducten = DBQuery("SELECT si.StockItemID, StockItemName, unitprice, MainImage FROM stockitems si LEFT JOIN mainimgforitem mi ON mi.StockItemID=si.StockItemID WHERE StockItemName LIKE '$productnaamverkleind%' AND StockItemName NOT IN (SELECT StockItemName FROM stockitems WHERE StockItemID = $productid) LIMIT 3", null);
                    foreach ($resultaatvergelijkbareproducten as $product) {
						if(!isset($product["MainImage"])) {
							$product["MainImage"] = "img/default.png";
						}
                        ?>
						<div class="col-4">
							<div class="card list-product-item">
								<img class="card-img-top" src="<?php print($product["MainImage"]); ?>" alt="Card image cap">
								<div class="card-body">
									<h5 class="card-title list-product-item-title"><?php echo $product["StockItemName"]; ?></h5>
								</div>
								<div class="card-footer">
									<p class="card-text float-left"><?php echo "€" . $product["unitprice"]; ?></p>
									<a href="ProductPage.php?product=<?php print($product['StockItemID']); ?>" class="btn btn-primary float-right">Bekijken</a>
								</div>
							</div>
						</div>
                        <?php
                    }
                    ?>
				</div>
				<hr class="product-divider">
				<?php
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
				} else {
					$onestarpercentage = 0;
					$twostarpercentage = 0;
					$threestarpercentage = 0;
					$fourstarpercentage = 0;
					$fivestarpercentage = 0;
				}
				?>
				<div class="row justify-content-md-center">
					<div class="margincol-sm-6">
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
							<div class="row justify-content-center">
								<div class="col-9">
									<div class="row"; align="left">
										<div class="side">
											<div>5 sterren</div>
										</div>
										<div class="middle" align="left">
											<div class="bar-container" style="background-color: #747474;">
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
											<div class="bar-container" style="background-color: #747474;">
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
											<div class="bar-container" style="background-color: #747474;">
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
											<div class="bar-container" style="background-color: #747474;">
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
											<div class="bar-container" style="background-color: #747474;">
												<div class="bar-1" style="margin: 0 auto; width: <?php print($onestarpercentage); ?>%";></div>
											</div>
										</div>
										<div class="side right">
											<div><?php Print_R($onestar[0]["COUNT(StarRating)"]); ?></div>
										</div>
									</div>
								</div>
								<?php
								if(isset($_SESSION['userinfo']['id'])) {
									?>
									<div class="col-3 justify-content-center">
										<form action="RatingToDatabase.php" method="post">
											<input type="radio" name="star" value="1"/> 1 ster<br>
											<input type="radio" name="star" value="2"/> 2 sterren<br>
											<input type="radio" name="star" value="3"/> 3 sterren<br>
											<input type="radio" name="star" value="4"/> 4 sterren<br>
											<input type="radio" name="star" value="5"/> 5 sterren<br><br>
											<input type="hidden" name="ID" value="<?php print($productid); ?>"/>
											<button class="btn btn-primary" type="submit">Versturen</button>
										</form>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </body>
    <?php
    include "footer.php";
    ?>
</html>