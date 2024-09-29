<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "s1";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "connected";
}

if (isset($_POST["moisture"])) {
    $t = $_POST["moisture"];
    $sql = "INSERT INTO sneha (moisture, date) VALUES (?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $t);

    if (mysqli_stmt_execute($stmt)) {
        echo "\nNew record created successfully";
        error_log("New record created successfully");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
        error_log("Error: " . $sql . " " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
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
            var data = google.visualization.arrayToDataTable([
                ['moisture', 'date&time'],
                <?php
                $query = "select * from sneha";
                $res = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($res)) {
                    $Label = $data['date'];
                    $Amount = $data['moisture'];
                    echo "['$Amount', '$Label'],";
                }
                ?>
            ]);

            var options = {
                title: 'Moisture level',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>

</html>
