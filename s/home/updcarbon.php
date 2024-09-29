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

// Query to get the latest data from carbon table
$queryLatestCarbon = "SELECT * FROM carbon ORDER BY date DESC LIMIT 1";
$rescarbon = mysqli_query($conn, $queryLatestCarbon);

$response = array('latestcarbon' => 0,  'latestDate' => 'N/A');

if ($rescarbon && mysqli_num_rows($rescarbon) > 0) {
    $rowLatestCarbon = mysqli_fetch_assoc($rescarbon);
    $response['latestcarbon'] = $rowLatestCarbon['carbon'];
    $response['latestDate'] = $rowLatestCarbon['date'];
}

// Close the database connection
mysqli_close($conn);

// Return the response in JSON format
echo json_encode($response);
?>


