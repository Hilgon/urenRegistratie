<?php

include('../connect/connect.php');

$id = $_GET['id'];

$update = "";

if(isset($_POST['submit'])) {
    
    $opmerking = $_POST['content'];
    
    $sql = "UPDATE stagedagen SET opmerking = :opmerking WHERE `id` = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':opmerking', $opmerking, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    if($query->execute()) {
    $update = "Update geslaagd";
    } else {
        $update = "Update mislukt";
    }
    header('location:../');
}



?>
<head>
<link href="../css/style.css" rel="stylesheet">
    <meta charset="utf-8">
    <script src="../js/jquery-3.1.1.min.js"></script>

</head>
<body>
 <div id="container">
     <h1>Terry Zhou</h1>
        <h2>
            <?php
            $resultaten = $conn->prepare("SELECT * FROM stagedagen WHERE id = $id");
            $resultaten->execute();
            
            foreach($resultaten as $row) {
                echo $row['datum'];
            }
            ?>
     </h2>
     <?php 
     echo $update; ?>
     <br><br>
             <form method="post" enctype="multipart/form-data">
          <?php
                 $resultaten = $conn->prepare("SELECT * FROM stagedagen WHERE id = $id");
                $resultaten->execute();
                 
                 foreach($resultaten as $row) {
                ?>
            <textarea rows="15" cols="30" id="tekst" maxlength="400" name="content"><?php echo $row['opmerking'];?></textarea>
                 
                 <?php
                 }
                     ?>
            <br>
                 <input type="submit" value="Wijzigingen opslaan" name="submit">
        </form>
       
        </div>
</body>