<?php

include('../connect/connect.php');

    $id = $_GET['id'];

    $false = '0';
    $true = '1';

    $resultaten = $conn->prepare("SELECT * FROM stagedagen WHERE id = $id");
    $resultaten->execute();
    $result = $resultaten->fetch(PDO::FETCH_ASSOC);

    if($result['gewerkt'] == '0') {
        $gewerkt = 1;
        $prognose = 1;
    } else {
        $gewerkt = 0;
    }
        
    $sql = "UPDATE stagedagen SET gewerkt = :gewerkt WHERE id = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':gewerkt', $gewerkt, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

header("location:../read");
?>
                 