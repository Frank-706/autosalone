<!DOCTYPE html>
<html>
<title>INSERT: Automobili</title>
<head>

        <style>
        	body {
            	padding:10px;
            }
        </style>
        <script>
        	window.onload=document.getElementById("nome").focus();
        </script>
</head>
<body >
<h1>INSERT: Automobili</h1>
<?php
include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
/*$conn->close();
include "../config.php";
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($CN->connect_error)
    die("Connection failed: " . $CN->connect_error);*/
if ($_POST["azione1"] == "insert") {
        $nome 	= $_POST["nome"];
        $modelli	= $_POST["modelli"];
        
        // verifica se il modello è presente
        $sql = "SELECT COUNT(*) AS n FROM automobili m WHERE m.targa='$nome'";
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
                              targa,
                              fk_as_modelli
                          ) VALUES (
                              null,
                              '$nome',
                              $modelli
                          )";
    //echo $sql;
          $conn->query($sql); // esecuzione della query di insert sul DB
          $msg = "inserimento della targa  '$nome'  avvenuto con successo";
        }
    }
          echo "modelli: <select id='modelli' name='modelli' >\n"; 
          echo " <option value='' label='Seleziona un modello' selected disabled/>"; 
          $sql = "SELECT * from modelli mo";
          $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
          while ($row = $RS->fetch_assoc())
              echo "<option value='".$row["pk"]."'>" . $row["nome"] . "</option>\n"; 
          echo "</select>\n";  
          echo $msg;
   $conn->close();
        ?>
<form action="" method="POST" id="cancellatore" name="cancellatore">
Targa:<input type='text' name='nome' id='nome' placeholder='nome'><br>
        <input type='submit' value='inserisci'>
        <input type='hidden' name='azione' id='azione' value='insert'>
	<input type="hidden" name="azione1" id="azione1" value="delete">
	<input type="hidden" name="chi" id="chi" value="">
</form>
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_automobili.php">Torna alle crud delle Automobili</a>
</body>
</html>
