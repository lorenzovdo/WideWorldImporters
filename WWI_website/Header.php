<!DOCTYPE html>
<html>
    <header>
        <meta charset="UTF-8">
        <title>WWI</title>
    </header>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["Shoppingcart"])) {
        $_SESSION["Shoppingcart"] = array();
    }
    include_once 'Functions.php';
    ?>

    <nav class="navbar navbar-expand-lg navbar-custom"> <!--navbar-dark bg-primary">-->
        <a class="navbar-brand" href="index.php">Wide World Importers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mx-auto w-50 justify-content-md-center">
				<form class="form-inline w-100 justify-content-md-center" method="get" action="index.php">
					<input class="form-control mr-sm-2 w-50" type="search" name="search" placeholder="Search" aria-label="Search"<?php if(filter_has_var(INPUT_GET, "search")) { print('value='.filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING)); }?>>
					<button class="btn btn-primary btn-outline-light my-2 my-sm-0" type="submit">Search</button>
					<?php
					if (filter_has_var(INPUT_GET, "cat")) {
						$_GET["cat"];
						foreach($_GET["cat"] as $cat_id) {
							print('<input type="hidden" name="cat[]" value="'.filter_var($cat_id, FILTER_SANITIZE_STRING).'"/>');
						}
					}
					?>
				</form>
			</ul>
			<ul class="navbar-nav mr-5">
				<li class="nav-item mr-3">
					<?php
					if(isset($_SESSION['userinfo'])){
						echo '<a class="nav-link" href="Logout.php">Hallo '.$_SESSION['userinfo']['firstname'] .' '.$_SESSION['userinfo']['infix'].' '.$_SESSION['userinfo']['lastname'].'</a>';
					} else {
						?><a class="nav-link" href="LoginAndRegister.php">Inloggen</a><?php
					}
					?>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle pb-0 pt-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="Img/winkelwagen.png" height="40px" width="40px"/>
					</a>
					<div class="dropdown-menu dropdown-menu-right winkelwagen-dropdown" aria-labelledby="navbarDropdown">
						<h2 class="dropdown-header text-center winkelwagen-header">Winkelwagen</h2>
						<div class="dropdown-divider"></div>
						<?php
						$totaalPrijs = null;
						foreach ($_SESSION["Shoppingcart"] as $key => $value) {
							if (strlen($value[0]) > 18) {
								$value[0] = substr($value[0], 0, 24) . '...';
							}
							print('<a class="dropdown-item winkelwagen-item" href="ProductPage.php?product='.$key.'">' . $value[0] . '<span class="float-right">' . $value[1] . 'x</span></a>');
							$prijs = $value[1] * $value[2];
							$totaalPrijs = $totaalPrijs + $prijs;
						}
						?>
						<div class="dropdown-divider mt-5"></div>
						<p class="dropdown-item">Totaalprijs<span class="float-right"><?php echo '€' . number_format($totaalPrijs, 2); ?></span></p>
						<div class="dropdown-divider"></div>
						<?php
						if($totaalPrijs > 0){
							if(isset($_SESSION['userinfo'])){
								?><p class="dropdown-item"><a class="btn btn-primary w-100" href="ConfirmPage.php?logged=1" role="button">Afrekenen ></a></p><?php
							} else {
								?><p class="dropdown-item"><a class="btn btn-primary w-100" href="SignUpPage.php" role="button">Afrekenen ></a></p><?php
							}
						}
						?>
						<a class="dropdown-item text-center" href="Shoppingcart.php">Winkelwagen bekijken</a>
					</div>
				</li>
			</ul>
		</div>
    </nav>
</html>
