function fetchSensorData() {
  fetch('http://192.168.155.167/project1/get_latest_data.php')
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
        return;
      }

      document.getElementById("oxygen").textContent = `${(parseFloat(data.oxygen) || 0).toFixed(1)} mg/L`;
      document.getElementById("ph").textContent = `${(parseFloat(data.ph) || 0).toFixed(1)}`;
      document.getElementById("temp").textContent = `${(parseFloat(data.temperature) || 0).toFixed(1)} °C`;
      document.getElementById("nutrient").textContent = `${(parseFloat(data.nutrient) || 0).toFixed(1)} ppm`;
      document.getElementById("turbidity").textContent = `${(parseFloat(data.turbidity) || 0).toFixed(1)} NTU`;
      document.getElementById("water").textContent = `${(parseFloat(data.waterLevel) || 0).toFixed(1)} %`;
    })
    .catch(error => console.error("Error fetching sensor data:", error));
}

// Fetch data every 2 seconds
setInterval(fetchSensorData, 2000);
