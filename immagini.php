<!DOCTYPE html>
<html>
<body>
<form action="" method="post" enctype="multipart/form-data">
  Seleziona un'immagine da caricare: <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit" id="submit">
</form>
<?php
$target_dir = "img/upload/";
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
</body>
</html>