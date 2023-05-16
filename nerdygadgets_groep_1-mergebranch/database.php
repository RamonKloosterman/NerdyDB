<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

function connectToDatabase()
{
  $Connection = null;

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
  try {
    $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
    mysqli_set_charset($Connection, 'latin1');
    $DatabaseAvailable = true;
  } catch (mysqli_sql_exception $e) {
    $DatabaseAvailable = false;
  }
  if (!$DatabaseAvailable) {
    ?><h2>Website wordt op dit moment onderhouden.</h2><?php
    die();
  }
  return $Connection;
}

function closeConnection($connection)
{
  mysqli_close($connection);
}

function isChillerStock($databaseConnection)
{

  $Query = "
            SELECT Temperature
            FROM coldroomtemperatures
            WHERE ColdRoomSensorNumber = 4";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  $temperature = mysqli_fetch_all($Result, MYSQLI_ASSOC);

  return $temperature;
}

function getComments($databaseConnection, $stockItemID)
{
  $Query = "
            SELECT commentID, comment, rating, webCustomerID, currentTimestamp
            FROM webitemcomments
            WHERE stockItemID = '$stockItemID'";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  $comments = mysqli_fetch_all($Result, MYSQLI_ASSOC);
  return $comments;
}

function getReviewer($databaseConnection, $webCustomerID, $commentID)
{
  $Query = "
            SELECT email
            FROM webcustomer
            JOIN webitemcomments ON webcustomer.webCustomerID=webitemcomments.webCustomerID
            WHERE webitemcomments.webCustomerID = '$webCustomerID'
            AND webitemcomments.commentID = '$commentID'";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  return mysqli_fetch_all($Result, MYSQLI_ASSOC);
}

// comment data toevoegen aan database
function addComments($connection, $comment, $rating, $stockItemID, $webCustomerID)
{
  $statement = mysqli_prepare($connection, "INSERT INTO webitemcomments (comment, rating, stockItemID, webCustomerID) VALUES(?,?,?,?)");
  mysqli_stmt_bind_param($statement, 'siii', $comment, $rating, $stockItemID, $webCustomerID);
  mysqli_stmt_execute($statement);
  return mysqli_stmt_affected_rows($statement) == 1;
}

// comments toevoegen
function addCommentData($commentData)
{
  $connection = connectToDatabase();
  if (addComments($connection, $commentData['comment'], $commentData['rating'], $commentData['stockItemID'], $commentData['webCustomerID'])) {
    //print("De order data is toegevoegd <BR>");
  }
  closeConnection($connection);
  return $commentData;
}

function addToWishlist($webCustomerID, $item_id) {
  $connection = connectToDatabase();
  // Check if the item is already in the wishlist
  $sql = "SELECT * FROM wishlist WHERE webCustomerID = ? AND item_id = ?";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, 'ii', $webCustomerID, $item_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  // If the item is not in the wishlist, insert it
  if (!$row) {
    $sql = "INSERT INTO wishlist (webCustomerID, item_id, added_on) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $webCustomerID, $item_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt) == 1;
  }

  return false;
}

function getWishlistFromDatabase($webCustomerID) {
  $connection = connectToDatabase();
  $sql = "SELECT * FROM wishlist WHERE webCustomerID = ?";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $webCustomerID);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $wishlist = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $wishlist[] = $row;
  }

  return $wishlist;
}

function clearWishlist($webCustomerID) {
  $connection = connectToDatabase();
  $sql = "DELETE FROM wishlist WHERE webCustomerID = ?";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $webCustomerID);
  mysqli_stmt_execute($stmt);
  unset($_SESSION['wishlist']);
  return mysqli_stmt_affected_rows($stmt);
}





