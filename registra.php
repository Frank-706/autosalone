<?php
// https://www.mrw.it/php/funzione-mail_6466.html#:~:text=Inviare%20e-mail%20con%20PHP,inviare%20email%20con%20codifica%20MIME.
session_start();
?>
<!DOCTYPE html>
<html>
<title>REGISTRAZIONE : Utenti </title>
<head>
        
        <style>
        	body {
            	padding:10px;
            }
            
        </style>
</head>
<body onload="document.getElementById('nome').focus();">
<h1>Registrazione</h1>
<?php
include "config.php";

// connessione al DB
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-paswd"], $CONFIG["db-name"]);
if ($CN->connect_error)
	die("Connection failed: " . $CN->connect_error);

if ($_POST["azione"] == "insert") {
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
	  $nome=$_POST['nome'];
    $cognome=$_POST['cognome'];
    $email=$_POST['email'];
    $pwd=$_POST['pwd'];
    $data=$_POST['dt'];
	// verifica se l'email è vuota
	$sql = "SELECT COUNT(*) AS registrato,email as 'Email' FROM as_registrati WHERE email='$email'";
	$RS = $CN->query($sql); 	// esecuzione della query di insert sul DB
	$row = $RS-> fetch_assoc();	// da $RS estraggo una riga
  $_SESSION['email']=$email;
  var_dump($_SESSION);
    if ($row["registrato"]>=1) {			// testo il campo "registrato" della riga
    	$msg = "Questa email: '$email' già esiste! ";
    }
    else if ($email == "") {
    	$msg = "Email non specificata, inserire email...";
    }
    else {
      $sql = "INSERT INTO as_registrati(pk,
                         nome,
                        cognome,
                        email,
                        pass,
                        data_nsct,
                        is_confirmed
                      ) VALUES (
                          null,
                          '$nome',
                          '$cognome',
                          '$email',
                          md5('$pwd'),
                          '$data',
                          0
                      )";
//echo $sql;
      $CN->multi_query($sql); // esecuzione della query di insert sul DB
      $msg = "inserimento dell'utente '$nome' avvenuto con successo";
      // definisco mittente e destinatario della mail
$nome_mittente = "Francesco Fulvio Di Nisio";
$mail_mittente = "francescofulvio.dinisio@italessandrini.edu.it";
$mail_destinatario = $email;

// definisco il subject ed il body della mail
$mail_oggetto = "Conferma registrazione";
$mail_corpo = "Per attivare l'account clicca sul link: http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/confirm.php";

// aggiusto un po' le intestazioni della mail
// E' in questa sezione che deve essere definito il mittente (From)
// ed altri eventuali valori come Cc, Bcc, ReplyTo e X-Mailer
$mail_headers = "From: " .  $nome_mittente . " <" .  $mail_mittente . ">\r\n";
$mail_headers .= "Reply-To: " .  $mail_mittente . "\r\n";
$mail_headers .= "X-Mailer: PHP/" . phpversion();

mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers);
      //mail($email,'Conferma registrazione','Per attivare l\'account clicca sul link: http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/confirm.php');
    }
}
?>
  <form method="POST" action="">
    <input type='hidden' 	name='azione' id='azione' value='insert'>
     <fieldset>
    <legend>Registrazione:</legend>
    Nome: <input type='text' name='nome' id='nome' placeholder='inserire il nome...'> <br>
    Cognome: <input type='text' name='cognome' id='cognome' placeholder='inserire il cognome...'> <br>
    Email: <input type='email' name='email' id='email' placeholder='inserire una email...'> <br>
    Password: <input type="password" id="pwd" name="pwd" placeholder='inserire una password...'><br>
    Data di nascita: <input type="date" id="dt" name="dt"><br>
    <input type='submit' value='Registrati'><br>
    <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/index.php">torna alla home del catalogo</a>
    <br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/confirm.php">confirm page</a>
    </fieldset>
  </form>
<?php
echo $msg;
$CN->close();
?>
</body>
</html>
