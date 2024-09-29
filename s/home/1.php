<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "s1");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Your query
$query = "SELECT * FROM sneha";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Check if data is fetched
if (empty($data)) {
    die("No data found");
}

// Send data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
mysqli_close($conn);
?>

