<?php

include "header.php";
include "wishlistfuncties.php";
if (isset($_GET['minusProduct'])) {
  minusProductFromCart($_GET['id']);
}
if (isset($_GET['plusProduct'])) {
  addProductToCart($_GET['id'], 1);
}

if (isset($_GET['emptywishlist'])) {
  clearWishlist($_SESSION['klantnummer']);
}
if (isset($_GET['wishlistOrder'])) {
  $wishlist = getwishlist();
  foreach ($wishlist as $productID => $aantal) {
    addProductToCart($productID, $aantal);
  }
  print("<a href='winkelmandje.php'>Producten toegevoegd aan winkelmandje.</a>");
  unset($_SESSION['wishlist']);
}
if (isset($_GET['emptyProduct'])) {
  if (isset($_SESSION['wishlist'])) {
    emptyWishlistProduct();
  }
}

if (isset($_SESSION['klantnummer'])) {
  $wishlistfromdatabase = getWishlistFromDatabase($_SESSION['klantnummer']);
  foreach ($wishlistfromdatabase as $productID => $product) {
    addProductTowishlist($product['item_id'], 1);
  }
}
$totaal = 0;
print('<table class="table-dark" style="background-color: rgb(35, 35, 47) !important>"');

if (isset($_SESSION['wishlist'])) {

  print('

<thead>
<tr>
  <th scope="col" >Foto</th>
  <th scope="col">Product naam</th>
   <th scope="col">Stukprijs</th>
  <th scope="col">Subtotaal</th>
  <th></th>
</tr>
</thead>');
}
$wishlist = getwishlist();
foreach ($wishlist as $productID => $aantal) {

    if ($wishlist[$productID] > 0) {
      $StockItem = getStockItem($productID, $databaseConnection);
      $StockItemImage = getStockItemImage($productID, $databaseConnection);

      print("<tr>");
      //product foto
      if (isset($StockItemImage)) {
        if (isset($StockItemImage)) {
        
?>
<td>
  <img id="wishlistImage" style="max-width: 150px; max-height: 150px;" src='Public/StockItemIMG/<?php if (isset($StockItemImage[0]['ImagePath']))
          print $StockItemImage[0]['ImagePath']; ?>' </td>
  <?php
      } else {
  ?>
<td>
  <img id="wishlistImage" style="max-width: 150px; max-height: 150px;"
    src='Public/StockGroupIMG/<?php print $StockItem['ImagePath']; ?>' </td>
  <?php
      }
      //productnaam
      if (isset($StockItem['StockItemName'])) {
        print("<td><a href='view.php?id=$productID'> " . $StockItem['StockItemName'] . " </a></td>");
      }


    }
    //Aantal
    //product stukprijs

    if (isset($StockItem['StockItemName'])) {
      if (isset($StockItem['SellPrice'])) {
        print("<td> €" . number_format($StockItem['SellPrice'], 2, ',', '' . "</td>"));
      }
    }

    //product subtotaal
    if (isset($StockItem['StockItemName'])) {
      if (isset($StockItem['SellPrice'])) {
        $subTotaal = $aantal * $StockItem['SellPrice'];
        print("<td> €" . number_format($subTotaal, 2, ',', '.') . "</td>");
      }
    }
    if (isset($_SESSION['wishlist'])) {
      print("<td > <a href='wishlist.php?emptyProduct=$productID'><div class='far fa-times-circle' style='background: none; border: none; color: red;'></div></a>");
      print("</tr>");
      //totaal prijs
      if (isset($StockItem['StockItemName'])) {
        if (isset($StockItem['SellPrice'])) {
          $totaal += $aantal * $StockItem['SellPrice'];
        }
      }




    }
  }
}


  ?>
  <BR>

  <?php
  if (isset($StockItem['SellPrice'])) {
    if (isset($_SESSION['wishlist'])) {
      print("<td style='width: auto'>Totaalprijs: <br> €" . number_format($totaal, 2, ',', '.') . "</td>" . "<br>");
    }
  }

  if (isset($_SESSION['wishlist'])) {
    print('<td><form action="wishlist.php?emptywishlist=true" method="get">
  <button type="submit" class="btn btn-danger" style="height: 40px; width: 165px" name="emptywishlist" onclick="window.location.reload();">Verwijder Wishlist</button>
</form></td>');
  }
  if (isset($StockItem['StockItemName'])) {
    if (isset($_SESSION['wishlist'])) {
      $_SESSION["totaal"] = $totaal;
      print('<td> <form action="wishlist.php?wishlistOrder" method="get">
  <button type="submit" class="btn btn-success" style="height: 40px; width: 300px" name="wishlistOrder" onclick="window.location.reload();">Voeg toe aan winkelmand</button>
</form></td>');
    }
  }

  ?>