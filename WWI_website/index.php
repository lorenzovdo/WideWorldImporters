<!DOCTYPE html>
<html>
    <body>
        <?php
        include 'Header.php';
        PDODBConn();

        $offset = 0;
        $limit = 6;
        if (filter_has_var(INPUT_GET, "page")) {
            $currentPage = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
            $offset = $currentPage * $limit - $limit;
        } else {
            $currentPage = 1;
        }

        $search = null;
        $searchCategory = null;
        #categorie zoeken
        if (filter_has_var(INPUT_GET, "category")) {
            $searchCategory = filter_input(INPUT_GET, "category", FILTER_SANITIZE_STRING);
            if (filter_has_var(INPUT_GET, "search")) {
                $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
                $resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, photo FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid "
                        . "JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '$searchCategory' AND searchdetails LIKE '%$search%' LIMIT $limit  OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid "
                        . "JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '$searchCategory' AND searchdetails LIKE '%$search%'", null);
            } else {
                $resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, photo FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '$searchCategory' LIMIT $limit  OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '$searchCategory'", null);
            }
        } elseif (filter_has_var(INPUT_GET, "search")) {
            $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
            $resultQuery = DBQuery("SELECT StockItemID, stockitemname, unitprice, photo FROM stockitems WHERE searchdetails LIKE '%$search%' LIMIT $limit  OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems WHERE searchdetails LIKE '%$search%'", null);
        } else {
            $resultQuery = DBQuery("SELECT StockItemID, stockitemname, unitprice, photo FROM stockitems LIMIT $limit OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems", null);
        }
        $resultCount = $resultCount[0]["COUNT(*)"];
        $pageCount = ceil($resultCount / $limit);
        ?>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-2" style="padding-right: 2%;">
                <div style="background-color:#EEEEEE; border: 1px solid black;">
                    <h3 style="text-align:center;">Categorieën</h3>
                    <?php
                    $resultQueryCategory = DBQuery("SELECT stockgroupname FROM stockgroups", null);
                    foreach ($resultQueryCategory as $category) {
                        ?>
                        <form method="get" action="index.php">
                            <img src="Img/<?php print($category["stockgroupname"]); ?>.jpg" style="width: 10%; height: 10%;"><input type="submit" name="category" value="<?php print($category["stockgroupname"]); ?>">
                        </form>
                        <br>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-7"><!--style="background-color:#AAAAAA"-->
                <div class="row">

                    <?php 
                    relaySearchTerm($limit, $resultCount, $search, $searchCategory);
                    foreach ($resultQuery as $product) {
                        ?>
                        <div class="col-4" style="height: 450px; padding: 1%; padding-top: 0;" onclick="window.location = 'ProductPagina.php?product=<?php print($product['StockItemID']); ?>';">
                            <div style="background-color:#999999; width: 100%; height:100%;">
                                <table>
                                    <tr><td><img src="Img/default.jpg" style="width: 100%; height: 40%;"></td>
                                    <tr><td><?php
                                            print($product["stockitemname"]);
                                            print("    -   € " . $product["unitprice"]);
                                            ?> </td></tr>
                                </table>
                            </div>
                        </div>                       
                        <?php
                    }
                    ?>
                    <div class="col-12" style="text-align: center"> 
                        <?php showPageSelection($currentPage, $pageCount); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>