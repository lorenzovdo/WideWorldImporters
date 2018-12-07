<?php

global $pdo;

/*
 * PDODBConn is een functie die een connectie maakt met de database.
 * Voor het maken van de connectie word de root user gebruikt.
 * De connectie word gemaakt met de wideworldimporters database op port 3306
*/
function PDODBConn() {
    try {
        global $pdo;
        $db = "mysql:host=localhost;dbname=wideworldimporters;port=3306";
        $user = "root";
        $pass = "";
        $pdo = new PDO($db, $user, $pass);
    } catch (PDOException $e) {
        print("ERROR!: " . $e->getMessage());
        $pdo = null;
    }
}

/*
 * DBQuery is een functie die een query maakt.
 * $query is een string waar een query word mee gegeven.
 * $params is een string met daarin de params voor de query.
 * De functie maakt gebruik van de functie PDODBConn() als er nog geen connectie met de database is.
*/

function DBQuery($query, $params) {
    global $pdo;
    if (!isset($pdo)) {
        PDODBConn();
    }
    $stmt = $pdo->prepare($query);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($params == null) {
        $stmt->execute();
    } else {
        $stmt->execute($params);
    }
    return $stmt->fetchall();
}

/*
 * removeFromShoppingcart gebruik een item id die in de shoppincart staat.
 * Het item dat in de shoppincart staat word geunset.
 * Unset is een functie de gegevens uit een array verwijderd.
*/

function removeFromShoppingcart($item) {
    unset($_SESSION["Shoppingcart"][$item]);
}

/*
 * increaseNumberInShoppingcart gebruik een item id die in de shoppincart staat.
 * Het aantal van het item in de shoppincart met met 1 verhoogt.
*/

function increaseNumberInShoppingcart($item) {
    $_SESSION["Shoppingcart"][$item][1] = $_SESSION["Shoppingcart"][$item][1] + 1;
}

/*
 * decreaseNumberInShoppingcart gebruik een item id die in de shoppincart staat.
 * Er word eerst gekeken naar de hoeveelheid van het aantal van dit item in de shoppincart
 * Als het aantal 1 of minder is van dit item word de removeFromShoppingcart functie aangeroepen
 * Als het aantal meer dan 1 is word het aantal van dit item met 1 verlaagt.
*/

function decreaseNumberInShoppingcart($item) {
    if ($_SESSION["Shoppingcart"][$item][1] <= 1) {
        removeFromShoppingcart($item);
    } else {
        $_SESSION["Shoppingcart"][$item][1] = $_SESSION["Shoppingcart"][$item][1] - 1;
    }
}

/*
 * sendMail maakt met 2 parameters een email en stuurt hem op.
 * $userinfo is een array met daarin de contactgegevens van de klant.
 * $ordernumber is een int met het ordernummer die bij de order hoort.
*/

function sendMail($userinfo, $ordernumber) {
    $firstname = $userinfo['firstname'];
    $infix = $userinfo['infix'];
    $lastname = $userinfo['lastname'];
    $email = $userinfo['email'];
    $postalcode = $userinfo['postalcode'];
    $housenumber = $userinfo['housenumber'];

    $from = "Info@WideWorldImporters.com";
    $to = $email;
    $bcc = null;

    $header = "FROM: " . $from . "\r\n" .
            "Reply-To: " . $from . "\r\n" .
            "Return-Path: " . $from . "\r\n" .
            "Message-ID: <" . time() . "." . $from . ">\r\n" .
            "BCC: " . $bcc;

    $message = "Bedankt voor winkelen bij Wide World Importers.\r\n"
            . "De pakketjes worden verstuurd naar onderstaande persoon en adres.\r\n\r\n"
            . "Gegevens:\r\n"
            . "Voornaam: " . $firstname . "\r\n"
            . "Tussenvoegsel: " . $infix . "\r\n"
            . "Achternaam: " . $lastname . "\r\n"
            . "Email: " . $email . "\r\n"
            . "Postcode: " . $postalcode . "\r\n"
            . "Huisnummer: " . $housenumber . "";
    //mail is een php functie die een email verstuurd naar het email adres.
    mail($to, "Bestelling ordernr: " . $ordernumber, $message, $header);
}

