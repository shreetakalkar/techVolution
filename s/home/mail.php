<?php
// main.php (getRecipientEmail.php)
$conn = mysqli_connect("localhost", "root", "", "s1");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have a table named 'users' with columns 'id' and 'email'
$queryUser = "SELECT email FROM user WHERE id = 1"; // Adjust the query based on your database schema and user identification logic
$resultUser = mysqli_query($conn, $queryUser);

if ($row = mysqli_fetch_assoc($resultUser)) {
    $recipientEmail = $row['email'];
    echo $recipientEmail;
} else {
    echo "Error: User not found";
}

mysqli_close($conn);
?>
