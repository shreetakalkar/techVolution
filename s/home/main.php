<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "s1";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    echo"connected";
}
if (isset($_POST["temperature"]) && isset($_POST["humidity"])) {

    $t = $_POST["temperature"];
    $h = $_POST["humidity"];

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO dh11 (temperature, humidity, date) VALUES (?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dd", $t, $h); // Use "dd" for double values

    if (mysqli_stmt_execute($stmt)) {
        echo "\nNew record created successfully";
        error_log("New record created successfully");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
        error_log("Error: " . $sql . " " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
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

if (isset($_POST["carbon"])) {
    $t = $_POST["carbon"];
    $sql = "INSERT INTO carbon (carbon, date) VALUES (?, NOW())";

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

// Close the database connection
mysqli_close($conn);
?>