function sendRegisterMail($firstname, $infix, $lastname, $email) {
    $from = "Info@WideWorldImporters.com";
    $to = $email;
    $bcc = null;

    $header = "FROM: " . $from . "\r\n" .
            "Reply-To: " . $from . "\r\n" .
            "Return-Path: " . $from . "\r\n" .
            "Message-ID: <" . time() . "." . $from . ">\r\n" .
            "BCC: " . $bcc;

    $message = "Bedankt voor aanmaken van een account bij Wide World Importers.\r\n"
            . "Via deze email word het account geactiveerd.\r\n\r\n"
            . "Gegevens:\r\n"
            . "Voornaam: " . $firstname . "\r\n"
            . "Tussenvoegsel: " . $infix . "\r\n"
            . "Achternaam: " . $lastname . "\r\n"
            . "Email: " . $email . "\r\n";
    //mail is een php functie die een email verstuurd naar het email adres.
    mail($to, "Register mail", $message, $header);
}

/*
 * showPageSelection neemt de parameters $currentPage (int) en $pageCount (int) en toont
 * de huidige pagina en links naar volgende en vorige pagina's waar toepasselijk
*/

function showPageSelection($currentPage, $pageCount) {
    if ($currentPage - 2 > 1) { //terug naar eerste pagina
        createPageLink(1);
        print(" ...");
    }
    if ($currentPage - 2 > 0) { //twee pagina's terug
        createPageLink($currentPage - 2);
    }
    if ($currentPage - 1 > 0) { //een pagina terug
        createPageLink($currentPage - 1);
    }

    print($currentPage . " "); //huidige pagina

    if ($currentPage < $pageCount) { //een pagina vooruit
        createPageLink($currentPage + 1);
    }
    if ($currentPage + 1 < $pageCount) { //twee pagina's vooruit
        createPageLink($currentPage + 2);
    }
    if ($currentPage + 2 < $pageCount) { //naar de laatste pagina
        print("... ");
        createPageLink($pageCount);
    }
}

/*
 * maakt een link aan naar de pagina met nummer $page binnen de bepaalde search en category
*/

function createPageLink($page) {
    //begin <a> tag
    $link = "<a href=\"index.php?page=$page";
    if (filter_has_var(INPUT_GET, "search")) {
        //voeg search parameter toe als dit nodig is
        $link .= "&search=" . $_GET["search"];
    }
    if (filter_has_var(INPUT_GET, "cat")) {
        //voeg category parameter toe als dit nodig is
		foreach($_GET["cat"] as $add) {
			$link .= "&cat%5B%5D=".$add;
		}
    }
    //voltooi <a> tag
    $link .= "\">$page</a> ";
    print $link;
}

/*
 * Deze functie stuurt een query naar de database om de categorieën op te halen.
 * De resultaten worden verwerkt in een array waarbij de key het ID van de categorie is
 * en value de naam van de categorie.
 */
function getCategories() {
	$q_result = DBQuery("SELECT StockGroupID, StockGroupName FROM stockgroups", null);
	$categories = array();

	foreach($q_result as $cat) {
		$categories[$cat["StockGroupID"]] = $cat["StockGroupName"];
	}

	return $categories;
}

/*
 * Deze functie ontvangt een array met integers. Deze integers worden in een string gezet.
 * Elk getal wordt gescheiden d.m.v. een komma. Het laatste getal wordt niet bijgevuld met een komma.
 * Deze functie is bedoeld voor het gebruik kunnen maken van de SQL vergelijking "IN".
 */
function arrayToIN($array) {
	$in = "";
	foreach ($array as $i => $item)
	{
		$in .= "$item,";
	}
	$in = rtrim($in,",");
	return $in;
}

/*
 * Deze functie voegt een "anonymous" user toe aan de session
 * Hierdoor hoeft de gebruiker niet in te loggen maar zijn de gegevens nog bekend voor mail etc.
 */
function createAnonymousUser()
{
    $_SESSION['anonymousUser'] = array();
    $_SESSION['anonymousUser']['firstname'] = $_POST['firstname'];
    $_SESSION['anonymousUser']['infix'] = $_POST['infix'];
    $_SESSION['anonymousUser']['lastname'] = $_POST['lastname'];
    $_SESSION['anonymousUser']['email'] = $_POST['email'];
    $_SESSION['anonymousUser']['postalcode'] = $_POST['postalcode'];
    $_SESSION['anonymousUser']['housenumber'] = $_POST['housenumber'];
}

/*
 * Deze functie print een lijst met de gebruiker zijn informatie.
 * Als de gebruiker ingelogd is worden de gegevens van de ingelogde gebruiker gebruikt.
 * Indien de gebruiker niet ingelogd is, worden de gegevens gebruikt die eerder
 * aangemaakt zijn via de functie "createAnonymousUser".
 */
