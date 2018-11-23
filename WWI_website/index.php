<!DOCTYPE html>
<html>
    <body>
        <?php
        include 'Header.php';
        PDODBConn();
        $resultQueryCategory = DBQuery("SELECT stockgroupname FROM stockgroups", null);
        $offset = 0;
        $limit = 6;
        if (filter_has_var(INPUT_GET, "page")) {
            $currentPage = $_GET["page"];
            $offset = $currentPage * $limit - $limit;
        } else {
            $currentPage = 1;
        }
        #catzoeken
        if (filter_has_var(INPUT_GET, "category")) {
            if (filter_has_var(INPUT_GET, "search")) {
                $resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, photo FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid "
                        . "JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '" . $_GET["category"] . "' AND searchdetails LIKE '%" . $_GET["search"] . "%' LIMIT $limit  OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid "
                        . "JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '" . $_GET["category"] . "' AND searchdetails LIKE '%" . $_GET["search"] . "%'", null);
                $pageCount = ceil($resultCount[0]["COUNT(*)"] / $limit);
            } else {
                $resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, photo FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '" . $_GET["category"] . "' LIMIT $limit  OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid JOIN stockgroups sg on sig.stockgroupid=sg.stockgroupid where stockgroupname = '" . $_GET["category"] . "'", null);
                $pageCount = ceil($resultCount[0]["COUNT(*)"] / $limit);
            }
        } elseif (filter_has_var(INPUT_GET, "search")) {
            $resultQuery = DBQuery("SELECT StockItemID, stockitemname, unitprice, photo FROM stockitems WHERE searchdetails LIKE '%" . $_GET["search"] . "%' LIMIT $limit  OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems WHERE searchdetails LIKE '%" . $_GET["search"] . "%'", null);
            $pageCount = ceil($resultCount[0]["COUNT(*)"] / $limit);
        } else {
            $resultQuery = DBQuery("SELECT StockItemID, stockitemname, unitprice, photo FROM stockitems LIMIT $limit OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) FROM stockitems", null);
            $pageCount = ceil($resultCount[0]["COUNT(*)"] / $limit);
        }
        if (filter_has_var(INPUT_GET, "page")) {
            if ($currentPage < 1 || $currentPage > $pageCount) {
                
            }
        }
        ?>
        <div class="row justify-content-md-center" style="margin: 0; margin-top: 3%;">
            <div class="col-2" style="padding-right: 2%;">
                <div style="background-color:#EEEEEE; border: 1px solid black;">
                    <h3 style="text-align:center;">Categorieën</h3>
                    <?php
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