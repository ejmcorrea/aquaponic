<?php
$conn = new mysqli("localhost", "root", "", "sensordata");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM readings ORDER BY id DESC LIMIT 10");

while ($row = $result->fetch_assoc()) {
  echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['temperature']}</td>
          <td>{$row['turbidity']}</td>
          <td>{$row['tds']}</td>
          <td>{$row['reading_time']}</td>
        </tr>";
}
?>
