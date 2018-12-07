<!DOCTYPE html>
<html>
    <body>
        <?php
        include 'Header.php';
        PDODBConn();

        //$resultQueryCategory = DBQuery("SELECT stockgroupname FROM stockgroups", null);
		$categories = getCategories();
		$selected_categories = array();
		if(filter_has_var(INPUT_GET, "cat")) {
			foreach($_GET["cat"] as $cat_id) {
				array_push($selected_categories, filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT));
			}
		}

        $offset = 0;
        $limit = 12;
        if (filter_has_var(INPUT_GET, "page")) {
            $currentPage = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
            $offset = $currentPage * $limit - $limit;
        } else {
            $currentPage = 1;
        }
        $search = null;
        #categorie zoeken
        if (filter_has_var(INPUT_GET, "cat")) {
            if (filter_has_var(INPUT_GET, "search")) {
                $search = "'%".filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING)."%'";
				$categoriesQuery = arrayToIN($selected_categories);
                $resultQuery = DBQuery("SELECT DISTINCT si.StockItemID, stockitemname, unitprice, MainImage FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid LEFT JOIN mainimgforitem mi ON mi.StockItemID=si.StockItemID WHERE stockgroupid IN ($categoriesQuery) AND searchdetails LIKE $search LIMIT $limit OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(DISTINCT si.StockItemID) count FROM stockitems si JOIN stockitemstockgroups sig on si.stockitemid=sig.stockitemid WHERE stockgroupid IN ($categoriesQuery) AND searchdetails LIKE $search", null);
            } else {
				$categoriesQuery = arrayToIN($selected_categories);
                $resultQuery = DBQuery("SELECT DISTINCT si.StockItemID, stockitemname, unitprice, MainImage FROM stockitems si JOIN stockitemstockgroups sig ON si.stockitemid=sig.stockitemid LEFT JOIN mainimgforitem mi ON mi.StockItemID=si.StockItemID WHERE stockgroupid IN ($categoriesQuery) LIMIT $limit OFFSET $offset", null);
                $resultCount = DBQuery("SELECT COUNT(DISTINCT si.StockItemID) count FROM stockitems si JOIN stockitemstockgroups sig ON si.stockitemid=sig.stockitemid WHERE stockgroupid IN ($categoriesQuery)", null);
            }
        } elseif (filter_has_var(INPUT_GET, "search")) {
            $search = "'%".filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING)."%'";
            $resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, MainImage FROM stockitems si LEFT JOIN mainimgforitem mi ON mi.StockItemID=si.StockItemID WHERE searchdetails LIKE $search LIMIT $limit OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) count FROM stockitems WHERE searchdetails LIKE $search", null);
        } else {
			$resultQuery = DBQuery("SELECT si.StockItemID, stockitemname, unitprice, MainImage FROM stockitems si LEFT JOIN mainimgforitem mi ON mi.StockItemID=si.StockItemID LIMIT $limit OFFSET $offset", null);
            $resultCount = DBQuery("SELECT COUNT(*) count FROM stockitems", null);
        }
        $resultCount = $resultCount[0]["count"];
        $pageCount = ceil($resultCount / $limit);
        ?>
        <div class="row justify-content-md-center main-container">
            <div class="col-2">
				<div class="card shadow">
					<form method="get" action="index.php">
						<div class="card-header cat-header">Categorieën</div>
						<div class="card-body">
								<?php
								foreach($categories as $cat_id => $cat_name) {
									?>
									<div class="form-check cat-form-check">
										<input class="form-check-input" type="checkbox" name="cat[]" value="<?php print($cat_id); ?>" id="<?php print($cat_name); ?>" <?php if(in_array($cat_id, $selected_categories)) { print("checked"); } ?>>
										<label class="form-check-label" for="<?php print($cat_name); ?>">
											<img src="Img/<?php print($cat_name); ?>.jpg" style="width: 10%; height: 10%;">
											<?php print($cat_name); ?>
										</label>
									</div>
								<?php
								}
								if(filter_has_var(INPUT_GET, "search")) {
									print('<input type="hidden" name="search" value="'.filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING).'" />');
								}
								?>
						</div>
						<div class="card-footer cat-footer">
							<button type="submit" class="btn btn-primary">Toepassen</button>
						</div>
					</form>
				</div>
            </div>
            <div class="col-7">
				<div class="row">
					<div class="col-12 margin-b2">
						<div class="card shadow">
							<div class="card-body">
								Geselecteerde categorieën:
								<?php
								foreach($selected_categories as $counter => $cat_id) {
									$tekst = " ".$categories[$cat_id];
									if(count($selected_categories) != $counter + 1) {
										$tekst .= ",";
									}
									echo $tekst;
								}
								?>
							</div>
						</div>
					</div>
					<?php
                    foreach ($resultQuery as $product) {
						if(!isset($product["MainImage"])) {
							$product["MainImage"] = "img/default.png";
						}
                        ?>
						<div class="col-4">
							<div class="card list-product-item">
								<img class="card-img-top" src="<?php print($product["MainImage"]); ?>" alt="Card image cap">
								<div class="card-body">
									<h5 class="card-title list-product-item-title"><?php echo $product["stockitemname"]; ?></h5>
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