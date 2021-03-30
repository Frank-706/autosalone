<?php
session_start();
include "config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

    if ($_POST["azione2"] == "login") {		
        $sql="SELECT r.pk as 'pkf',r.email as 'Email',r.nome as 'Nome', is_confirmed as 'Confermato' FROM as_registrati r WHERE r.pass = '".md5($_POST['pswd'])."' and r.email='".$_POST['ema']."'";
      // echo $sql.'<br>';
       $RS = $conn->query($sql); 
        if($RS->num_rows==1){
           $ro = $RS->fetch_assoc();
           $_SESSION['pkf']=$ro['pkf'];
           $_SESSION["Email"]=$ro['Email'];
           $_SESSION['Nome']=$ro['Nome'];
           $_SESSION['Confermato']=$ro['Confermato'];
           $msg = "Benvenuto " . $ro['Nome']." !";
           
        }
        else{
            $msg ="Accesso negato!";
        }
    }
?>
<!DOCTYPE html>
<html>
<title>CATALOGO : Automobili</title>
<head>
        <style>
        	body {
            	padding:10px;
                background-color: cyan;  
                          }
        	.comando {
            	width:200px;
            	height:100px;
            }
            table{
                margin: auto;
                border: solid black;
                width: 50%;
            }
        </style>
</head>
<body >
    <h1>Catalogo Automobili:</h1>
    <?php
     if(!isset($_SESSION["pkf"]))
     {
    ?>
<form action="" method="POST" id="cancellatore" name="cancellatore">
<fieldset>
<legend>Inserimento dati:</legend>
<input type="hidden" id="azione2" name="azione2" value="login">
<strong>Email:</strong> <input type="email" id='ema' name="ema"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd"><br>
<input type="submit" value="accedi"><br>
o
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/index.php">clicca qui per registrarti</a>
</fieldset><br>
</form>
<?php
     }
     /*if($_SESSION['Confermato']==0){
         $msg='Accesso negato';
     }
     else{*/
?>
<?php
if(isset($_SESSION["pkf"]))
     {
    ?>
    <form action="" method="POST" id="cancellatore" name="cancellatore">
<strong>Cerca: </strong> <input type='text' name='nome' id='nome' placeholder='marca,modello,lettere,numeri...'><br>
        <input type='submit' value='Carica'>
        <input type="hidden" name="azione" id="azione" value="charge">
        <input type="submit" id="chiusura" name="chiusura" value="logout">
       <input type="hidden" id="closed" name="closed" value="chiudi"> 
</form>
<?php
    	}
    //}
    ?>
<?php
/*$tipo=$_POST["nome"];
$foto=scandir($target_dir);//.'"$row["Id"]"'.".png"*/
if ($_POST["azione"] == "charge") {
$sql = "
        SELECT
        a.pk as 'Id',
        mo.pk as 'pk',
        a.targa as 'Targhe',
        mo.nome as 'Modelli',
        ma.nome as 'Marche',
        mo.anno as 'Anno',
        mo.n_posti as 'Posti',
        mo.n_porte as 'Porte'
        FROM     as_automobili a
        join as_modelli mo on a.fk_as_modelli=mo.pk
        join as_marche ma on mo.fk_as_marche=ma.pk
        where ma.nome like '%$tipo% '
        or mo.nome like '%$tipo%'
        or  mo.anno like '%$tipo%'
        or  mo.n_porte like '%$tipo%'
        or  mo.n_posti like '%$tipo%'";
        } 
        else if($_POST["azione"] == ""){
            $sql = "
                    SELECT  
                    a.pk as 'Id',
                    mo.pk as 'pk',
                    a.targa as 'Targhe',
                    mo.nome as 'Modelli',
                    ma.nome as 'Marche',
                    mo.anno as 'Anno',
                    mo.n_posti as 'Posti',
                    mo.n_porte as 'Porte'
                    FROM 	as_automobili a
                    join as_modelli mo on a.fk_as_modelli=mo.pk
                    join as_marche ma on mo.fk_as_marche=ma.pk ";
            }
    //$conn->query($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table border='2'>";
            echo "<tr>";
            echo "<th>Marche</th>";
            echo "<th>Modelli</th>";
            echo "<th>Posti</th>";
            echo "<th>Porte</th>";
            if(isset($_SESSION['pkf']))
                {
                     echo "<th>Anno</th>";
               }
               echo "<th>Immagini</th>";
            echo "</tr>"; 
        while($row = $result->fetch_assoc()) {
            $pk=$row['pk'];
            echo "<tr>\n";
                echo "<td >".$row["Marche"]."</td>\n";
                echo "<td >".$row["Modelli"]."</td>\n";
                echo "<td align='center'>".$row["Posti"]."</td>\n";
                echo "<td align='center'>".$row["Porte"]."</td>\n";
                if(isset($_SESSION['pkf']))
                {
                    echo "<td align='center'>".$row["Anno"]."</td>\n";
                }
               // if(in_array("pk_".$row["Id"].".png",$foto))
               //echo "<td>" . "<img class='comando' src=' $percorso'.".$row["Id"].".'.png'>"."</td>";
               echo "<td align='center'>" . "<img class='comando' src='img/upload/automobile_$pk.png'>"."</td>";
               echo "</tr>";
           // echo "</tr>";
        }
        echo "</table><br>";
        //echo $msg;
    } else {
            echo "Nessun risultato";
        }    
       /* if ($_POST["closed"] == "chiudi")
        {
            echo "Logout effettuato";
        }    */
echo $msg."<br>";
//session_destroy();
 $conn->close();
?>
</body>
</html>