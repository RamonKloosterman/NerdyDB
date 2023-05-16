<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include "header.php";
include "wishlistfuncties.php";

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
$StockItemTag = getCurrentTag($_GET['id'], $databaseConnection);
?>
<?php
// altijd hiermee starten als je gebruik wilt maken van sessiegegevens

if ($StockItem != null) {

?>
<?php
if (isset($StockItem['Video'])) {
  ?>
  <div id="VideoFrame">
    <?php print $StockItem['Video']; ?>
  </div>
<?php }
?>


<div id="ArticleHeader">
  <?php
  if (isset($StockItemImage)) {
    // één plaatje laten zien
    if (count($StockItemImage) == 1) {
      ?>
      <div id="ImageFrame"
           style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;">
      </div>
      <?php
    } else if (count($StockItemImage) >= 2) { ?>
      <!-- meerdere plaatjes laten zien -->
      <div id="ImageFrame">
        <div id="ImageCarousel" class="carousel slide" data-interval="false">
          <!-- Indicators -->
          <ul class="carousel-indicators">
            <?php for ($i = 0; $i < count($StockItemImage); $i++) {
              ?>
              <li data-target="#ImageCarousel"
                  data-slide-to="<?php print $i ?>" <?php print(($i == 0) ? 'class="active"'
                : ''); ?>>
              </li>
              <?php
            } ?>
          </ul>

          <!-- slideshow -->
          <div class="carousel-inner">
            <?php for ($i = 0; $i < count($StockItemImage); $i++) {
              ?>
              <div class="carousel-item <?php print($i == 0) ? 'active' : ''; ?>">
                <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
              </div>
            <?php } ?>
          </div>

          <!-- knoppen 'vorige' en 'volgende' -->
          <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
        </div>
      </div>
      <?php
    }
  } else {
    ?>
    <div id="ImageFrame"
         style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;">
    </div>
    <?php
  }
  ?>


  <h1 class="StockItemID">Artikelnummer:
    <?php print $StockItem["StockItemID"]; ?>
  </h1>
  <h2 class="StockItemNameViewSize StockItemName">
    <?php print $StockItem['StockItemName']; ?>
  </h2>
  <div class="QuantityText">
    <?php
    $voorraad = ltrim($StockItem['QuantityOnHand'], "Vorad:");
    if ($voorraad > 150000) {
      print("Veel op voorraad");
    } else {
      print("Weinig op voorraad");
    }

    ?>







    <?php
    } else {
      ?>
      <h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2>
      <?php
    } ?>
  </div>
    <div id="StockItemHeaderLeft">
        <div class="CenterPriceLeft">
            <div class="CenterPriceLeftChild">
                <p class="StockItemPriceText"><b>
                        <?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?>
                    </b></p>
                <h6> Inclusief BTW </h6>
                <?php
                //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
                if (isset($_GET["id"])) {
                    $stockItemID = $_GET["id"];
                } else {
                    $stockItemID = 0;
                }
                ?>

                <form method="post">
                    <input type="number" name="stockItemID" value="<?php if (isset($_POST["submit"])) {
                        print($_POST["stockItemID"]);
                    } else {
                        print("1");
                    } ?>" min="1" max=<?php echo $voorraad; ?>>
                    <input type="submit" name="submit" value="Voeg toe aan winkelmand">
                    <input type="submit" name="wishlist" value="Voeg toe aan wishlist">
                </form>

                <?php
                if (isset($_POST["submit"])) { // zelfafhandelend formulier
                    $stockItemID = $_GET["id"];
                    $aantal = $_POST["stockItemID"];
                    addProductToCart($stockItemID, $aantal); // maak gebruik van geïmporteerde functie uit cartfuncties.php
                    print("Product toegevoegd aan <a href='winkelmandje.php'> winkelmandje!</a>");
                }
                if (isset($_POST['wishlist'])) {
                  if (isset($_SESSION['klantnummer'])) {
                    $stockItemID = $_GET['id'];
                    $aantal = $_POST['stockItemID'];
                    addToWishlist($_SESSION['klantnummer'], $stockItemID);
                  } else {
                    print("U moet ingelogd zijn");
                  }
                }
                ?>


            </div>
        </div>
    </div>
</div>


<div id="StockItemDescription">
  <h3>Artikel beschrijving</h3>
  <p>
    <?php print $StockItem['SearchDetails'];
    print ("<br><br>");

    $isChillerStock = $StockItem['IsChillerStock'];
    if ($isChillerStock) {
      $temperature = isChillerStock($databaseConnection);
      foreach ($temperature as $temp_key => $temp_value) {
        print("Gekoeld op:" . " " . $temp_value['Temperature']);
      }
    }
    ?>
  </p>
