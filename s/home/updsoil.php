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

// Query to get the latest data from sneha table
$queryLatestSoil = "SELECT * FROM sneha ORDER BY date DESC LIMIT 1";
$resSoil = mysqli_query($conn, $queryLatestSoil);

$response = array('latestMoisture' => 0, 'latestDate' => 'N/A');

if ($resSoil && mysqli_num_rows($resSoil) > 0) {
    $rowLatestSoil = mysqli_fetch_assoc($resSoil);
    $response['latestMoisture'] = $rowLatestSoil['moisture'];
    $response['latestDate'] = $rowLatestSoil['date'];
}

// Close the database connection
mysqli_close($conn);

// Return the response in JSON format
echo json_encode($response);
?>
