<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensordata"; // change this to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => 'DB connection failed']));
}

$sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo json_encode($result->fetch_assoc());
} else {
  echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>
