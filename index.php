<?php
/* modificato da Di Nisio il 17/03/2021 */
session_start();
//var_dump($_SESSION);
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
               <style>
        	body {
            	padding:10px;
                background-color: #ffd9b3;  
                }
            fieldset
            {
                background-color: purple;
                color: aliceblue;
            }
            legend{
                background-color: crimson;
                color: black;
            }
        </style>
</head>
<body>
<h1>Login:</h1>
<form method='POST' action=''>
<fieldset>
<legend><b>Inserimento dati:</b></legend>
<input type="hidden" id="azione" name="azione" value="login">
<strong>Email:</strong> <input type="email" id='ema' name="ema"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd"><br>
<input type="submit" value="accedi">
</fieldset>
</form>
<?php
include "../config.php";
  $CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
  if ($CN->connect_error)
    die("Connection failed: " . $CN->connect_error);
   $email=$_POST['ema'];
	 $_SESSION['ema']=$email;	
  if ($_POST["azione"] == "login") {
    $sql="SELECT l.pk as 'pkb',l.nome as 'Nome',l.is_enabled as 'Abilitato' FROM as_utenti l WHERE l.password = '".md5($_POST['pswd'])."' and l.email='".$_POST['ema']."'";
    $RS = $CN->query($sql); 
    $row = $RS->fetch_assoc();
    if($RS->num_rows==1 and $row['Abilitato']==1){
        $_SESSION['pkb'] = $row['pkb'];
        $_SESSION['Abilitato'] = $row['Abilitato'];
        header("location: http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/header.php");
    }
    else{
      $msg ="L'utente non è abilitato!";
      echo $msg.'<br>';
    }
  }
  $CN->close();
?>
</body>
</html> 
