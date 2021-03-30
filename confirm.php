<?php
include "config.php";
session_start();
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-paswd"], $CONFIG["db-name"]);
if ($CN->connect_error)
	die("Connection failed: " . $CN->connect_error);
if(isset($_SESSION['pkf'])){
  $sql = "update as_registrati r set r.is_confirmed=1 where r.pk='".$_SESSION['pkf']."'";
  $CN->query($sql); // esecuzione della query di insert sul DB
  $msg="Conferma avvenuta con successo";
  //echo $msg.'<br>';     
}

else{
    $msg= 'Nessuna sessione';
}
?>
<!DOCTYPE html>
<html>
<title>REGISTRAZIONE : Confirm </title>
<head> 
        <style>
        	body {
            	padding:10px;
            }  
        </style>
</head>
<body>
<h1>Registrazione</h1>
<?php
// connessione al DB
  //echo $_SESSION['email'];
    //echo $sql;
  echo $msg;
  ?>
  <br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/index.php">torna alla home del catalogo</a>
<?php
    $CN->close();
?>
</body>
</html>