<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IoT Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>IoT Dashboard</h1>

    <!-- Buzzer Toggle -->
    <div class="toggle-container">
      <label class="toggle">
        <input type="checkbox" id="buzzerToggle">
        <span class="slider"></span>
      </label>
      <p>Buzzer Control: <span id="buzzerStatus">OFF</span></p>
    </div>

    <!-- Trash Bin Level (Vertical Gauge) -->
    <div class="trash-gauge">
      <p id="trashLevelText">Trash Level: 0%</p>
      <div class="gauge">
        <div class="fill" id="trashFill"></div>
      </div>
    </div>

    <!-- Temperature Gauge -->
    <div class="temperature-gauge">
      <p id="temperatureText">Temperature: 0°C</p>
      <div class="gauge">
        <div class="fill" id="temperatureFill"></div>
      </div>
    </div>

    <!-- Humidity Gauge -->
    <div class="humidity-gauge">
      <p id="humidityText">Humidity: 0%</p>
      <div class="gauge">
        <div class="fill" id="humidityFill"></div>
      </div>
    </div>

    <!-- Methane Gauge (Horizontal) -->
    <div class="methane-gauge">
      <p id="methaneText">
        Methane Level: <span id="methanePPM">0</span> PPM (<span id="methanePercentage">0.0</span>%)
      </p>
      <div class="gauge">
        <div class="fill" id="methaneFill"></div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
  <script>
    //basic ajax framework autoupdate
      function fetchUpdateddata(){
        fetch('update.php')
        .then(response => response.text())
        .then(data => {
          document.getElementId('content').innerHTML =data;
        })
        .catch(error => console.error('Error fetching data:',error));
      }
  </script>
</body>
</html>
  