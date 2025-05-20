<?php
$conn = new mysqli("localhost", "root", "", "sensordata");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM readings ORDER BY id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sensor Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>💧 Water Quality Dashboard</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Temperature (°C)</th>
      <th>Turbidity (NTU)</th>
      <th>TDS (ppm)</th>
      <th>Readings</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['temperature'] ?></td>
      <td><?= $row['turbidity'] ?></td>
      <td><?= $row['tds'] ?></td>
      <td><?= $row['reading_time'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
