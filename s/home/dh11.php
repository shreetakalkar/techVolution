<?php
/*************************************************************************************************
 *  Created By: Tauseef Ahmad
 *  Created On: 3 April, 2023
 *  
 *  YouTube Video: https://youtu.be/VEN5kgjEuh8
 *  My Channel: https://www.youtube.com/channel/UCOXYfOHgu-C-UfGyDcu5sYw/
 ***********************************************************************************************/

$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "s1"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); 
} 

echo "Database connection is OK<br>"; 

if(isset($_POST["temperature"]) && isset($_POST["humidity"])) {

    $t = $_POST["temperature"];
    $h = $_POST["humidity"];

    $sql = "INSERT INTO dh11 (temperature, humidity,date) VALUES (" . $t . ", " . $h . ", NOW())";

    if (mysqli_query($conn, $sql)) { 
        echo "\nNew record created successfully"; 
    } else { 
        echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
    }
}

if (isset($_POST["moisture"])) {
    $t = $_POST["moisture"];
    $sql = "INSERT INTO sneha (moisture, time) VALUES (?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $t);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "\nNew record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
}
?>

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Chart for dh11
        var dataDh11 = new google.visualization.DataTable();
        dataDh11.addColumn('string', 'time');
        dataDh11.addColumn('number', 'temperature');
        dataDh11.addColumn('number', 'humidity');
        
        <?php
        $queryDh11 = "SELECT * FROM dh11";
        $resDh11 = mysqli_query($conn, $queryDh11);
        while ($dataDh11 = mysqli_fetch_array($resDh11)) {
            $dateDh11 = $dataDh11['date'];
            $tempDh11 = $dataDh11['temperature'];
            $humiDh11 = $dataDh11['humidity'];
            echo "dataDh11.addRow(['$dateDh11', $tempDh11, $humiDh11]);";
        }
        ?>

        var optionsDh11 = {
            title: 'DH11',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chartDh11 = new google.visualization.LineChart(document.getElementById('curve_chart_dh11'));

        chartDh11.draw(dataDh11, optionsDh11);

        // Chart for sneha
        var dataSneha = new google.visualization.DataTable();
        dataSneha.addColumn('string', 'time');
        dataSneha.addColumn('number', 'moisture');

        <?php
        $querySneha = "SELECT * FROM sneha";
        $resSneha = mysqli_query($conn, $querySneha);
        while ($dataSneha = mysqli_fetch_array($resSneha)) {
            $LabelSneha = $dataSneha['time'];
            $AmountSneha = $dataSneha['moisture'];
            echo "dataSneha.addRow(['$LabelSneha', $AmountSneha]);";
        }
        ?>

        var optionsSneha = {
            title: 'Moisture level',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chartSneha = new google.visualization.LineChart(document.getElementById('curve_chart_sneha'));

        chartSneha.draw(dataSneha, optionsSneha);
    }
  </script>
</head>
<body>
<div id="curve_chart_dh11" style="width: 1200px; height: 500px"></div>
  <div id="curve_chart_sneha" style="width: 1200px; height: 500px"></div>
</body>
</html>
