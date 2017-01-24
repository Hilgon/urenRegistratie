<?php

include('../connect/connect.php');

    $resultaten = $conn->prepare("SELECT * FROM stagedagen WHERE prognose = 1");
    $resultaten->execute();

if(isset($_POST['leegData'])) {
    
    $resultaten = $conn->exec("TRUNCATE TABLE stagedagen; ALTER TABLE stagedagen AUTO_INCREMENT=1");
    header('location:../read');
}


?>
<head>
<link href="../css/style.css" rel="stylesheet">
    <meta charset="utf-8">
    <script src="../js/jquery-3.1.1.min.js"></script>
</head>
<body>
    
 <div id="container">
        <h1>Nick Vooren & Zhou Yi</h1>
     
     <?php
     
     if ($resultaten->rowCount() > 0) {
        echo "<form action='' method='post'>
     <input type='submit' value='Data legen' name='leegData' onClick=\"javascript:return confirm('Weet je zeker dat je de data wilt verwijderen?')\" >
     </form>";
     } else {
         echo '<form action="../"><input type="submit" value="Data invullen"></form>';
     }
     
     ?>
     
     
        <p>Aantal gewerkte dagen: 
            <?php
            
            $results_gewerkt = $conn->prepare("SELECT * FROM stagedagen WHERE gewerkt = 1");
            $results_gewerkt->execute();
            $count_gewerkt = $results_gewerkt->rowCount(); 
            echo $count_gewerkt;
            ?>
            </p>
        <p>Aantal dagen te gaan:
     
                 <?php
            
            $results_werken = $conn->prepare("SELECT * FROM stagedagen WHERE prognose = 1 AND gewerkt = 0");
            $results_werken->execute();
            $count_werken = $results_werken->rowCount(); 
            echo $count_werken;
            ?>
            
     </p>
        <p>Totaal aantal dagen:
     
                 <?php
 
            $count_totaal = $resultaten->rowCount(); 
            echo $count_totaal;
            ?>
            
     </p>
        <form action="" method="post">
        <table class="container">
            <thead>
		      <tr>
                <th><h1>Datum</h1></th>
                <th><h1>Aanwezigheid</h1></th>
                <th><h1>Opmerkingen</h1></th>
                <th><h1>Aanpassen</h1></th>
		      </tr>
	       </thead>
        
            
                        <?php
                
foreach($resultaten as $row) {
                    
    $datum = $row['datum'];
    $datum = date('d-m-Y', strtotime($datum));
    $werk = $row['gewerkt'];
    $opmerking = $row['opmerking'];
    $id = $row['id'];
                    
        echo '<tr>
        <tbody><tr><td>'.$datum.'</td>
        <td><a href="update.php?id='.$id.'"><p>'.$werk.'<p></a></td>
        <td class="opmerking">'.$opmerking.'</td>
        <td class=""><a href="opmerking.php?id='.$id.'"><img src="../img/potlood.png" width="60" height="60" id="img"></td></a>
        </tr><tbody>';
}
            ?>           


        </table>
        </form>
        </div>
</body>