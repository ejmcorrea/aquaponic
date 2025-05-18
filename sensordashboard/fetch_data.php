<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "sensordata");
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Get the latest reading
$latest = $conn->query("SELECT * FROM readings ORDER BY reading_time DESC LIMIT 1");
$latestData = $latest->fetch_assoc();

// Get the table data
$result = $conn->query("SELECT * FROM readings ORDER BY reading_time DESC LIMIT 10");
$tableRows = [];
while ($row = $result->fetch_assoc()) {
    $tableRows[] = $row;
}

// Return both latest reading and table data
echo json_encode([
    'latest' => $latestData,
    'tableData' => $tableRows
]);


if (isset($_GET['device']) && isset($_GET['state'])) {
    $device = $_GET['device'];
    $state = $_GET['state'];

    // Sample code: You would control GPIO pins, database, or API here
    // For now, just simulate success
    echo json_encode(['success' => true, 'device' => $device, 'state' => $state]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}   
$conn->close();
?>
