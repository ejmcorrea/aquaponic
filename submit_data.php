<?php
$conn = new mysqli("localhost", "root", "", "sensordata");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$temperature = $_GET['temperature'];
$turbidity = $_GET['turbidity'];
$tds = $_GET['tds'];
$dissolveoxygen = $_GET['dissolveoxygen'];
$ph = $_GET['ph'];


$sql = "INSERT INTO readings (temperature, turbidity, tds, dissolveoxygen, ph) VALUES ('$temperature', '$turbidity', '$tds', '$dissolveoxygen', '$ph')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Data inserted successfully";
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
?>