<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "s1");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch DH11 data
$queryDh11 = "SELECT * FROM dh11";
$resDh11 = mysqli_query($conn, $queryDh11);

// Check for query error
if (!$resDh11) {
    die("Query failed: " . mysqli_error($conn));
}

// Query to fetch soil data
$querySoil = "SELECT * FROM sneha";
$resSoil = mysqli_query($conn, $querySoil);

// Check for query error
if (!$resSoil) {
    die("Query failed: " . mysqli_error($conn));
}

$querycarbon = "SELECT * FROM carbon";
$rescarbon = mysqli_query($conn, $querycarbon);

// Check for query error
if (!$rescarbon) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch data from the result sets
$dataDh11Array = array();
while ($dataDh11 = mysqli_fetch_array($resDh11)) {
    $dateDh11 = $dataDh11['date'];
    $tempDh11 = $dataDh11['temperature'];
    $humiDh11 = $dataDh11['humidity'];
    $dataDh11Array[] = "['$dateDh11', $tempDh11, $humiDh11]";
}

$dataSoilArray = array();
while ($dataSoil = mysqli_fetch_array($resSoil)) {
    $timesoil = $dataSoil['date'];
    $moissoil = $dataSoil['moisture'];
    $dataSoilArray[] = "['$timesoil', $moissoil]";
}
$dataCarbonArray = array();
while ($dataCarbon = mysqli_fetch_array($rescarbon)) {
    $timeCarbon = $dataCarbon['date'];
    $carbon = $dataCarbon['carbon'];
    $dataCarbonArray[] = "['$timeCarbon', $carbon]";
}

// Close the database connection


$dataDh11String = implode(",", $dataDh11Array);
$datasoilString = implode(",", $dataSoilArray);
$dataCarbonString = implode(",", $dataCarbonArray);


mysqli_close($conn);

// Close the database connection


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://webaudioapi.github.io/webaudio_demos/speech_synthesis/speech_synthesis.js"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css2/style1.css">
</head>
<body >


<nav class="navbar">
    <!-- LOGO -->
    <div class="logo">techVolution</div>

    <!-- NAVIGATION MENU -->
    <ul class="nav-links">

      <!-- USING CHECKBOX HACK -->
  

      <!-- NAVIGATION MENUS -->
      <div class="menu">

        <li><a href="1.html">Home</a></li>
        

        <li class="services">
          <a href="con.html">Contact us</a>

          <!-- DROPDOWN MENU -->
          

        </li>

        <li><a href="index.php">Dashboard</a></li>
       
      </div>
    </ul>
  </nav>
 

</body>
    
    <div class="grid-container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">
                <span class="material-icons-outlined">search</span>
            </div>
           
        </header>
        <!-- End Header -->

        <!-- Sidebar -->
     
        <aside id="sidebar">

            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">dashboard</span> DASHBOARD
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Dashboard
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">settings</span> Settings
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main -->

        <div class="main-container" >
          
            <div class="main-title">
                <h2>DASHBOARD</h2>
            </div>

            <div class="main-cards">
                <div class="card">
                    <div class="card-inner">
                        <h3 style="color:white;">DH11</h3>
                    </div>
                    <h4 style="color:white;"><b>temperature:</b> <span id="latestTemperature">N/A</span>°C (Date: <span id="latestDateDh11">N/A</span>)<br><b>humidity</b> <span id="latestHumidity">N/A</span> (Date: <span id="latestDateHumidity">N/A</span>) <br><br><a href="#">see more </a></h4>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3 style="color:white;">carbon</h3> 
                   
                </div>
               <h3 style="color:white;"><b>Carbon:</b> <span id="latestCarbon">N/A</span> (Date: <span id="latestDateCarbon">N/A</span>)<br><br><a href="carbonpdf.php">see more </a></h4>
                    </div>

                <div class="card">
                    <div class="card-inner">
                        <h3 style="color:white;">Mositure</h3>
                    </div>
                    <h4 style="color:white;"><b>Mositure:</b><span id="latestMoisture">N/A</span> (Date: <span id="latestDateSoil">N/A</span>)<br><br><a href="#">see more </a></h4>
                </div>

            </div>

            <div class="charts">
                <div class="charts-card">
                    <h2 class="chart-title">Temperature and humidity</h2>
                    <div id="bar-chart"></div>
                </div>

                <div class="charts-card">
                    <h2 class="chart-title">Soil Moisture </h2>
                    <div id="area-chart"></div>
                 
                </div>

                <div class="charts-card">
                    <h2 class="chart-title">Carbon</h2>
                   <div id="scatterchart"></div>

         
                </div>
            </div>
        </main>
        <!-- End Main -->
    </div>

    <!-- Scripts -->
    <!-- Custom JS -->
    <script src="script1.js"></script>

    <!-- Add this script to the end of your HTML body section -->
    <script>
  function speak(command) {
            var utterance = new SpeechSynthesisUtterance(command);
            console.log('Speaking:', command);

            // Create an invisible button
            var button = document.createElement('button');
            button.style.display = 'none';

            // Add the button to the document
            document.body.appendChild(button);

            // Trigger a click event on the button
            button.click();

            // Remove the button from the document after the click event
            button.parentNode.removeChild(button);

            // Perform speech synthesis
            speechSynthesis.speak(utterance);
        }
