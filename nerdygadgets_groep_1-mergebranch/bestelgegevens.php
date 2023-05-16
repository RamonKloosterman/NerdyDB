<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>bestelgegevens</title>
</head>
<?php
include 'header.php';

if (isset($_POST["submitGuest"])) {
    $_SESSION['fname'] = $_POST["fname"];
    $_SESSION['lname'] = $_POST["lname"];
    $_SESSION['email'] = $_POST["email"];
    $_SESSION['address'] = $_POST["address"];
    $_SESSION['address2'] = $_POST["address2"];
    $_SESSION['city'] = $_POST["city"];
    $_SESSION['province'] = $_POST["province"];
    $_SESSION['zipcode'] = $_POST["zipcode"];

    $gegevens["gast"] = 1;
    $gegevens["fname"] = isset($_SESSION['fname']) ? $_SESSION['fname'] : "";
    $gegevens["lname"] = isset($_SESSION['lname']) ? $_SESSION['lname'] : "";
    $gegevens["email"] = isset($_SESSION['email']) ? $_SESSION['email'] : "";
    $gegevens["password"] = isset($_SESSION['password']) ? $_SESSION['password'] : "";
    $gegevens["address"] = isset($_SESSION['address']) ? $_SESSION['address'] : "";
    $gegevens["address2"] = isset($_SESSION['address2']) ? $_SESSION['address2'] : "";
    $gegevens["city"] = isset($_SESSION['city']) ? $_SESSION['city'] : "";
    $gegevens["province"] = isset($_SESSION['province']) ? $_SESSION['province'] : "";
    $gegevens["zipcode"] = isset($_SESSION['zipcode']) ? $_SESSION['zipcode'] : "";
    $gegevens = addCustomerData($gegevens);
    exit;
}
?>

<div class="wrapper" style="max-width: 50%; margin: auto; margin-top: 10px;">
    <form method="post" action="bestelgegevens.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Voornaam</label>
                <input required type="text" name="fname" class="form-control" id="inputEmail4" placeholder="Voornaam">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Achternaam</label>
                <input required type="text" name="lname" class="form-control" id="inputPassword4" placeholder="Achternaam">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail">E-mailadres</label>
                <input required type="text" name="email" class="form-control" id="inputEmail" placeholder="E-mailadres" value=<?php if (isset($_SESSION['registreerEmail'])){ echo $_SESSION['registreerEmail'];}?>>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Adres</label>
                <input required type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Toevoeging</label>
                <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="13a">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Stad</label>
                <input required type="text" name="city" class="form-control" id="inputCity" placeholder="Zwolle">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Provincie</label>
                <select required id="inputState" name="province" class="form-control">
                    <option selected>Kies...</option>
                    <option>Drenthe</option>
                    <option>Flevoland</option>
                    <option>Friesland</option>
                    <option>Gelderland</option>
                    <option>Groningen</option>
                    <option>Limburg</option>
                    <option>Noord-Brabant</option>
                    <option>Noord-Holland</option>
                    <option>Overijssel</option>
                    <option>Utrecht</option>
                    <option>Zeeland</option>
                    <option>Zuid-Holland</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Postcode</label>
                <input required type="text" name="zipcode" class="form-control" id="inputZip" placeholder="8239NE">
            </div>
        </div>
        <div class="form-group">

        </div>

        <form>
            <button type="submit" name="submitGuest" class="btn btn-primary" style="">Doorgaan naar overzicht</button>
        </form>
    </form>
</div>

</html>