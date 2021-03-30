<?php
/* modificato da Di Nisio il 17/03/2021 */
session_start();
include "../config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Login: ADMIN</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="autosalone, login, admin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Pagina di login">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script type="text/javascript">
            window.onload = function(){
            document.getElementById("ema").focus();
				}
        </script>
</head>
<body>
<h1>Login:</h1>
<form method='post' action=''>
<fieldset>
<legend>Inserimento dati:</legend>
<input type="hidden" id="azione" name="azione" value="login">
<strong>Email:</strong> <input type="email" id='ema' name="ema"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd"><br>
<input type="submit" value="accedi">
</fieldset>
</form>
<?php
  $CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
  if ($CN->connect_error)
    die("Connection failed: " . $CN->connect_error);
    //  sql INJECTION ';1 'OR' 1 '=' 1;'
    // ';delete from u_login;select'
 	
   // $RS = $CN->multi_query($sql);
   
  if ($_POST["azione"] == "login") {		
    $sql="SELECT l.pk as 'pkb',l.nome as 'Nome' FROM as_utenti l WHERE l.password = '".md5($_POST['pswd'])."' and l.email='".$_POST['ema']."'";
    // echo $sql.'<br>';
    $RS = $CN->query($sql); 
    if($RS->num_rows==1){
      $row = $RS->fetch_assoc();
      $_SESSION['pkb']=$row['pkb'];
      $msg = "Benvenuto " . $row['Nome']." !";
      echo $msg.'<br>';
    }
    else{
      $msg ="Accesso negato!";
      echo $msg.'<br>';
      //echo "<meta http-equiv='Refresh' content='3; URL=http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/index.php>";
    }
   ?>
   <?php
    if(isset($_SESSION["pkb"])){
      ?>
      <br><ul>
      <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_marche.php">marche</a> </li>
      <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_modelli.php">modelli</a> </li>
      <li> <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_automobili.php">automobili</a> </li>
      </ul>
      <form action="" method="post">
      <input type="submit" id="azione2" name="azione2" value="logout">
      </form>
      <?php
    }
  }
  if($_POST["azione2"] == "logout"){
    echo "Logout effettuato";
    unset($_SESSION["pkb"]);
    session_destroy();
}
  $CN->close();

?>
</body>
</html> 
