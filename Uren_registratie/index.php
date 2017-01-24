
<?php

include('connect/connect.php');

    $resultaten = $conn->prepare("SELECT * FROM stagedagen");
    $resultaten->execute();

foreach($resultaten as $row) {
    $id = $row['id'];
    
    if(isset($id)) {
        header('Location:read');
    }
}

function createDatesFromRange($start, $end, $format = 'Y-m-d') {
    global $conn;
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) {
        $dagnummer = $date->format('w');
        
        $prognose = '1';
        if($dagnummer == '0' || $dagnummer == '6'){
            $prognose = '0';
        }

        $sql = 'INSERT INTO stagedagen (datum, gewerkt, prognose) VALUES (:datum, 0, :prognose)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':datum', $date->format($format));
        $stmt->bindParam(':prognose', $prognose);

        $stmt->execute();
    }
}

$startdate = '';
$enddate = '';

if(isset($_POST['datesubmit'])) {
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    createDatesFromRange($startdate, $enddate);

    header('location:read');
    }

?>


<html>
<head>
    <script src="jquery-3.1.1.min.js"></script>
    <script src="jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
  <script>
  $(function() {
    $( "#start" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#eind" ).datepicker({ dateFormat: 'dd-mm-yy' });
  });
      
  </script>
</head>
<body>
    
    <form action='' method="post">
        <h3>Datum</h3>
     <input id="start" type="date" name="startdate" required placeholder="Start datum" /> 
     <input id="eind" type="date" name="enddate" required placeholder="Eind datum"/> <br> <br>
<!--
        <h3>Opmerkingen</h3>
        <textarea rows="6" cols="20" id="tekst" required name="content" placeholder="Opmerkingen" id="tekst" maxlength="250"></textarea>
-->
     <input type="submit" value="Submit" name="datesubmit"> 
</form>
    
    </body>
</html>


