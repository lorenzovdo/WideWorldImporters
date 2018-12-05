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
    if (filter_has_var(INPUT_GET, "category")) {
        //voeg category parameter toe als dit nodig is
        $link .= "&category=" . $_GET["category"];
    }
    //voltooi <a> tag
    $link .= "\">$page</a> ";
    print $link;
}

function createAnonymousUser() {
    $_SESSION['anonymousUser'] = array();
    $_SESSION['anonymousUser']['firstname'] = $_POST['firstname'];
    $_SESSION['anonymousUser']['infix'] = $_POST['infix'];
    $_SESSION['anonymousUser']['lastname'] = $_POST['lastname'];
    $_SESSION['anonymousUser']['email'] = $_POST['email'];
    $_SESSION['anonymousUser']['postalcode'] = $_POST['postalcode'];
    $_SESSION['anonymousUser']['housenumber'] = $_POST['housenumber'];
}

function getUserInfo() {
    if (isset($_SESSION['userinfo'])) {
        echo '<p style="text-align: center">Voornaam: ' . $_SESSION['userinfo']['firstname'] . '</p>'
        . '<p style="text-align: center">Tussenvoegsel: ' . $_SESSION['userinfo']['infix'] . '</p>'
        . '<p style="text-align: center">Achternaam: ' . $_SESSION['userinfo']['lastname'] . '</p>'
        . '<p style="text-align: center">Postcode: ' . $_SESSION['userinfo']['postalcode'] . '</p>'
        . '<p style="text-align: center">Huisnummer: ' . $_SESSION['userinfo']['housenumber'] . '</p>';
    } else {
        echo '<p style="text-align: center">Voornaam: ' . $_SESSION['anonymousUser']['firstname'] . '</p>'
        . '<p style="text-align: center">Tussenvoegsel: ' . $_SESSION['anonymousUser']['infix'] . '</p>'
        . '<p style="text-align: center">Achternaam: ' . $_SESSION['anonymousUser']['lastname'] . '</p>'
        . '<p style="text-align: center">Postcode: ' . $_SESSION['anonymousUser']['postalcode'] . '</p>'
        . '<p style="text-align: center">Huisnummer: ' . $_SESSION['anonymousUser']['housenumber'] . '</p>';
    }
}

function makeOrder() {
    global $pdo;
    PDODBConn();
    $date = date('Y-m-d');
    $order = DBQuery("INSERT INTO `weborders` values (null, " . $_SESSION['userinfo']['id'] . ", \" ". $date."\")", null);
    $orderID = $pdo->lastInsertId();
    foreach ($_SESSION['Shoppingcart'] as $key => $value) {
        DBQuery("INSERT INTO `itemsInOrder` values (" . $orderID . "," . $key . ", " . $value[1] . ")", null);
        DBQuery("UPDATE `stockitemholdings` SET `QuantityOnHand` = `QuantityOnHand` - ".$value[1]." WHERE `StockItemID` = ".$key." ", null);
    }
}