</div>
<div id="StockItemSpecifications">
  <h3>Artikel specificaties</h3>
  <?php
  $CustomFields = json_decode($StockItem['CustomFields'], true);
  if (is_array($CustomFields)) { ?>
    <table>
      <thead>
      <th>Naam</th>
      <th>Data</th>
      </thead>
      <?php
      foreach ($CustomFields as $SpecName => $SpecText) { ?>
        <tr>
          <td>
            <?php print $SpecName; ?>
          </td>
          <td>
            <?php
            if (is_array($SpecText)) {
              foreach ($SpecText as $SubText) {
                print $SubText . " ";
              }
            } else {
              print $SpecText;
            }
            ?>
          </td>
        </tr>
      <?php } ?>
    </table>
    <?php
  } else { ?>

    <p>
      <?php print $StockItem['CustomFields']; ?>.
    </p>
    <?php
  }
  ?>
</div>
<div class="px-2">
  <div class="col-12"
  <h2>
    <?php
    $s = $StockItem['CustomFields'];
    $substringsToRemove = ['\'', '"', ":", "CountryOfManufacture", "{", "}", "Tags", "[", "]", ","];
    $r = str_replace($substringsToRemove, " ", "$s");
    print("Vergelijkbare producten: \n");

    $tags = array_filter(explode(" ", $r, substr_count($r, " ")));


    ?>
  </h2>

  <div class="row">
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <?php


    $ReturnableResult = null;
    $Sort = "SellPrice";
    $SortName = "price_low_high";

    $AmountOfPages = 0;
    $queryBuildResult = "";


    if (isset($_GET['category_id'])) {
      $CategoryID = $_GET['category_id'];
    } else {
      $CategoryID = "";
    }
    if (isset($_GET['products_on_page'])) {
      $ProductsOnPage = 1;
      $_SESSION['products_on_page'] = $_GET['products_on_page'];
    } else if (isset($_SESSION['products_on_page'])) {
      $ProductsOnPage = 1;
    } else {
      $ProductsOnPage = 1;
      $_SESSION['products_on_page'] = 100;
    }
    if (isset($_GET['page_number'])) {
      $PageNumber = $_GET['page_number'];
    } else {
      $PageNumber = 0;
    }


    $SearchString = "";

    if (isset($_GET['search_string'])) {
      $SearchString = $_GET['search_string'];
    }
    if (isset($_GET['sort'])) {
      $SortOnPage = $_GET['sort'];
      $_SESSION["sort"] = $_GET['sort'];
    } else if (isset($_SESSION["sort"])) {
      $SortOnPage = $_SESSION["sort"];
    } else {
      $SortOnPage = "price_low_high";
      $_SESSION["sort"] = "price_low_high";
    }

    switch ($SortOnPage) {
      case "price_high_low":
      {
        $Sort = "SellPrice DESC";
        break;
      }
      case "name_low_high":
      {
        $Sort = "StockItemName";
        break;
      }
      case "name_high_low";
        $Sort = "StockItemName DESC";
        break;
      case "price_low_high":
      {
        $Sort = "SellPrice";
        break;
      }
      default:
      {
        $Sort = "SellPrice";
        $SortName = "price_low_high";
      }
    }
    $searchValues = explode(" ", $SearchString);

    $queryBuildResult = "";
    if ($SearchString != "") {
      for ($i = 0; $i < count($searchValues); $i++) {
        if ($i != 0) {
          $queryBuildResult .= "AND ";
        }
        $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
      }
      if ($queryBuildResult != "") {
        $queryBuildResult .= " OR ";
      }
      if ($SearchString != "" || $SearchString != null) {
        $queryBuildResult .= "SI.StockItemID ='$SearchString'";
      }
    }


    $Offset = $PageNumber * $ProductsOnPage;

    if ($CategoryID != "") {
      if ($queryBuildResult != "") {
        $queryBuildResult .= " AND ";
      }
    }
    function berekenVerkoopPrijs($adviesPrijs, $btw)
    {
      return $btw * $adviesPrijs / 100 + $adviesPrijs;
    }

    foreach ($tags

             as $tagr) {


      $Query = "
                SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, TaxRate, RecommendedRetailPrice, ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
                QuantityOnHand, CustomFields,
                (SELECT ImagePath
                FROM stockitemimages
                WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                FROM stockitems SI
                JOIN stockitemholdings SIH USING(stockitemid)
                WHERE CustomFields LIKE '%$tagr%'
                ORDER BY RAND ()

                LIMIT ?  OFFSET ?";


      $Statement = mysqli_prepare($databaseConnection, $Query);
      mysqli_stmt_bind_param($Statement, "ii", $ProductsOnPage, $Offset);
      mysqli_stmt_execute($Statement);
      $ReturnableResult = mysqli_stmt_get_result($Statement);
      $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

      $Query = "
            SELECT count(*)
            FROM stockitems SI
            ";
      $Statement = mysqli_prepare($databaseConnection, $Query);
      mysqli_stmt_execute($Statement);
      $Result = mysqli_stmt_get_result($Statement);
      $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);


      //


      ?>


      <?php


      if (isset($ReturnableResult) && count($ReturnableResult) > 0) {

        foreach ($ReturnableResult as $row) {

          ?>
          <div class="col-2" style="
                height: 120px;
    margin-top: 10px;
    margin-left: 50px;
    margin-bottom: 10px;
    position: relative;
    padding: 1px;
    border: 1px solid;
border-color: rgb(72,72,72);">
            <a href='view.php?id=<?php print $row['StockItemID']; ?>'>
              <?php
              if (isset($row['ImagePath'])) { ?>
                <div
                  style=" width: 100px;
                    height: 100px;
                    background-color: midnightblue;
                    float: left;
                    margin-left: 10px;
                    margin-top: 10px;
                    margin-right: 10px;
                    background-image: url('<?php print "Public/StockItemIMG/" . $row['ImagePath']; ?>'); background-size: 100px; background-repeat: no-repeat; background-position: center;">
                </div>
              <?php } else if (isset($row['BackupImagePath'])) { ?>
                <div
                  style=" width: 100px;
                    height: 100px;
                    background-color: midnightblue;
                    float: left;
                    margin-left: 0px;
                    margin-top: 0px;
                    margin-right: 0px;
                    background-image: url('<?php print "Public/StockGroupIMG/" . $row['BackupImagePath'] ?>'); background-size: cover;">
                </div>
              <?php }
              ?>

              <p style="
                        font-family: pt-sans, sans-serif;
    color: #fff;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
text-align: center;">
                <?php
                $s = $StockItem['CustomFields'];
                $substringsToRemove = ['\'', '"', ":", "CountryOfManufacture", "{", "}", "Tags", "[", "]", ","];
                print str_replace($substringsToRemove, " ", $row['CustomFields']);
                ?>

              </p>
              <div id="StockItemFrameRight">
                <div class="CenterPriceLeftChild">
                  <h3 style="
                        font-family: pt-sans, sans-serif;
padding-top: 120px;
    color: #9fcdff;
    font-size: 20px;
    text-transform: uppercase;
    font-weight: bold;">
                    <?php print sprintf(" %0.2f", berekenVerkoopPrijs($row["RecommendedRetailPrice"], $row["TaxRate"])); ?>
                  </h3>

                </div>
              </div>

              <h4 style="
                        font-family: pt-sans, sans-serif;
    color: #fff;
    font-size: 10px;
    text-transform: uppercase;
    font-weight: bold;">
                <?php print $row["StockItemName"]; ?>
              </h4>


            </a>
          </div>
          <?php
        }
      } ?>

      <?php

    }


    ?>
  </div>


