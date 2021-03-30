<!DOCTYPE html>
<html>
<title>INSERT: Modelli</title>
<head>

        <style>
        	body {
            	padding:10px;
            }
        </style>
</head>
<body >
<h1>INSERT: Modelli</h1>
<?php
include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
if ($_POST["azione1"] == "insert") {
        $nome 	= $_POST["nome"];
        $marche	= $_POST["marche"];
        $anno= $_POST["anno"];
        $porte=$_POST["porte"];
        $posti=$_POST["posti"];
        
        // verifica se il modello è presente
        $sql = "SELECT COUNT(*) AS n FROM modelli m WHERE nome='$nome'";
        $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
        $row = $RS->fetch_assoc();	// da $RS estraggo una riga
        if ($row["n"]>=1) {			// testo il campo "n" della riga
            $msg = "il modello'$nome' è già esistente, impossibile inserire";
        }
        else if ($nome == "") {
            $msg = "il modello non è specificato, impossibile inserire";
        }
        else {
          $sql = "INSERT INTO modelli (
                              pk,
                              nome,
                              anno,
                              n_posti,
                              n_porte,
                              fk_marche
                          ) VALUES (
                              null,
                              '$nome',
                              '$anno',
                              $posti,
                              $porte,
                              $marche
                          )";
    //echo $sql;
          $conn->query($sql); // esecuzione della query di insert sul DB
          $msg = "inserimento del modello  '$nome'  avvenuto con successo";
        }
    }
          echo "marca: <select id='marche' name='marche'>\n"; 
          $sql = "SELECT * from marche ma";
          $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
          while ($row = $RS->fetch_assoc())
              echo "<option value='".$row["pk"]."'>" . $row["nome"] . "</option>\n"; 
          echo "</select>\n";  
          echo $msg;
   $conn->close();
        ?>
   
   
 
<form action="" method="POST" id="cancellatore" name="cancellatore">
modello:<input type='text' name='nome' id='nome' placeholder='nome'><br>
      data:  <input type='date' name='anno' id='anno' placeholder='anno'> <br>
        <input type='number'  min=1	max=9	name='posti' id='posti'> posti<br>
         <input type='number' min=2	max=6	name='porte' id='porte'> porte<br>
        <input type='submit' value='inserisci'>
        <input type='hidden' name='azione' id='azione' value='insert'>
	<input type="hidden" name="azione1" id="azione1" value="delete">
	<input type="hidden" name="chi" id="chi" value="">
</form>
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_modelli.php">Torna alle crud Modelli</a>
</body>
</html>
