<!DOCTYPE html>
<html>
<title>DELETE : Automobili</title>
<head>

        <style>
        	body {
            	padding:10px;
            }
        	.comando {
            	width:32px;
            	height:32px;
            }
        </style>
        <script>
        	function elimina(pk, nome) {
            	if (confirm("sei sicuro di voler eliminare il modello " + nome + "?")) {
	            	document.getElementById('chi').value = pk;
    	        	document.forms["cancellatore"].submit();
                }
                return;
            }
        </script>
</head>
<body >
<h1> DELETE: Automobili</h1>
<?php
include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if ($_POST["azione"] == "delete") {
//die("disabled");
	$sql = "DELETE FROM as_automobili WHERE pk = " . $_POST["chi"];
	$conn->query($sql);
}

$sql = "
		SELECT  
                a.pk as Id,
                a.targa as Targhe,
                mo.nome as Modello
		FROM 	as_automobili a
        join as_modelli mo on a.fk_as_modelli=mo.pk
       order by mo.nome
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Targhe</th>";
    echo "<th>Modello</th>";
    echo "<th>Comandi</th>";
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>\n";
		echo "<td >".$row["Targhe"]."</td>\n";
		echo "<td >".$row["Modello"]."</td>\n";
        
        // le seguenti 5 righe sono indentante per scopi PURAMENTE DIDATTICI, per mostrare il nesting dei tag
		echo "<td>\n";
        	echo "<a href=\"javascript:elimina('".$row["Id"]."','".$row["Targhe"]."')\">\n";	// occhio a ' e " -> inoltre \" è l'escaping di " 
        		echo "<img class='comando' src='http://frankmoses.altervista.org/INFORMATICA/monnezza.jpg'>\n";
        	echo "</a>\n";
        echo "</td>\n";
        
		echo "</tr>";
    }
	echo "</table><br>";
} else {
    echo "0 results";
}
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
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/index.php">home</a>
</body>
</html>
