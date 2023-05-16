<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Overzicht</title>
</head>
<?php
include "header.php";
if(isset($_SESSION['ingelogd'])){
    $_SESSION['fname'] = getLoggedinCustomer('fname', $_SESSION['inlogEmail'] );
    $_SESSION['lname'] = getLoggedinCustomer('lname', $_SESSION['inlogEmail'] );
    $_SESSION['email'] = getLoggedinCustomer('email', $_SESSION['inlogEmail'] );
    $_SESSION['address'] = getLoggedinCustomer('address', $_SESSION['inlogEmail'] );
    $_SESSION['address2'] = getLoggedinCustomer('address2', $_SESSION['inlogEmail'] );
    $_SESSION['city'] = getLoggedinCustomer('city', $_SESSION['inlogEmail'] );
    $_SESSION['province'] = getLoggedinCustomer('province', $_SESSION['inlogEmail'] );
    $_SESSION['zipcode'] = getLoggedinCustomer('zipcode', $_SESSION['inlogEmail'] );
}

if (isset($_POST['submitorder'])) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productID => $aantal) {

            // zojuist ingevulde customer ID ophalen
            $getCurrentCustomer = getCurrentCustomer($databaseConnection);
            foreach ($getCurrentCustomer as $value) {
                $_SESSION["currentCustomerID"] = $value["webCustomerID"];
            }
        }
        $orderData["webCustomerID"] = $_SESSION["currentCustomerID"];
        $orderData = addOrderData($orderData);

        foreach ($_SESSION['cart'] as $productID => $aantal) {

            // zojuist ingevulde order ID ophalen
            $getCurrentOrder = getCurrentOrder($databaseConnection);
            foreach ($getCurrentOrder as $value) {
                $_SESSION["currentOrderID"] = $value["webOrderID"];
            }
        }
    }

    if (isset($_SESSION['cart'])) {
        $cart= $_SESSION['cart'];
        foreach ($_SESSION['cart'] as $productID => $aantal) {
            //print_r($_SESSION);
            if ($aantal <= 0){
                print ("voor unset");
                print_r($cart);
                print ("<BR> aantal is 0 of kleiner <BR>");
                unset($cart[$productID]);
                print ("voor unset");
                print_r($cart);
            }else {
                $orderLineData["webOrderID"] = $_SESSION["currentOrderID"];
                $orderLineData["productID"] = $productID;
                $orderLineData["aantal"] = $aantal;
                $orderLineData = addOrderLineData($orderLineData);
                updateStock($databaseConnection, $aantal, $productID);
            }

        }
    }

}

?>

<div class="col-xs-6" style="color: #fff; max-width: 80%; margin: auto; margin-top: 2%; margin-bottom: 2%; width: 80%;">
    <h2 class="sub-header">Order details</h2>
    <div class="table-responsive">
        <table class="table table-striped" style="color: #fff; !important">
            <tbody>
            <tr>
                <th scope="row">Voornaam</th>
                <td><?php print $_SESSION['fname'] ?></td>
            </tr>
            <tr>
                <th scope="row">Achternaam</th>
                <td> <?php print $_SESSION['lname'] ?></td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td> <?php print $_SESSION['email'] ?></td>
            </tr>
            <tr>
                <th scope="row">Adres</th>
                <td> <?php print $_SESSION['address'] ?></td>
            </tr>
            <?php if(!empty($_SESSION['address2'])) {print(' <tr><th scope="row">Adress toevoeging</th><td>' . $_SESSION['address2'] . '</td></tr>');}?>
            <tr>
                <th scope="row">Woonplaats</th>
                <td> <?php print $_SESSION['city'] ?></td>
            </tr>
            <tr>
                <th scope="row">Provincie</th>
                <td> <?php print $_SESSION['province'] ?></td>
            </tr>
            <tr>
                <th scope="row">Postcode</th>
                <td> <?php print $_SESSION['zipcode'] ?></td>
            </tr>
            </tbody>
    </div>

    <?php
    if (isset($_GET['minusProduct'])) {
        minusProductFromCart($_GET['id']);
    }
    if (isset($_GET['plusProduct'])) {
        addProductToCart($_GET['id'], 1);
    }

    if (isset($_GET['emptyCart'])) {
        emptyCart();
    }
    ?>
    <table border="2">

        <?php
        $cart = getCart();

        if (isset($_SESSION['cart'])) {

        } else {
            print("<h1>Winkelmandje is leeg</h1>");
        }
        $totaal = 0;
        print('<table class="table-dark" style="background-color: rgb(35, 35, 47) !important>; width: 100%"');

        print('

  <thead>
    <tr>
      <th scope="col">Foto   </th>
      <th scope="col">Product naam</th>
      <th scope="col">Aantal</th>
       <th scope="col">Stukprijs</th>
      <th scope="col">Subtotaal</th>
    </tr>
  </thead>
  <form action="overzicht.php" method="post">
  <button name="submitorder" class="btn btn-success""> plaats bestelling</button>
</form>
  ');

        foreach ($cart as $productID => $aantal) {
            if (isset($_SESSION['cart'])) {

                if ($cart[$productID] > 0) {
                    $StockItem = getStockItem($productID, $databaseConnection);
                    $StockItemImage = getStockItemImage($productID, $databaseConnection);

                    print("<tr>");
                    //product foto
                    if (isset($StockItemImage)) {
                        if (isset($StockItemImage)) {

                            ?>
                            <td>
                                <img id="CartImage" style="max-width: 150px; max-height: 150px;"
                                     src='Public/StockItemIMG/<?php if(isset($StockItemImage[0]['ImagePath'])) print $StockItemImage[0]['ImagePath']; ?>' </td>
                            <?php
                        } else {
                            ?>
                            <td>
                                <img id="CartImage" style="max-width: 150px; max-height: 150px;"
                                     src='Public/StockGroupIMG/<?php if(isset($StockItemImage[0]['ImagePath'])) print $StockItem['ImagePath']; ?>' </td>
                            <?php
                        }
                        //productnaam
                        if (isset($StockItem['StockItemName'])) {
                            print("<td><a href='view.php?id=$productID'> " . $StockItem['StockItemName'] . " </a></td>");
                        }


                    }
                    //Aantal

                    if (isset($StockItem['StockItemName'])) {
                        print("<td>$aantal");
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
                print("<td style=''>Totaalprijs: <br> €" . number_format($totaal, 2, ',', '.') ."</td>". "<br>");
            }
        }
        if (!isset($StockItem['StockItemName'])) {
            print("<td>Uw winkelmandje is leeg!</td>");

        }
        if (isset($StockItem['StockItemName'])) {
            if (isset($_SESSION['cart'])) {
                $_SESSION["totaal"] = $totaal;
                print('<td> <form action="registreren.php" method="get">
    </form></td>');
            }
        }


        ?>
</div>
<?php
