<?php
include "../config.php";
session_start();
?>

<html>
<head>
<title>Login:HEADER</title>
  <meta charset="UTF-8">
  <meta name="keywords" content="autosalone, login, admin">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Pagina di login">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

<H1> CRUD AUTOSALONE</H1>
<?php
 $conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
 if ($conn->connect_error)
     die("Connection failed: " . $conn->connect_error);
 if(isset($_SESSION['pkb'])){
    echo "Benvenuto " . $_SESSION['ema']." !"; 
     //var_dump($_SESSION);
?>
    <br><ul>
    <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_marche.php">marche</a> </li>
    <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_modelli.php">modelli</a> </li>
    <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_automobili.php">automobili</a> </li>
    </ul>
    <form action="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/index.php" method="POST">
    <input type="hidden" id="azione2" name="azione2" value="logout">
    <input type="submit"  value="logout">
    </form>
<?php
}
//var_dump($_SESSION); 
if($_SERVER['REQUEST_METHOD'] == "POST" and $_POST["azione2"] == "logout"){
  echo "L'utente non è autorizzato";
  unset($_SESSION["ema"]);
  session_destroy();
}
  $conn->close();
?>
</body>
</html>
