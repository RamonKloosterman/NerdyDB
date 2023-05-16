<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
include "cartfuncties.php";
$databaseConnection = connectToDatabase();

if (isset($_POST["inlogSubmitpopup"])) {
    loginData($_POST['inlogEmail'], $_POST['inlogPassword']);
  $_SESSION['klantnummer'] = getLoggedinCustomer('webCustomerID', $_POST['inlogEmail']);
  
    if(isset($_SESSION['ingelogd']) && $_SESSION['ingelogd']){
       echo '<script> alert ("U bent ingelogd")</script>';
    }else{
        echo '<script type="text/javascript">
alert("De combinatie van e-mailadres en wachtwoord is niet geldig");
window.location.replace(window.location);</script>';
    }
}

if (isset($_POST['registreerSubmitpopup'])){
    $_SESSION['popup'] = TRUE;
    echo '<script>window.location.href = "registreren.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>
    <script src="Public/JS/popup.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>

<body>
 <div class="popup" id="popup">
    <form method="post" id="headerForm">
        <div class="row">
            <h5 style="margin-left: 15px">Inloggen</h5>
            <a id="manual2" style="position: absolute; right: 6px; cursor: pointer;" onclick="closePopup()"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
        </div>
        <div class="form-group">
            <label for="inputEmail">E-mailadres</label>
            <input required type="text" name="inlogEmail" class="form-control" id="inputEmail" placeholder="E-mailadres" value=<?php if(isset($_SESSION['inlogEmail'])){echo $_SESSION['inlogEmail'];} ?>>
        </div>
        <div class="form-group">
            <label for="inputPassword">Wachtwoord</label>
            <input required type="password" name="inlogPassword" class="form-control" id="inputPassword" placeholder="Wachtwoord">
        </div>

        <div class="form-row">
        <form>
            <button type="submit" name="inlogSubmitpopup" class="btn btn-primary">Inloggen</button>
        </form>
        <form method="post">
            <button name="registreerSubmitpopup" class="btn btn-primary" style="margin-left: 24px">Registreren</button>
        </form>
        </div>
    </form>
 </div>

    <div class="Background">
        <div class="row" id="Header">
            <div class="col-2"> <a href='./'>
                    <img src='./Public/ProductIMGHighRes/LOGO2.png' alt='NerdyGadgets logo' width='190px' height='190px'
                        margin-left="5px">
                </a> </div>
            <div class="col-8" id="CategoriesBar">
                <ul id="ul-class">
                    <?php
                    $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                    foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                            class="HrefDecoration">
                            <?php print $HeaderStockGroup['StockGroupName']; ?>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                    </li>
                </ul>
            </div>
            <!-- code voor US3: zoeken -->

            <ul id="ul-class-navigation">
                <li>
                    <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
                </li>
                <li>
                    <a href="winkelmandje.php" class="HrefDecoration""><i class=" fa fa-shopping-basket search"></i>
                        Winkelmandje</a>
                </li>
                <li>
                    <a href="wishlist.php" class="HrefDecoration""><svg xmlns=" http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" style="color: #676EFF;" class="bi bi-bookmark-star" viewBox="0 0 16 16">
                        <path
                            d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.178.178 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.178.178 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.178.178 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.178.178 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.178.178 0 0 0 .134-.098L7.84 4.1z" />
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                        </svg><i class="bi bi-bookmark-star"></i>
                        Wishlist
                    </a>
                </li>
                    <?php if (isset($_SESSION['ingelogd'])){print('<a id="manual1" href="accountoverzicht.php" class="HrefDecoration" ><i class="fa fa-user-circle search" aria-hidden="true"></i>Account</a>');
                    }else{print('<a id="manual1" class="HrefDecoration"  onclick="openPopup()" style="cursor: pointer"><i class="fa fa-sign-in search" aria-hidden="true"></i> Inloggen</a>');
                    } ?>
                </li>
            </ul>

            </ul>



            <!-- einde code voor US3 zoeken -->
        </div>
        <div class="row" id="Content">
            <div class="col-12">
                <div id="SubContent">