//klanten toevoegen
function addCustomers($connection, $gast, $fname, $lname, $email, $password, $address, $address2, $city, $province, $zipcode) {
  //checken of email al gebruikt is
  $mail = $email;
  $check=mysqli_query($connection,"select * from webcustomer where email='$mail'");
  $checkrows=mysqli_num_rows($check);
// als email al wel gebruikt is error anders query uitvoeren
  if($checkrows>0) {
      echo '<script type="text/javascript">
alert("Dit e-mailadres is al in gebruik");
window.location.href = "registreren.php";</script>';

  } else {
      if(isset($_SESSION['popup'])){
          echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
          $_SESSION['popup'] = FALSE;
      }else echo '<script type="text/javascript"> window.location.href = "overzicht.php"</script>';
    $statement = mysqli_prepare($connection, "INSERT INTO webcustomer (gast, fname, lname, email, password, address, address2, city, province, zipcode) VALUES(?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($statement, 'ssssssssss', $gast, $fname, $lname, $email, $password, $address, $address2, $city, $province, $zipcode);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
  }
}

function addCustomerData($gegevens)
{
  $connection = connectToDatabase();
  if (addCustomers($connection, $gegevens["gast"], $gegevens["fname"] , $gegevens["lname"], $gegevens["email"], $gegevens["password"], $gegevens["address"], $gegevens["address2"], $gegevens["city"], $gegevens["province"], $gegevens["zipcode"])) {
    //print("De klant is toegevoegd <BR>");
  }
  closeConnection($connection);
  return $gegevens;
}

// order toevoegen
function addOrders($connection, $webCustomerID)
{
  $statement = mysqli_prepare($connection, "INSERT INTO weborder (webCustomerID) VALUES(?)");
  mysqli_stmt_bind_param($statement, 's', $webCustomerID);
  mysqli_stmt_execute($statement);
  return mysqli_stmt_affected_rows($statement) == 1;
}

function addOrderData($orderData)
{
  $connection = connectToDatabase();
  if (addOrders($connection, $orderData["webCustomerID"])) {
    //print("De order data is toegevoegd <BR>");
  }
  closeConnection($connection);
  return $orderData;
}

//order Line toevoegen
function addOrderLines($connection, $webOrderID, $productID, $aantal)
{
  $statement = mysqli_prepare($connection, "INSERT INTO weborderlines (webOrderID, productID, aantal) VALUES(?,?,?)");
  mysqli_stmt_bind_param($statement, 'sss', $webOrderID, $productID, $aantal);
  mysqli_stmt_execute($statement);
  return mysqli_stmt_affected_rows($statement) == 1;
}

function addOrderLineData($orderLineData)
{
  $connection = connectToDatabase();
  if (addOrderLines($connection, $orderLineData["webOrderID"], $orderLineData["productID"], $orderLineData["aantal"])) {
    //print("De order line is toegevoegd <BR>");
  }
  closeConnection($connection);
  return $orderLineData;
}

//stock aanpassen per order
function updateStock($connection, $aantal, $productID)
{
  $stmt = mysqli_prepare($connection, "UPDATE stockItemHoldings SET QuantityOnHand = QuantityOnHand - ? WHERE StockItemID = ?");
  $stmt->bind_param("ii", $aantal, $productID);
  $stmt->execute();
  $stmt->close();
}

function getCurrentCustomer($databaseConnection)
{
  $klantNummer = $_SESSION["klantnummer"];
  $Query = "
            SELECT webCustomerID
            FROM webcustomer
            WHERE webCustomerID = '$klantNummer'";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  $currentCustomer = mysqli_fetch_all($Result, MYSQLI_ASSOC);
  return $currentCustomer;
}

function getCurrentOrder($databaseConnection)
{
  $currentCustomerID = $_SESSION["currentCustomerID"];
  $Query = "
            SELECT webOrderID
            FROM weborder
            WHERE webCustomerID = '$currentCustomerID'
            ORDER BY webOrderID ASC";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  $currentOrder = mysqli_fetch_all($Result, MYSQLI_ASSOC);
  return $currentOrder;
}

function getHeaderStockGroups($databaseConnection)
{
  $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups
                WHERE StockGroupID IN (
                                        SELECT StockGroupID
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $HeaderStockGroups = mysqli_stmt_get_result($Statement);
  return $HeaderStockGroups;
}

function getStockGroups($databaseConnection)
{
  $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups
            WHERE StockGroupID IN (
                                    SELECT StockGroupID
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_execute($Statement);
  $Result = mysqli_stmt_get_result($Statement);
  $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
  return $StockGroups;
}

function getStockItem($id, $databaseConnection)
{
  $Result = null;

  $Query = "
           SELECT SI.StockItemID, IsChillerStock,
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice,
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, CustomFields,
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
            FROM stockitems SI
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_bind_param($Statement, "i", $id);
  mysqli_stmt_execute($Statement);
  $ReturnableResult = mysqli_stmt_get_result($Statement);
  if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
  }

  return $Result;
}

function getStockItemImage($id, $databaseConnection)
{

  $Query = "
                SELECT ImagePath
                FROM stockitemimages
                WHERE StockItemID = ?";

  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_bind_param($Statement, "i", $id);
  mysqli_stmt_execute($Statement);
  $R = mysqli_stmt_get_result($Statement);
  $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

  return $R;
}

function getCurrentTag($id, $databaseConnection)
{
    $Query = "
            SELECT Tags
            FROM stockitems
            WHERE StockItemID = ?";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $S = mysqli_stmt_get_result($Statement);
    $S = mysqli_fetch_all($S, MYSQLI_ASSOC);
    return $S;
}

function  loginData($mail, $password){
        $_SESSION['inlogEmail'] = $_POST['inlogEmail'];
        $connection = connectToDatabase();
        $check=mysqli_query($connection,"select * from webcustomer where email='$mail'");
        $checkrows=mysqli_num_rows($check);
        $password = sha1($password);
        $databasepassword = mysqli_query($connection,"select password from webcustomer where email = '$mail'");
        for($i=0; $i<$checkrows; $i++){$checkpassword =  mysqli_fetch_array($databasepassword);
            $checkpassword = $checkpassword['password'];
        }
        if($checkrows > 0 AND ($password == $checkpassword)){
            $_SESSION['ingelogd'] = TRUE;
        }
}
function getLoggedinCustomer($tablename, $mail){
    $connection = connectToDatabase();
    $loginQuery = mysqli_query($connection, "select $tablename from webcustomer where email = '$mail'");
    $loginData = mysqli_fetch_array($loginQuery);
    $i = 0;
    while($i < 1){
        $dataLoggedinCustomer = $loginData[$tablename];
        $i++;
    }
    return $dataLoggedinCustomer;
}

function updateGegevens($connection,$klantnummer,$fname,$lname,$email,$password,$address,$address2,$city,$province,$zipcode)
{
    $check=mysqli_query($connection,"select * from webcustomer where email='$email'");
    $checkrows=mysqli_num_rows($check);
    if($checkrows>0 && ($email != $_SESSION['inlogEmail'])) {
        echo '<script type="text/javascript">
alert("Dit e-mailadres is al in gebruik");
window.location.href = "accountoverzicht.php";</script>';

    } else
        $stmt = mysqli_prepare($connection, "UPDATE webcustomer SET fname = ?, lname = ?, email = ?, password =?, address = ?, address2 = ?, city = ?, province = ?, zipcode = ? WHERE webCustomerID = $klantnummer");
    $stmt->bind_param("sssssssss",$fname,$lname,$email,$password,$address,$address2,$city,$province,$zipcode);
    $stmt->execute();
    $stmt->close();
}