</div>
</div>
</div>
<?php
print ("</div>");
print ("<div class='px-5 mr-5' id='StockItemComments'>");
?>
<div id="StockItemComments" class="left mx-3 pl-1 row">
  <div class="col-12">
    <H3>Maak een recensie:</H3>
  </div>
  <div class="col-10 pr-5">
    <form method="post" action="view.php?id=<?php print $_GET['id'] ?>">
      <div class="row">
        <div class="col-5 float-left"><input type="text" name="comment"
                                             placeholder="geef hier uw mening over dit product"></div>
        <div class="col-4"><input min="1" max="10" type="number" name="rating"
                                  placeholder="beoordeel het product van 0 tot 10"></div>
        <h1>/10</h1>
      </div>
  </div>
  <div class="col-2 pr-5">
    <input type="submit" name="submitComment">
  </div>
  </form>
</div>
<?php
$comments = getComments($databaseConnection, $_GET['id']);
if (isset($_POST['submitComment'])) {
  $commentData['comment'] = $_POST["comment"];
  $commentData['rating'] = $_POST["rating"];

  if (isset($_SESSION['klantnummer']) and isset($_SESSION['ingelogd'])) {
    $commentData['webCustomerID'] = $_SESSION['klantnummer'];
  } else {
    $commentData['webCustomerID'] = 0;
  }
  $commentData['stockItemID'] = $_GET["id"];
  $commentData = addCommentData($commentData);
  $comments = getComments($databaseConnection, $_GET['id']);
}

if (empty($comments)) {
  print("er zijn op het moment geen recensies");
}
foreach ($comments as $comment) {
  $commentReviewer = getReviewer($databaseConnection, $comment["webCustomerID"], $comment["commentID"]);
  print ("<div class='row'><div id='StockItemComments'>");
  if (!empty($commentReviewer)) {
    print ("<div> <h4>" . $commentReviewer[0]['email'] . "</h4> </div>");
  } else {
    print ("<div> <h4> Anon </h4> </div>");
  }
  print ("<div>Beoordeling: " . $comment["rating"] . "/10</div>");
  print ("<div>Recensie: " . $comment["comment"] . "</div>");
  print ("<div class='float-right pr-5'> <h6>" . $comment["currentTimestamp"] . "</h6></div>");
  print ("</div></div>");
}
?>
</div>


<?php
include __DIR__ . "/footer.php";
?>

</div>
