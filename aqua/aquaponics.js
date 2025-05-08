  // Function to update the time and date every second
  function updateTime() {
    const now = new Date();
    const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const date = now.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
  
    document.querySelector('.time-value').textContent = time;
    document.querySelector('.date-value').textContent = date;
  }
  
  // Run once when page loads
  updateTime();
  
  // Then keep updating every 1 second (1000ms)
  setInterval(updateTime, 1000);
  
  document.addEventListener('DOMContentLoaded', () => {
    const timeElements = document.querySelectorAll('.time-value1');
    const dateElements = document.querySelectorAll('.date-value1');
  
    const now = new Date();
    const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const dateStr = now.toLocaleDateString();
  
    timeElements.forEach(el => {
      el.textContent = timeStr;
    });
  
    dateElements.forEach(el => {
      el.textContent = dateStr;
    });
  });

  function toggleFeed() {
    const feedButton = document.getElementById('feedButton');
  
    // Turn ON
    feedButton.classList.remove('off');
    feedButton.classList.add('on');
  
    // After 5 seconds, turn OFF
    setTimeout(() => {
      feedButton.classList.remove('on');
      feedButton.classList.add('off');
    }, 5000);
  }
  
// Example if you want to later change it
document.getElementById('device-status').textContent = 'Disconnected';
document.getElementById('device-status').style.color = 'red';

  // Get elements by matching IDs
  const oxygen = document.getElementById("oxygen");
  const ph = document.getElementById("ph");
  const temp = document.getElementById("temp");
  const nutrient = document.getElementById("nutrient");
  const turbidity = document.getElementById("turbidity");
  const water = document.getElementById("water");

  // Simulate sensor data updates every 2 seconds
  setInterval(() => {
    const data = {
      dissolvedOxygen: Math.random() * 10,
      ph: 6 + Math.random() * 2,
      temperature: 20 + Math.random() * 10,
      nutrient: Math.random() * 100,
      turbidity: Math.random() * 50,
      waterLevel: Math.random() * 100,
    };

    oxygen.textContent = `${data.dissolvedOxygen.toFixed(1)} mg/L`;
    ph.textContent = `${data.ph.toFixed(1)}`;
    temp.textContent = `${data.temperature.toFixed(1)} °C`;
    nutrient.textContent = `${data.nutrient.toFixed(1)} ppm`;
    turbidity.textContent = `${data.turbidity.toFixed(1)} NTU`;
    water.textContent = `${data.waterLevel.toFixed(1)} %`;
  }, 2000);

