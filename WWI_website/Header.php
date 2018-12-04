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
    <script rel="stylesheet" src="css/Style.css"></script>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["Shoppingcart"])) {
        $_SESSION["Shoppingcart"] = array();
    }
    include 'Functions.php';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php" style="padding-right: 15%;">Wide World Importers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="col-lg-4">
                <form class="form-inline my-2 my-lg-0" method="get" action="index.php">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    <?php if (filter_has_var(INPUT_GET, "category")) { ?>
                        <input type="hidden" name="category" value="<?php print($_GET["category"]); ?>">
                    <?php } ?>
                </form>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-2 ">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="Img/winkelwagen.jpg" height="30%" width="30%"/>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            $totaalPrijs = null;
                            foreach ($_SESSION["Shoppingcart"] as $key => $value) {
                                if (strlen($value[0]) > 18) {
                                    $value[0] = substr($value[0], 0, 18) . '...';
                                }
                                print("<p>" . $value[0] . " " . $value[1] . "</p>");
                                $prijs = $value[1] * $value[2];
                                $totaalPrijs = $totaalPrijs + $prijs;
                            }
                            ?>
                            <div class="dropdown-divider"></div>
                            <p>Totaal <?php echo '€' . number_format($totaalPrijs, 2); ?></p>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" style="background-color: yellow" href="Shoppingcart.php">Winkelwagen inzien</a>
                            <div class="dropdown-divider"></div>
                            <?php
                            if($totaalPrijs > 0){
                                if(isset($_SESSION['userinfo'])){
                                    ?><a class="dropdown-item" style="background-color: greenyellow" href="ConfirmPage.php">Afrekenen</a><?php
                                }else
                                {
                                    ?><a class="dropdown-item" style="background-color: greenyellow" href="SignUpPage.php">Afrekenen</a><?php
                                }
                            }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-2">
                <?php
                    if(isset($_SESSION['userinfo'])){
                        echo '<a class="navbar-brand" href="Logout.php" style="padding-right: 15%;">Hallo '.$_SESSION['userinfo']['firstname'] .' '.$_SESSION['userinfo']['infix'].' '.$_SESSION['userinfo']['lastname'].'</a>';
                    }
                    else{
                        ?><a class="navbar-brand" href="LoginAndRegister.php" style="padding-right: 15%;">Inloggen</a><?php
                    }
                ?>
            </div>
        </div>
    </nav>
</html>
