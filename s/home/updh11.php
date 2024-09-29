<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "s1");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get the latest data from dh11 table
$queryLatestDh11 = "SELECT * FROM dh11 ORDER BY date DESC LIMIT 1";
$resDh11 = mysqli_query($conn, $queryLatestDh11);

$response = array('latestTemperature' => 0, 'latestHumidity' => 0, 'latestDate' => 'N/A');

if ($resDh11 && mysqli_num_rows($resDh11) > 0) {
    $rowLatestDh11 = mysqli_fetch_assoc($resDh11);
    $response['latestTemperature'] = $rowLatestDh11['temperature'];
    $response['latestHumidity'] = $rowLatestDh11['humidity'];
    $response['latestDate'] = $rowLatestDh11['date'];
}

// Close the database connection
mysqli_close($conn);

// Return the response in JSON format
echo json_encode($response);
?>
