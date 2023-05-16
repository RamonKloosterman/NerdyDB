<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Account overzicht</title>
</head>
<?php
include "header.php";
if($_SESSION['ingelogd']){
    $_SESSION['fname'] = getLoggedinCustomer('fname', $_SESSION['inlogEmail'] );
    $_SESSION['lname'] = getLoggedinCustomer('lname', $_SESSION['inlogEmail'] );
    $_SESSION['email'] = getLoggedinCustomer('email', $_SESSION['inlogEmail'] );
    $_SESSION['address'] = getLoggedinCustomer('address', $_SESSION['inlogEmail'] );
    $_SESSION['address2'] = getLoggedinCustomer('address2', $_SESSION['inlogEmail'] );
    $_SESSION['city'] = getLoggedinCustomer('city', $_SESSION['inlogEmail'] );
    $_SESSION['province'] = getLoggedinCustomer('province', $_SESSION['inlogEmail'] );
    $_SESSION['zipcode'] = getLoggedinCustomer('zipcode', $_SESSION['inlogEmail'] );
    $_SESSION['klantnummer'] = getLoggedinCustomer('webCustomerID', $_SESSION['inlogEmail']);
}
if (isset($_POST['uitlogButton'])){
    unset($_SESSION['ingelogd']);
    unset($_SESSION['klantnummer']);
    unset($_SESSION['wishlist']);
    echo '<script type="text/javascript"> window.location.replace("index.php")</script>';
}

if(isset($_POST['gegevensOpslaan'])){
    $_SESSION['fname'] = $_POST['wijzigenFname'];
    $_SESSION['lname'] = $_POST['wijzigenLname'];
    $_SESSION['email'] = $_POST['wijzigenEmail'];
    $_SESSION['password'] = sha1($_POST['wijzigenPassword']);
    $_SESSION['address'] = $_POST['wijzigenAddress'];
    $_SESSION['address2'] = $_POST['wijzigenAddress2'];
    $_SESSION['city'] = $_POST['wijzigenCity'];
    $_SESSION['province'] = $_POST['wijzigenProvince'];
    $_SESSION['zipcode'] = $_POST['wijzigenZipcode'];
    updateGegevens($databaseConnection, $_SESSION['klantnummer'],$_SESSION['fname'],$_SESSION['lname'],$_SESSION['email'],$_SESSION['password'],$_SESSION['address'],$_SESSION['address2'],$_SESSION['city'],$_SESSION['province'],$_SESSION['zipcode']);
}
?>

<div class="col-xs-6" style="color: #fff; max-width: 80%; margin: auto; margin-top: 2%; margin-bottom: 2%; width: 80%;">
    <h2 class="sub-header">Account details</h2>
    <div class="table-responsive">
        <form method="post" action="accountoverzicht.php">
        <table class="table table-striped" style="color: #fff; !important">
            <tbody>
            <tr>
                <th scope="row">Voornaam</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenFname" style="background-color: #23232F; color: #fff" value='.$_SESSION["fname"].'></td>');
                }else print('<td>'.$_SESSION["fname"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Achternaam</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenLname" style="background-color: #23232F; color: #fff" value='.$_SESSION["lname"].'></td>');
                }else print('<td>'.$_SESSION["lname"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenEmail" style="background-color: #23232F; color: #fff" value='.$_SESSION["email"].'></td>');
                }else print('<td>'.$_SESSION["email"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Wachtwoord</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenPassword" style="background-color: #23232F; color: #fff" value='.$_SESSION["unhashedpassword"].'></td>');
                }else print('<td>*********</td>');?>
            </tr>
            <tr>
                <th scope="row">Adres</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenAddress" style="background-color: #23232F; color: #fff" value='.$_SESSION["address"].'></td>');
                }else print('<td>'.$_SESSION["address"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Adress toevoeging</th>
            <?php if(!empty($_SESSION['address2']) && (isset($_POST['gegevensWijzigen']))) {print ('<td><input name="wijzigenAddress2" style="background-color: #23232F; color: #fff" value='.$_SESSION["address2"].'></td>');
            }else print('<td>'.$_SESSION["address2"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Woonplaats</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenCity" style="background-color: #23232F; color: #fff" value='.$_SESSION["city"].'></td>');
                }else print('<td>'.$_SESSION["city"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Provincie</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenProvince" style="background-color: #23232F; color: #fff" value='.$_SESSION["province"].'></td>');
                }else print('<td>'.$_SESSION["province"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Postcode</th>
                <?php if (isset($_POST['gegevensWijzigen'])){
                    print ('<td><input name="wijzigenZipcode" style="background-color: #23232F; color: #fff" value='.$_SESSION["zipcode"].'></td>');
                }else print('<td>'.$_SESSION["zipcode"].'</td>');?>
            </tr>
            <tr>
                <th scope="row">Klantnummer</th>
                <td> <?php print $_SESSION['klantnummer'] ?></td>
            </tr>
            <tr>
                <th scope="rowgroup"><?php if (!isset($_POST['gegevensWijzigen'])){ print('<button name="gegevensWijzigen" class="btn btn-primary" style="height: 40px; width: 165px; margin-left: -5px" onclick="window.location.reload()">Wijzig gegevens</button>');}else{
                    print('<button name="gegevensOpslaan" class="btn btn-primary" style="height: 40px; width: 165px; margin-left: -5px" onclick="window.location.reload()">Gegevens opslaan</button>');
                    } ?></th></form>
                <td style="justify-content: right; display: flex"><form method="post"><button class="btn btn-danger" name="uitlogButton" style="height: 40px; width: 165px; margin-right: -10px;">Uitloggen</button></form>
                </td>
            </tr>
            </tbody>
    </div>


