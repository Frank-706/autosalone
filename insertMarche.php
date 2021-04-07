<!DOCTYPE html>
<html>
<title>INSERT or UPDATE: Marche</title>
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
</head>
<body>
<h1>INSERT: Marche</h1>
<form action="" method="GET" id="cancellatore" name="cancellatore">
	<input type="hidden" name="azione" id="azione" value="delete">
	<input type="hidden" name="chi" id="chi" value="">
    <input type='hidden' 	name='azione2' id='azione2' value='insert'>
    <br>
   marca: <input type='text' name='marca' id='marca' placeholder='nome della marca' required> <br>
    <input type='submit' 	value='inserisci'>
</form><br>
<form action="" method="post" enctype="multipart/form-data">
  Seleziona un'immagine da caricare: <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit" id="submit">
</form>
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_marche.php">Torna alle crud delle marche</a>
<!--insert-->
<?php
include "../config.php";

// connessione al DB
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-paswd"], $CONFIG["db-name"]);
if ($CN->connect_error)
	die("Connection failed: " . $CN->connect_error);

if ($_GET["azione2"] == "insert") {
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
	$marche=$_GET['marca'];
    
	// verifica se la marca è vuota
	$sql = "SELECT COUNT(*) AS n FROM as_marche WHERE nome='$marche'";
	$RS = $CN->query($sql); 	// esecuzione della query di insert sul DB
	$row = $RS-> fetch_assoc();	// da $RS estraggo una riga
    if ($row["n"]>=1) {			// testo il campo "n" della riga
    	$msg = "marca '$marche' esistente, impossibile inserire";
    }
    else if ($marche == "") {
    	$msg = "marca non specificata, impossibile inserire";
    }
    else {
      $sql = "INSERT INTO as_marche (pk,
                         nome
                      ) VALUES (
                          null,
                          '$marche'
                      )";
//echo $sql;
      $CN->query($sql); // esecuzione della query di insert sul DB
      $msg = "inserimento della marca'$marche' avvenuto con successo";
    }
}
echo $msg.'<br>';
//$CN->close();

//delete

/*include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);*/

/*if ($_POST["azione"] == "delete") {
//die("disabled");
	$sql = "DELETE FROM as_marche WHERE pk = " . $_POST["chi"];
	$CN->query($sql);
}

$sql = "
		SELECT  
                ma.pk as Id,
                ma.nome as Marche
		FROM 	as_marche ma
       order by ma.nome
        ";
$result = $CN->query($sql);

if ($result->num_rows > 0) {
	echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Marche</th>";
    echo "<th>Comandi</th>";
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>\n";
		echo "<td >".$row["Marche"]."</td>\n";
		echo "<td>\n";
        	echo "<a href=\"javascript:elimina('".$row["Id"]."','".$row["Marche"]."')\">\n";	// occhio a ' e " -> inoltre \" è l'escaping di " 
        		echo "<img class='comando' src='http://frankmoses.altervista.org/INFORMATICA/monnezza.jpg'>\n";
        	echo "</a>\n";
        echo "</td>\n";
        
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}*/
$target_dir = "../img/upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Controlla se il file immagine è un'immagine reale o un'immagine falsa
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "Il file è un'immagine- " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Il file non è un'immagine.";
    $uploadOk = 0;
  }
}

// Controlla se il file esiste già
if (file_exists($target_file)) {
  echo "Il file esiste.";
  $uploadOk = 0;
}


// Controlla se il file ha estensione .png
if( $imageFileType != "png" ) {
  echo "Gli altri formati non sono supportati.";
  $uploadOk = 0;
}

// Controlla se $uploadOk è impostato su 0 da un errore
if ($uploadOk == 0) {
  echo "Il file non è stato caricato.";
// se tutto va bene, prova a caricare il file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "se tutto va bene, prova a caricare il file"."Il file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " è stato caricato.";
  } else {
    echo "C'è stato un errore durante il caricamento.";
  }
}
$CN->close();
?>
</body>
</html>
