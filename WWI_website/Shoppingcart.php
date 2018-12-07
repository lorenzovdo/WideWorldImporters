<?php
include 'Header.php';
?>
<html>
    <body>
        <div class="row justify-content-md-center main-container">
            <div class="col-md-5">
                <div class="row">
                    <?php
                    foreach ($_SESSION["Shoppingcart"] as $key => $value) { ?>
						<div class="col-12 rounded shadow" style="background-color:#cecece; height: 200 px; padding: 1%; margin-bottom: 2%;">
							<img style="width: 30%;" src="<?php print($value[3]); ?>	">
							<div class="col-8" style="float: right;"><p> Product: <?php print($value[0]); ?></p>
								Aantal:<form action="ManageShoppingcart.php" method="post">
									<input type="hidden" name="id" value="<?php print($key); ?>"/>
									<input type="submit" name="submit" value="-"/>
								</form>
								<?php print($value[1]); ?>
								<form action="ManageShoppingcart.php" method="post">
									<input type="hidden" name="id" value="<?php print($key); ?>"/>
									<input type="submit" name="submit" value="+"/>
								</form>
								<p>Prijs per stuk: €<?php print($value[2]); ?></p>
								<p>Totaal product: €<?php print(number_format($value[2] * $value[1],2)); ?></p>
							</div>
						</div>
					<?php } ?>
				</div>
            </div>
			<div class="col-2">
				<div class="card shadow">
					<div class="card-header cat-header">Totaalprijs</div>
					<div class="card-body">
							<?php
							$totaalPrijs = null;
							foreach ($_SESSION["Shoppingcart"] as $key => $value) {
								$totaalPrijs = $totaalPrijs + ($value[2] * $value[1]);
							}
							?>
							<p>Subtotaal: €<?php print(number_format($totaalPrijs,2)); ?></p>
							<p>Verzending: Gratis</p>
							<hr>
							<p>Totaalprijs (inclusief btw): €<?php print(number_format($totaalPrijs,2)); ?></p>
					</div>
					<div class="card-footer cat-footer">
						<?php
						if(isset($_SESSION['userinfo'])) { ?>
							<a class="btn btn-primary" href="ConfirmPage.php?logged=1" role="button">Door naar kassa</a>
						<?php } else { ?>
							<a class="btn btn-primary" href="SignUpPage.php" role="button">Door naar kassa</a>
						<?php } ?>
					</div>
				</div>
        	</div>
		</div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>
