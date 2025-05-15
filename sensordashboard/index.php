<!DOCTYPE html>
<html>
<head>
  <title>Sensor Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function fetchData() {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_data.php", true);
      xhr.onload = function () {
        if (this.status === 200) {
          document.getElementById("data-body").innerHTML = this.responseText;
        }
      };
      xhr.send();
    }

    // Fetch data every 5 seconds
    setInterval(fetchData, 5000);
    window.onload = fetchData;
  </script>
</head>
<body>
  <h1>💧 Water Quality Dashboard</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Temperature (°C)</th>
        <th>Turbidity (NTU)</th>
        <th>TDS (ppm)</th>
        <th>Timestamp</th>
      </tr>
    </thead>
    <tbody id="data-body">
      <!-- Data will be loaded here via AJAX -->
    </tbody>
  </table>
</body>
</html>