function getUserInfo() {
    if (isset($_SESSION['userinfo'])) {
		echo '<table>'
		.'<tr><td>Voornaam:</td><td>'.$_SESSION['userinfo']['firstname'].'</td></tr>'
		.'<tr><td>Tussenvoegsel:</td><td>'.$_SESSION['userinfo']['infix'].'</td></tr>'
		.'<tr><td>Achternaam:</td><td>'.$_SESSION['userinfo']['lastname'].'</td></tr>'
		.'<tr><td>Postcode:</td><td>'.$_SESSION['userinfo']['postalcode'].'</td></tr>'
		.'<tr><td>Huisnummer:</td><td>'.$_SESSION['userinfo']['housenumber'].'</td></tr>'
		.'</table>';
    } else {
		echo '<table>'
		.'<tr><td>Voornaam:</td><td>'.$_SESSION['anonymousUser']['firstname'].'</td></tr>'
		.'<tr><td>Tussenvoegsel:</td><td>'.$_SESSION['anonymousUser']['infix'].'</td></tr>'
		.'<tr><td>Achternaam:</td><td>'.$_SESSION['anonymousUser']['lastname'].'</td></tr>'
		.'<tr><td>Postcode:</td><td>'.$_SESSION['anonymousUser']['postalcode'].'</td></tr>'
		.'<tr><td>Huisnummer:</td><td>'.$_SESSION['anonymousUser']['housenumber'].'</td></tr>'
		.'</table>';
    }
}

function getProductInfo($id) {
	$product = array();
	$result = DBQuery("SELECT S.StockItemID, StockItemName, MarketingComments, UnitPrice, SH.QuantityOnHand, MainImage FROM stockitems S JOIN stockitemholdings SH ON S.stockitemID = SH.stockitemID LEFT JOIN mainimgforitem mi ON mi.StockItemID=S.StockItemID WHERE S.StockItemID=?", array($id));
    $product['id'] = $result[0]['StockItemID']; // Zucht... DBQuery stuurt een 2d array, dus moet deze vrolijke hack toegepast worden...
    $product['naam'] = $result[0]['StockItemName'];
    $product['prijs'] = $result[0]['UnitPrice'];
    $product['omschrijving'] = $result[0]['MarketingComments'];
    $product['hoeveelheid'] = $result[0]['QuantityOnHand'];
	if(isset($result[0]['MainImage'])) {
		$product['mainimage'] = $result[0]['MainImage'];
	} else {
		$product['mainimage'] = "img/default.png";
	}

	return $product;
}

function getProductMedia($id) {
	$productmedia = array("img" => array(), "video" => array());
	$result = DBQuery("SELECT FileName, Type FROM imgForItem WHERE StockItemID=? ORDER BY ordern", array($id));

	foreach($result as $media) {
		if($media["Type"] == "img") {
			array_push($productmedia["img"], $media["FileName"]);
		} else {
			$productmedia["video"][$media["FileName"]] = $media["Type"];
		}
	}

	if(count($productmedia["img"]) < 1) {
		$productmedia["img"] = array("img/default.png", "img/defaultinverted.png");
	}

	return $productmedia;
}

/*
 * postalcodeCheck controleert of de invoerstring $postalcode volgens de nederlandse postcoderegels is
 * return de true als de postcode correct is
 * return false als de postcode incorrect is
 */
function postalcodeCheck($postalcode) {
    $remove = str_replace(" ","", $postalcode);
    $upper = strtoupper($remove);
    if( preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return true;
    } else {
        return false;
    }
}

function makeOrder() {
    global $pdo;
    PDODBConn();
    $date = date('Y-m-d');
	if(isset($_SESSION['userinfo'])) {
		$userid = $_SESSION['userinfo']['id'];
		$order = DBQuery("INSERT INTO `weborders` (OrderID, UserID, Date) values (null, " . $userid . ", \" ". $date."\")", null);
	} else { // Firstname Infix Lastname Postalcode Housenumber
		$order = DBQuery("INSERT INTO `weborders` (OrderID, Date, Firstname, Infix, Lastname, Postalcode, Housenumber) values (null, \" ". $date."\", '".$_SESSION['anonymousUser']['firstname']."', '".$_SESSION['anonymousUser']['infix']."', '".$_SESSION['anonymousUser']['lastname']."', '".$_SESSION['anonymousUser']['postalcode']."', '".$_SESSION['anonymousUser']['housenumber']."' )", null);
	}
    $orderID = $pdo->lastInsertId();
    foreach ($_SESSION['Shoppingcart'] as $key => $value) {
        DBQuery("INSERT INTO `itemsInOrder` values (" . $orderID . "," . $key . ", " . $value[1] . ")", null);
        DBQuery("UPDATE `stockitemholdings` SET `QuantityOnHand` = `QuantityOnHand` - ".$value[1]." WHERE `StockItemID` = ".$key." ", null);
    }
}