function checkSoilMoisture() {
    $.ajax({
        url: 'updsoil.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Received soil data:', data);
            var latestMoisture = data.latestMoisture;

            // Trigger voice condition based on moisture
            if (latestMoisture !== null && latestMoisture < 400) {
                speak("Alert! Soil moisture level is too low. Please water the plants.");
            } else {
                speak("good soil");
            }
        },
        error: function () {
            console.error('Failed to fetch latest soil data.');
        }
    });
   
       
    $.ajax({
        url: 'updh11.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Received DH11 data:', data);
            $('#latestTemperature').text(data.latestTemperature);
            $('#latestHumidity').text(data.latestHumidity);
            $('#latestDateDh11').text(data.latestDate);

            // Trigger voice condition based on high temperature
            if (data.latestTemperature !== null && data.latestTemperature > 50) {
                speak("Alert! High temperature detected. Take necessary actions.");
            }

            // Trigger voice condition based on low humidity
            if (data.latestHumidity !== null && data.latestHumidity < 70) {
                speak("Alert! Low humidity detected. Take necessary actions.");
            }

            // Call drawChart to update the chart with new DH11 data
          
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}

$.ajax({
        url: 'updcarbon.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Received carbon data:', data);
            $('#latestCarbon').text(data.latestcarbon);
            $('#latestDateCarbon').text(data.latestDate);

            // Trigger voice condition based on high carbon level
            if (data.latestcarbon !== null && data.latestcarbon > 50) {
                speak("Alert! High carbon level detected. Take necessary actions.");
            }

            // Call drawChart to update the chart with new carbon data
           
        },
        error: function () {
            console.error('Failed to fetch latest carbon data.');
        }
     

    });

// Periodically check soil moisture every 5 seconds
setInterval(checkSoilMoisture, 5000);

// Example: initiate speech directly (without user activation)




            // Function to update DH11 data
            function updateDh11Data() {
                $.ajax({
                    url: 'updh11.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Received DH11 data:', data);
                        $('#latestTemperature').text(data.latestTemperature);
                        $('#latestHumidity').text(data.latestHumidity);
                        $('#latestDateDh11').text(data.latestDate);

                        // Trigger voice condition based on moisture
                      
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            // Function to update Soil data
            function updateSoilData() {
                $.ajax({
                    url: 'updsoil.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Received soil data:', data);
                        $('#latestMoisture').text(data.latestMoisture);
                        $('#latestDateSoil').text(data.latestDate);

                        // Trigger voice condition based on moisture
                        checkSoilMoisture()
                    },
                    error: function () {
                        console.error('Failed to fetch latest soil data.');
                    }
                });
            }
            function updateCarbonData() {
    $.ajax({
        url: 'updcarbon.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Received carbon data:', data);
            $('#latestCarbon').text(data.latestcarbon);
            $('#latestDateCarbon').text(data.latestDate);

            // Trigger voice condition based on moisture
            // ...

            // Call drawChart to update the chart with new carbon data
        
        },
        error: function () {
            console.error('Failed to fetch latest carbon data.');
        }
    });
}

// Call updateCarbonData initially
updateCarbonData();

// Periodically update Carbon data every 5 seconds
setInterval(updateCarbonData, 5000);

            setInterval(updateDh11Data, 5000);

            // Periodically update Soil data every 5 seconds
            setInterval(updateSoilData, 5000);

            // Your existing code...
    
        google.charts.load('current', {
            'packages': ['corechart']
        });
    
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var dataDh11 = new google.visualization.DataTable();
            dataDh11.addColumn('string', 'date');
            dataDh11.addColumn('number', 'temperature');
            dataDh11.addColumn('number', 'humidity');

            var dataArrayDh11 = [<?php echo $dataDh11String; ?>];
            console.log('dataArrayDh11:', dataArrayDh11);
            dataDh11.addRows(dataArrayDh11);

            var optionsDh11 = {
                title: 'DH11',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
            };

            var chartDh11 = new google.visualization.LineChart(document.getElementById('bar-chart'));
            chartDh11.draw(dataDh11, optionsDh11);

            var dataSneha = new google.visualization.DataTable();
            dataSneha.addColumn('string', 'date');
            dataSneha.addColumn('number', 'moisture');

            var dataArraySneha = [<?php echo $datasoilString; ?>];
            dataSneha.addRows(dataArraySneha);
            var optionsSneha = {
                title: 'Moisture level',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
            };

            var chartSneha = new google.visualization.LineChart(document.getElementById('area-chart'));
            chartSneha.draw(dataSneha, optionsSneha);
            var dataCarbon = new google.visualization.DataTable();
dataCarbon.addColumn('string', 'date');
dataCarbon.addColumn('number', 'carbon');

var dataArrayCarbon = [<?php echo $dataCarbonString; ?>];
dataCarbon.addRows(dataArrayCarbon);
console.log('dataArrayCarbon:', dataArrayCarbon);

var optionsCarbon = {
    title: 'Carbon',
    hAxis: { title: 'date' },
    vAxis: { title: 'carbon' },
    legend: 'none',

};

var chartCarbon = new google.visualization.ScatterChart(document.getElementById('scatterchart'));

chartCarbon.draw(dataCarbon, optionsCarbon);
console.log('Carbon chart drawn successfully');

        }
        

        // Periodically update and draw charts every 5 seconds
        setInterval(function () {
           
            drawChart();
        }, 5000);
    </script>
</body>
</html>