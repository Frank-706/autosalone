<!DOCTYPE html>
<html>
<title>INSERT e DELETE : Modelli</title>
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
<h1>INSERT e DELETE: Modelli</h1>
<?php
include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if ($_POST["azione"] == "delete") {
//die("disabled");
	$sql = "DELETE FROM as_modelli WHERE pk = " . $_POST["chi"];
	$conn->query($sql);
}

$sql = "
		SELECT  
                mo.pk as Id,
                ma.nome as Marche,
                mo.nome as Modello,
                mo.anno as Anno,
                mo.n_posti as Posti,
                mo.n_porte as Porte
		FROM 	as_modelli mo
        join as_marche ma on mo.fk_as_marche=ma.pk
       order by mo.nome
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Marche</th>";
    echo "<th>Modello</th>";
    echo "<th>Anno</th>";
    echo "<th>Posti</th>";
    echo "<th>Porte</th>";
    echo "<th>Comandi</th>";
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>\n";
		echo "<td >".$row["Marche"]."</td>\n";
		echo "<td >".$row["Modello"]."</td>\n";
		echo "<td >".$row["Anno"]."</td>\n";
		echo "<td >".$row["Posti"]."</td>\n";
		echo "<td>".$row["Porte"]."</td>\n";
        
        // le seguenti 5 righe sono indentante per scopi PURAMENTE DIDATTICI, per mostrare il nesting dei tag
		echo "<td>\n";
        	echo "<a href=\"javascript:elimina('".$row["Id"]."','".$row["Modello"]."')\">\n";	// occhio a ' e " -> inoltre \" è l'escaping di " 
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
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/index.php">home</a>
</body>
</html>
