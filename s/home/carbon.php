<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "s1";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["carbon"])) {
    $t = $_POST["carbon"];
    $sql = "INSERT INTO carbon (carbon, date) VALUES (?, NOW())";
    
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
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'date');
            data.addColumn('number', 'carbon');

            <?php
            $query = "select * from carbon";
            $res = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($res)) {
                $Label = $data['date'];
                $Amount = $data['carbon'];
                echo "data.addRow(['$Label', $Amount]);";
            }
            ?>
            
            var options = {
                title: 'Carbon',
                hAxis: { title: 'date' },
                vAxis: { title: 'carbon' },
                legend: 'none'
            };

            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>

</html>
