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
<br>
<form action="" method="post" enctype="multipart/form-data">
  Seleziona un'immagine da caricare: <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit" id="submit">
</form>
<?php
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
?>
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/admin/crud_automobili.php">Torna alle crud delle Automobili</a>
</body>
</html>
