<?php
session_start();
include "config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error); 
?>
<!DOCTYPE html>
<html>
<title>CATALOGO : Automobili</title>
<head>
        <style>
        	body {
            	padding:10px;
                background-color: grey;  
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
    //var_dump($_SESSION);
    if($_POST["chiusura"] == "logout"){
        echo "Logout effettuato.";
        unset($_SESSION["pkf"]);
        session_destroy();
      }
    // if(!isset($_SESSION["pkf"]))
     //{
    ?> 
<?php
     //}
     if ($_POST["azione2"] == "login" ) {		
        $sql="SELECT r.pk as 'pkf',r.email as 'Email',r.nome as 'Nome', is_confirmed as 'Confermato' FROM as_registrati r WHERE r.pass = '".md5($_POST['pswd'])."' and r.email='".$_POST['ema']."'";
      // echo $sql.'<br>';
       $RS = $conn->query($sql); 
        if($RS->num_rows==1){
           $ro = $RS->fetch_assoc();
           $_SESSION['pkf']=$ro['pkf'];
           $_SESSION["Email"]=$ro['Email'];
           $_SESSION['Nome']=$ro['Nome'];
           $confermato=$ro['Confermato'];
           $_SESSION['Confermato']=$ro['Confermato'];
           if(isset($_SESSION['pkf'])){
               $msg = "Benvenuto " . $ro['Nome']." !";
            }
       //echo $_SESSION['Confermato'];
     //if($_SESSION['Confermato']==0){
        // echo 'Accesso negato, controlla la mail che ti abbiamo inviato.';
        
        // $msg="";
     } 
      else{
                $msg ="Accesso negato!";
            }
    }
    // else{
?>
<form action="" method="POST">
<fieldset>
<legend>Inserimento dati:</legend>
<!--<input type="hidden" id="azione2" name="azione2" value="login">-->
<strong>Email:</strong> <input type="email" id='ema' name="ema"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd"><br>
<input type="submit" id="azione2" name="azione2" value="login"><br>o
<br><a href="http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/registra.php">clicca qui per registrarti</a>
<br><br><strong>Cerca: </strong> <input type='text' name='nome' id='nome' placeholder='targa,marca,...'><br> 
<?php
    if(isset($_SESSION["pkf"]))
    {
?>
        Filtro: <select id='filtro' name='filtro'>
        <option value='' label='Seleziona un campo per la ricerca' selected disabled >
        <option value=ma.nome label="Marca" ></option>
        <option value=mo.nome label="Modello" ></option>
        <option value=mo.anno label="Anno" ></option>
        <option value=mo.n_posti label="Posti" ></option>
        <option value=mo.n_porte label="Porte" ></option>
        </select><br>
       <input type="submit" id="chiusura" name="chiusura" value="logout"> 
<?php
    }
?> 
<input type='submit' name="azione" id="azione" value='Ricerca'>
</fieldset><br>       

</form> 
<?php
if ($_POST["azione"] == "Ricerca")
{
   $tipo = $_POST["nome"];
   $select = $_POST["filtro"];
   /*echo $select;
   echo $tipo;*/
   if(isset($_SESSION["pkf"]))
    {
        $sql = "SELECT
        a.pk as 'Id',
        mo.pk as 'pk',
        ma.pk as 'marca',
        a.targa as 'Targhe',
        mo.nome as 'Modelli',
        ma.nome as 'Marche',
        mo.anno as 'Anno',
        mo.n_posti as 'Posti',
        mo.n_porte as 'Porte'
        FROM  as_automobili a
        join as_modelli mo on a.fk_as_modelli=mo.pk
        join as_marche ma on mo.fk_as_marche=ma.pk
        where $select like '%$tipo%'";
       // echo $sql . "<br>";
        $result = $conn->query($sql);
    }
    else
    {
    $sql = "
            SELECT
            a.pk as 'Id',
            mo.pk as 'pk',
            ma.pk as 'marca',
            a.targa as 'Targhe',
            mo.nome as 'Modelli',
            ma.nome as 'Marche',
            mo.anno as 'Anno',
            mo.n_posti as 'Posti',
            mo.n_porte as 'Porte'
            FROM  as_automobili a
            join as_modelli mo on a.fk_as_modelli=mo.pk
            join as_marche ma on mo.fk_as_marche=ma.pk
            where ma.nome like '%$tipo%'
            or mo.nome like '%$tipo%'
            or  mo.n_porte like '%$tipo%'
            or  mo.n_posti like '%$tipo%'";
            $result = $conn->query($sql);
        }
 }
    else
        {
            $sql = "
            SELECT  
            a.pk as 'Id',
            mo.pk as 'pk',
            ma.pk as 'marca',
            a.targa as 'Targhe',
            mo.nome as 'Modelli',
            ma.nome as 'Marche',
            mo.anno as 'Anno',
            mo.n_posti as 'Posti',
            mo.n_porte as 'Porte'
            FROM 	as_automobili a
            join as_modelli mo on a.fk_as_modelli=mo.pk
            join as_marche ma on mo.fk_as_marche=ma.pk ";
            $result = $conn->query($sql);
        }
    if ($result->num_rows > 0) 
    {
        echo "<table border='2'>";
            echo "<tr>";
            echo "<th>Marchi</th>";
            echo "<th>Marche</th>";
            echo "<th>Modelli</th>";
            echo "<th>Posti</th>";
            echo "<th>Porte</th>";
            if(isset($_SESSION['pkf']))
                {
                     echo "<th>Anno</th>";
                     echo "<th>Info</th>";
               }
               echo "<th>Immagini</th>";
            echo "</tr>"; 
        while($row = $result->fetch_assoc()) {
            $pk=$row['pk'];
            $marca=$row['marca'];
           $porte=$row['Porte'];
            $targa=$row['Targhe'];
            $anno=$row['Anno'];
            $posti=$row['Posti'];
            $modello=$row['Modelli'];
            $nome_marca=$row['Marche'];
            $aut=$row['Id'];
            echo "<tr>\n";
            echo "<td align='center'>" . "<a href='http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/img/upload/marca_$marca.png'> "."<img class='comando' src='img/upload/marca_$marca.png'></a>"."</td>";
                echo "<td >".$row["Marche"]."</td>\n";
                echo "<td >".$row["Modelli"]."</td>\n";
                echo "<td align='center'>".$row["Posti"]."</td>\n";
                echo "<td align='center'>".$row["Porte"]."</td>\n";
                if(isset($_SESSION['pkf']))
                {
                    echo "<td align='center'>".$row["Anno"]."</td>\n";
                    echo "<td align='center'>" . "<form method='POST' action=''><input type='submit' id='info' name='info' value='INFO' ></form>" . "</td>\n";
                }
               // if(in_array("pk_".$row["Id"].".png",$foto))
               //echo "<td>" . "<img class='comando' src=' $percorso'.".$row["Id"].".'.png'>"."</td>";
               echo "<td align='center'>" . "<a href='http://frankmoses.altervista.org/INFORMATICA/wapp/autosalone/img/upload/automobile_$pk.png'> "."<img class='comando' src='img/upload/automobile_$pk.png'></a>"."</td>";
               echo "</tr>";
           // echo "</tr>";
        }
        echo "</table><br>";
        //echo $msg;
    } 
    else {
            echo "Nessun risultato";
        }    
        if($_POST["info"]=="INFO" )
        {
        $email=$_SESSION["Email"];
            // definisco mittente e destinatario della mail
        $nome_mittente = "Francesco Fulvio Di Nisio";
        $mail_mittente = "francescofulvio.dinisio@italessandrini.edu.it";
        $mail_destinatario = $email;
        
        // definisco il subject ed il body della mail
        $mail_oggetto = "Info $modello";
        $mail_corpo = " \nMarca: $nome_marca\n
                        Targa: $targa \n
                        Anno: $anno\n
                        Posti: $posti \n
                        Porte: $porte
                        ";
        
        // aggiusto un po' le intestazioni della mail
        // E' in questa sezione che deve essere definito il mittente (From)
        // ed altri eventuali valori come Cc, Bcc, ReplyTo e X-Mailer
        $mail_headers = "From: " .  $nome_mittente . " <" .  $mail_mittente . ">\r\n";
        $mail_headers .= "Reply-To: " .  $mail_mittente . "\r\n";
        $mail_headers .= "X-Mailer: PHP/" . phpversion();
        
        mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers);
        
        }
	echo $msg."<br>";
 $conn->close();
?>
</body>
</html>
