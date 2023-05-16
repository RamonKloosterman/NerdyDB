<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <title>Afrekenen</title>
</head>

<?php
include "header.php";

//checken of email en wachtwoord overeenkomen in de database
if (isset($_POST["inlogSubmit"])) {
  loginData($_POST['inlogEmail'], $_POST['inlogPassword']);
  $_SESSION['unhashedpassword'] = $_POST['inlogPassword'];
  $_SESSION['klantnummer'] = getLoggedinCustomer('webCustomerID', $_POST['inlogEmail']);

  if ($_SESSION['ingelogd']) {
    echo '<script type="text/javascript"> window.location = "overzicht.php" </script>';
  } else {
    echo '<script type="text/javascript">
alert("De combinatie van e-mailadres en wachtwoord is niet geldig");
window.location.href = "inloggen.php";</script>';
  }
}

//Email meesturen naar het registreer format
if (isset($_POST["registreerSubmit"])) {
  $_SESSION['registreerEmail'] = $_POST["registreerEmail"];
  echo '<script type="text/javascript"> window.location = "registreren.php" </script>';
}

if(isset($_POST['gast'])){
    $_SESSION['gast'] = TRUE;
    echo '<script type="text/javascript"> window.location = "bestelgegevens.php" </script>';
}
?>

<div class="wrapper" style="max-width: 25%; margin-left: 250px; margin-right: auto; margin-top: 10px;">
  <form method="post" action="inloggen.php">
    <h5>Inloggen</h5>
    <div class="form-group">
      <label for="inputEmail">E-mailadres</label>
      <input required type="text" name="inlogEmail" class="form-control" id="inputEmail" placeholder="E-mailadres"
             value=<?php if (isset($_SESSION['inlogEmail'])) {
        echo $_SESSION['inlogEmail'];
      } ?>>
    </div>
    <div class="form-group">
      <label for="inputPassword">Wachtwoord</label>
      <input required type="password" name="inlogPassword" class="form-control" id="inputPassword"
             placeholder="Wachtwoord">
    </div>

    <form action="overzicht.php">
      <button type="submit" name="inlogSubmit" class="btn btn-primary">Inloggen</button>
    </form>


  </form>
</div>
<div class="wrapper" style="max-width: 25%; margin-left: auto; margin-right: 250px; margin-top: -241.9px">
  <form method="post" action="inloggen.php">
    <h5>Nog geen account?</h5>
    <div class="form-group">
      <label for="inputEmail">E-mailadres</label>
      <input type="text" name="registreerEmail" class="form-control" id="inputEmail" placeholder="E-mailadres">
    </div>

    <form action="registreren.php">
      <button type="submit" name="registreerSubmit" class="btn btn-primary">Nieuw account aanmaken</button>
    </form>
  </form>
</div>

<form method="post" class="wrapper" style="text-align: center; margin-top: 150px">
  <h5>Geen account aanmaken?</h5>
  <button type="submit" name="gast" class="btn btn-primary">Doorgaan als gast</button>
</form>
</html>
