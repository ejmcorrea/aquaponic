<?php
// Database connection details
$servername = "localhost"; // Change if not using localhost
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "iot_database";  // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from POST request
    $waste_level = isset($_POST['waste_level']) ? $_POST['waste_level'] : null;
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $humidity = isset($_POST['humidity']) ? $_POST['humidity'] : null;
    $methane_level = isset($_POST['methane_level']) ? $_POST['methane_level'] : null;

    // Validate data
    if ($waste_level !== null && $temperature !== null && $humidity !== null && $methane_level !== null) {
        // Prepare SQL statement to insert data into a table
        $sql = "INSERT INTO sensor_data (waste_level, temperature, humidity, methane_level, timestamp) 
                VALUES ('$waste_level', '$temperature', '$humidity', '$methane_level', NOW())";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Data successfully recorded.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "No data received.";
}

// Close the database connection
$conn->close();
?>
