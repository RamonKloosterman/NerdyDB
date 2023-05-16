<?php
include "header.php";
if (isset($_GET['minusProduct'])) {
  minusProductFromCart($_GET['id']);
}
if (isset($_GET['plusProduct'])) {
  addProductToCart($_GET['id'],1);
}

if (isset($_GET['emptyCart'])) {
  emptyCart();
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <title>Winkelwagen</title>
</head>

<body>
  <table border="2">


    <?php
    if (isset($_GET['emptyProduct'])) {
        emptyProduct( );
    }
    $cart = getCart();

    if (isset($_SESSION['cart'])) {
      print('<table class="table-dark" style="background-color: rgb(35, 35, 47) !important>"');
      print('
  
    <thead>
      <tr>
        <th scope="col" >Foto</th>
        <th scope="col">Product naam</th>
        <th scope="col">Aantal</th>
         <th scope="col">Stukprijs</th>
        <th scope="col">Subtotaal</th>
        <th></th>
      </tr>
    </thead>');

    } else {
      print("<h1>Winkelmandje is leeg</h1>");
    }
    $totaal = 0;


    foreach ($cart as $productID => $aantal) {

      if (isset($_SESSION['cart'])) {

        if ($cart[$productID] > 0) {
          $StockItem = getStockItem($productID, $databaseConnection);
          $StockItemImage = getStockItemImage($productID, $databaseConnection);

          print("<tr>");
          //product foto
          if (isset($StockItemImage)) {
            if (isset($StockItemImage)) {
            }
    ?>
    <td>
      <img id="CartImage" style="max-width: 150px; max-height: 150px;"
        src='Public/StockItemIMG/<?php if(isset($StockItemImage[0]['ImagePath'])) print $StockItemImage[0]['ImagePath']; ?>' </td>
      <?php
            } else {
      ?>
    <td>
      <img id="CartImage" style="max-width: 150px; max-height: 150px;"
        src='Public/StockGroupIMG/<?php print $StockItem['ImagePath']; ?>' </td>
      <?php
            }
            //productnaam
            if (isset($StockItem['StockItemName'])) {
              print("<td><a href='view.php?id=$productID'> " . $StockItem['StockItemName'] . " </a></td>");
            }


          }
          //Aantal

          if (isset($StockItem['StockItemName'])) {
            print("<td > $aantal  <a href='winkelmandje.php?minusProduct=true&id=$productID'>-</a>");
            print("     <a href='winkelmandje.php?plusProduct=true&id=$productID'>+</a>");
          }
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
            if (isset($_SESSION['cart'])) {
                print("<td > <a href='winkelmandje.php?emptyProduct=$productID'><div class='far fa-times-circle' style='background: none; border: none; color: red;'></div></a>");
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
        if (isset($_SESSION['cart'])) {
          print("<td style='width: auto'>Totaalprijs: <br> €" . number_format($totaal, 2, ',','.')."</td>" . "<br>");
        }
      }

      if (isset($_SESSION['cart'])) {
        print('<td><form action="winkelmandje.php?emptyCart=true" method="get">
      <button type="submit" class="btn btn-danger" style="height: 40px; width: 165px" name="emptyCart" onclick="window.location.reload();">Leeg winkelmandje</button>
    </form></td>');
      }
      if (isset($StockItem['StockItemName'])) {
        if (isset($_SESSION['cart'])) {
          $_SESSION["totaal"] = $totaal;
         if (isset($_SESSION['ingelogd'])) {
             print('<td> <form action="overzicht.php" method="get">
      <button type="submit" class="btn btn-success" style="height: 40px; width: 165px" name="cartOrder" onclick="window.location.reload();">Afrekenen</button>
    </form></td>');
         }else{
             print('<td> <form action="inloggen.php" method="get">
      <button type="submit" class="btn btn-success" style="height: 40px; width: 165px" name="cartOrder" onclick="window.location.reload();">Afrekenen</button>
    </form></td>');
         }
        }
      }

      ?>
</body>

</html>