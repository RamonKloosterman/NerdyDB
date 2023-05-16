



<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<!-- dit bestand bevat alle code die verbinding maakt met de database -->
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

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>

<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"> <a href='./'>
                <img src='./Public/ProductIMGHighRes/LOGO2.png' alt='NerdyGadgets logo' width='190px' height='190px'
                     margin-left="5px">
            </a> </div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <li>
                    <a href="browse.php?category_id=1"
                       class="HrefDecoration">
                        Novelty Items                        </a>
                </li>
                <li>
                    <a href="browse.php?category_id=2"
                       class="HrefDecoration">
                        Clothing                        </a>
                </li>
                <li>
                    <a href="browse.php?category_id=4"
                       class="HrefDecoration">
                        T-Shirts                        </a>
                </li>
                <li>
                    <a href="browse.php?category_id=6"
                       class="HrefDecoration">
                        Computing Novelties                        </a>
                </li>
                <li>
                    <a href="browse.php?category_id=7"
                       class="HrefDecoration">
                        USB Novelties                        </a>
                </li>
                <li>
                    <a href="browse.php?category_id=9"
                       class="HrefDecoration">
                        Toys                        </a>
                </li>
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
        </ul>




        <!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">
                <script>alert('deze klant bestaat al');</script><div class="row">
                    <div class="col-6">
                        <h2 class="sub-header">Order details</h2>
                        <table class="table table-striped" style="color: #fff; !important">
                            <tbody>
                            <tr>
                                <th >Voornaam</th>
                                <td>Tim.</td>
                            </tr>
                            <tr>
                                <th>Achternaam</th>
                                <td> Zethof</td>
                            </tr>
                            <tr>
                            <tr>
                                <th>Adres</th>
                                <td> Kometenhof</td>
                            </tr>
                            <tr>
                                <th>Adress toevoeging</th>
                                <td> 18</td>
                            </tr>
                            <tr>
                                <th >Achternaam</th>
                                <td> Zethof</td>
                            </tr>
                            <tr>
                                <th >Woonplaats</th>
                                <td> Emmeloord</td>
                            </tr>
                            <tr>
                                <th>Provincie</th>
                                <td> Flevoland</td>
                            </tr>
                            <tr>
                                <th >Postcode</th>
                                <td> 8303 CH</td>
                            </tr>
                            </tbody>

                    </div>

                    <div class="col-7">


                        <table class="table-dark" style="background-color: rgb(35, 35, 47) !important>"

                        <thead>
                        <tr>
                            <th scope="col">Foto   </th>
                            <th scope="col">Product naam</th>
                            <th scope="col">Aantal</th>
                            <th scope="col">Stukprijs</th>
                            <th scope="col">Subtotaal</th>
                        </tr>
                        </thead><tr>    <td>
                                <img id="CartImage" style="max-width: 150px; max-height: 150px;"
                                     src='Public/StockItemIMG/usb.png' </td>
                            <td><a href='view.php?id=1'> USB missile launcher (Green) </a></td><td>1<td> €42,99<td> €42,99</td></tr>

                        <BR>

                        <td style=''>Totaalprijs: <br> €42,99<br>    </div>
                </div>
                </table>
            </div>
        </div>

    </div>

</div>


</html>
</div>
