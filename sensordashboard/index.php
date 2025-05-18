<!DOCTYPE html>
<html>
<head>
  <title>Sensor Dashboard</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


  <style>
   
    :root {
    --primary-color: #2563eb;
    --secondary-color: #1e40af;
    --background-color: #f0f2f5;
    --card-bg: #ffffff;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --success-color: #22c55e;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --border-radius: 16px;
    --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --transition: all 0.3s ease;
}   

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: var(--background-color);
    color: var(--text-primary);
    min-height: 100vh;
    line-height: 1.5;
}

.dashboard {
    min-height: 100vh;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(30, 64, 175, 0.05) 100%);
}

.main {
    max-width: 1400px;
    margin: 0 auto;
}

.header.navbar {
    width: 100%;
    background: var(--card-bg);
    box-shadow: 0 2px 8px rgba(30, 64, 175, 0.07);
    padding: 0.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
    border-radius: 0 0 16px 16px;
    margin-bottom: 2rem;
}
.header-title {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}
.header-title h1 {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.header-title p {
    color: var(--text-secondary);
    font-size: 1rem;
    margin: 0;
}
.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.refresh-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.3rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.12);
    transition: background 0.2s, transform 0.2s;
}
.refresh-btn:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}
.refresh-btn i {
    transition: transform 0.5s ease;
    font-size: 1.1rem;
}
@media (max-width: 768px) {
    .header.navbar {
        padding: 0.75rem 1rem;
        flex-direction: column;
        gap: 0.7rem;
        border-radius: 0 0 12px 12px;
    }
    .header-title h1 {
        font-size: 1.1rem;
    }
    .refresh-btn {
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--card-bg);
    padding: 1.75rem;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    display: flex;
    gap: 1.25rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: var(--transition);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
}

.water-clarity { background: linear-gradient(135deg, #4ecdc4, #2cb5e8); }
.water-level { background: linear-gradient(135deg, #45b7d1, #2d8aac); }
.nutrient { background: linear-gradient(135deg, #96c93d, #6b9c1f); }
.temperature { background: linear-gradient(135deg, #ff6b6b, #ee5253); }
.ph-level { background: linear-gradient(135deg, #a8e6cf, #7ac7a6); }
.oxygen { background: linear-gradient(135deg, #3498db, #2980b9); }

.stat-info {
    flex: 1;
}

.stat-info h3 {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.stat-info p {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
    letter-spacing: -0.5px;
}

.stat-range {
    font-size: 0.9rem;
    color: var(--text-secondary);
    padding: 0.5rem 1rem;
    background: rgba(0, 0, 0, 0.03);
    border-radius: 8px;
    display: inline-block;
    font-weight: 500;
    margin-right: 0.5rem;
}

.range-normal {
    background: #e6f9ed;
    color: var(--success-color);
    border: 1px solid #b6f2d6;
}

.range-warning {
    background: #fff7e6;
    color: var(--warning-color);
    border: 1px solid #ffe0a3;
}

.range-danger {
    background: #ffeaea;
    color: var(--danger-color);
    border: 1px solid #ffb3b3;
}

.stat-status {
    font-size: 0.95rem;
    font-weight: 700;
    margin-left: 0.5rem;
    vertical-align: middle;
}

.stat-status.normal { color: var(--success-color); }
.stat-status.warning { color: var(--warning-color); }
.stat-status.danger { color: var(--danger-color); }

@media (max-width: 768px) {
    .dashboard {
        padding: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1.5rem;
    }

    .stat-info p {
        font-size: 1.75rem;
    }
}

/* Add subtle animation for value updates */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.stat-info p.updating {
    animation: pulse 0.5s ease-in-out;
}

.navbar {
    width: 100%;
    background: var(--card-bg);
    box-shadow: 0 2px 8px rgba(30, 64, 175, 0.07);
    padding: 0.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
    border-radius: 0 0 16px 16px;
    
}
.navbar-left {
    display: flex;
    align-items: center;
    gap: 0.7rem;
}
.navbar-logo {
    font-size: 2rem;
    color: var(--primary-color);
    display: flex;
    align-items: center;
}
.navbar-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--primary-color);
    letter-spacing: 1px;
}
.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.navbar .refresh-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.3rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.12);
    transition: background 0.2s, transform 0.2s;
}
.navbar .refresh-btn:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}
.navbar .refresh-btn i {
    transition: transform 0.5s ease;
    font-size: 1.1rem;
}
@media (max-width: 768px) {
    .navbar {
        padding: 0.75rem 1rem;
        flex-direction: column;
        gap: 0.7rem;
        border-radius: 0 0 12px 12px;
    }
    .navbar-title {
        font-size: 1.1rem;
    }
    .navbar-logo {
        font-size: 1.3rem;
    }
    .navbar .refresh-btn {
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }
}
.navbar-status {
  display: flex;
  align-items: center;
  font-weight: 600;
  font-size: 1rem;
  color: var(--primary-color);
}

.status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.status-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: green; /* default green */
  display: inline-block;
}

/* If disconnected, apply this class to #connectionStatus */
.status.disconnected .status-dot {
  background-color: red;
}

.status.connected .status-dot {
  background-color: green;
}


.sensor-info-btn {
    color: var(--secondary-color);
    font-size: 1.1rem;
    margin-left: 0.5rem;
    cursor: pointer;
    transition: color 0.2s;
}
.sensor-info-btn:hover {
    color: var(--primary-color);
}

.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow: auto;
    background: rgba(30, 41, 59, 0.25);
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: #fff;
    margin: 5% auto;
    padding: 2rem 2.5rem;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(30, 41, 59, 0.18);
    max-width: 400px;
    position: relative;
    animation: modalIn 0.2s;
}
@keyframes modalIn {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.close-modal {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    font-size: 1.5rem;
    color: #64748b;
    cursor: pointer;
    transition: color 0.2s;
}
.close-modal:hover {
    color: var(--danger-color);
}
.modal-body p {
    margin: 0.5rem 0;
    font-size: 1.05rem;
}
#modalSensorThresholds {
    margin-top: 1.2rem;
    font-size: 0.98rem;
}

#modalSensorThresholds ul {
    list-style: none;
    padding-left: 0;
    margin: 0.5rem 0 0 0;
}

#modalSensorThresholds li {
    margin-bottom: 0.6rem;
    font-size: 1rem;
}

.current-reading {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    background: var(--card-bg);
    box-shadow: var(--card-shadow);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}
.reading-label {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1.1rem;
}
#lastReadingTime {
    color: var(--text-secondary);
    font-size: 1.05rem;
}

.records-section {
    margin-top: 2.5rem;
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: var(--card-shadow);
    padding: 2rem 1.5rem 1.5rem 1.5rem;
}
.records-title {
    font-size: 1.3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.records-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    font-size: 1rem;
}
.records-table th, .records-table td {
    padding: 0.6rem 0.7rem;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}
.records-table th {
    background: #f3f6fa;
    color: var(--primary-color);
    font-weight: 600;
}
.records-table tr:last-child td {
    border-bottom: none;
}
.pagination-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.2rem;
    margin-top: 0.5rem;
}
.pagination-btn {
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1.2rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}
.pagination-btn:disabled {
    background: #b6c6e6;
    cursor: not-allowed;
}
#pageInfo {
    font-size: 1.05rem;
    color: var(--text-secondary);
}
@media (max-width: 768px) {
    .current-reading {
        padding: 0.7rem 1rem;
        font-size: 1rem;
    }
    .records-section {
        padding: 1rem 0.5rem 1rem 0.5rem;
    }
    .records-title {
        font-size: 1.05rem;
    }
    .records-table th, .records-table td {
        padding: 0.4rem 0.3rem;
        font-size: 0.95rem;
    }
}

/* Control Panel Modern Row Stat Card Style */
.control-panel {
  display: flex;
  flex-direction: row;
  gap: 1.5rem;
  margin: 2.5rem auto 2rem auto;
  max-width: 100%;
  justify-content: flex-end;
}
.control-card {
  background: var(--card-bg);
  border-radius: var(--border-radius);
  box-shadow: var(--card-shadow);
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 1.7rem 1.5rem 1.3rem 1.5rem;
  min-width: 220px;
  flex: 1 1 0;
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  justify-content: space-evenly;
}
.control-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.10);
}
.control-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 2rem;
  box-shadow: 0 4px 8px rgba(37, 99, 235, 0.18);
}
.control-info h3 {
  font-size: 1.1rem;
  color: var(--text-secondary);
  margin-bottom: 0.5rem;
  font-weight: 600;
}
.control-btn {
  background:rgb(5, 175, 53);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-size: 1.08rem;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(56, 249, 215, 0.13);
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  transition: background 0.2s, transform 0.18s, box-shadow 0.18s;
  margin-bottom: 0.5rem;
}
.control-btn:hover {
  background:rgb(198, 18, 18);
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 6px 18px rgba(56, 249, 215, 0.18);
}
.control-btn.active {
  background-color:rgb(198, 18, 18);
  color: white;
}
.status-text {
  font-size: 1rem;
  color: var(--text-secondary);
  margin-top: 0.2rem;
}
.status-text span {
  font-weight: 700;
  color: red;
}

@media (max-width: 1024px) {
  .control-panel {
    gap: 1rem;
  }
  .control-card {
    min-width: 180px;
    padding: 1.2rem 0.7rem 1rem 0.7rem;
  }
}
@media (max-width: 768px) {
  .control-panel {
    flex-direction: column;
    max-width: 100%;
    gap: 1rem;
    margin: 1.2rem 0 1.2rem 0;
  }
  .control-card {
    min-width: unset;
    max-width: unset;
    width: 100%;
    padding: 1rem 0.7rem;
    gap: 0.7rem;
  }
  .control-icon {
    width: 40px;
    height: 40px;
    font-size: 1.3rem;
  }
  .control-info h3 {
    font-size: 1rem;
  }
  .control-btn {
    font-size: 0.98rem;
    padding: 0.5rem 1rem;
  }
  .status-text {
    font-size: 0.95rem;
  }
}

  </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <span class="navbar-logo"><i class="fas fa-fish"></i></span>
        <span class="navbar-title">Aquaponics Monitor</span>
    </div>
    <div class="navbar-status">
  <span id="connectionStatus" class="status connected">
    <span class="status-dot"></span>
    Connected
  </span>
</div>

</nav>
<div class="dashboard">
        <main class="main">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon water-clarity">
                        <i class="fas fa-water"></i>
                    </div>
                    <div class="stat-info">
                        <h3>
                            Turbidity
                            <i class="fas fa-info-circle sensor-info-btn" data-sensor="turbidity"></i>
                        </h3>
                        <p id="turbidity">-- NTU</p>
                        <div class="stat-range"><span class="stat-status"></span></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon nutrient">
                        <i class="fas fa-flask"></i>
                    </div>
                    <div class="stat-info">
                        <h3>
                            Total Dissolved Solids
                            <i class="fas fa-info-circle sensor-info-btn" data-sensor="tds"></i>
                        </h3>
                        <p id="tds">--</p>
                        <div class="stat-range"><span class="stat-status"></span></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon temperature">
                        <i class="fas fa-thermometer-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3>
                            Water Temperature
                            <i class="fas fa-info-circle sensor-info-btn" data-sensor="temp"></i>
                        </h3>
                        <p id="temperature">-- °C</p>
                        <div class="stat-range"><span class="stat-status"></span></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon ph-level">
                        <i class="fas fa-vial"></i>
                    </div>
                    <div class="stat-info">
                        <h3>
                            pH Level
                            <i class="fas fa-info-circle sensor-info-btn" data-sensor="ph"></i>
                        </h3>
                        <p id="ph">--</p>
                        <div class="stat-range"><span class="stat-status"></span></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon oxygen">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div class="stat-info">
                        <h3>
                            Dissolved Oxygen
                            <i class="fas fa-info-circle sensor-info-btn" data-sensor="oxygen"></i>
                        </h3>
                        <p id="oxygen">-- mg/L</p>
                        <div class="stat-range"><span class="stat-status"></span></div>
                    </div>
                </div>
                <div class="control-card">
                    <div class="control-icon">
                        <i class="fas fa-cookie"></i>
                    </div>
                    <div class="control-info">
                        <h3>Fish Feeder</h3>
                        <button class="control-btn" id="feederBtn" onclick="toggleDevice('feeder')">
                            <i class="fas fa-power-off"></i>
                            <span>Turn On</span>
                            </button>
                            <p class="status-text">Status: <span id="feederStatus">Off</span></p>
                    </div>
                </div>

                <div class="control-card">
                    <div class="control-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="control-info">
                        <h3>Water Pump</h3>
                        <button class="control-btn" id="waterPumpBtn" onclick="toggleDevice('waterPump')">
                        <i class="fas fa-power-off"></i>
                            <span>Turn On</span>
                        </button>
                        <p class="status-text">Status: <span id="waterPumpStatus">Off</span></p>
                    </div>
                </div>

                <div class="control-card">
                    <div class="control-icon">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div class="control-info">
                        <h3>Air Pump</h3>
                        <button class="control-btn" id="airPumpBtn" onclick="toggleDevice('airPump')">
                         <i class="fas fa-power-off"></i>
                        <span>Turn On</span>
                        </button>
                        <p class="status-text">Status: <span id="airPumpStatus">Off</span></p>
                    </div>
                </div>
            </div>
            
            <div class="records-section">
                <h2 class="records-title"><i class="fas fa-database"></i> All Records</h2>
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Time</th>
                            <th>Temp</th>
                            <th>TDS</th>
                            <th>Turbidity</th>
                            <th>pH</th>
                            <th>Oxygen</th>
                        </tr>
                    </thead>
                    <tbody id="data-body"></tbody>
                </table>
                <div class="pagination-controls">
                    <button id="prevPage" class="pagination-btn">Previous</button>
                    <span id="pageInfo"></span>
                    <button id="nextPage" class="pagination-btn">Next</button>
                </div>
            </div>
        </main>
    </div>
    <div id="sensorModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 id="modalSensorName"></h2>
        <div class="modal-body">
            <p><strong>Model:</strong> <span id="modalSensorModel"></span></p>
            <p><strong>Detects:</strong> <span id="modalSensorDetect"></span></p>
            <div id="modalSensorThresholds"></div>
        </div>
    </div>
</div>

  <script>
document.querySelectorAll('.navbar-logo, .navbar-title').forEach(element => {
  element.style.cursor = 'pointer'; // show pointer on hover
  element.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});
// Suppose you get connection status from your API
function updateConnectionStatus(isConnected) {
  const statusElem = document.getElementById('connectionStatus');
  if (isConnected) {
    statusElem.textContent = 'Connected';
    statusElem.classList.remove('disconnected');
    statusElem.classList.add('connected');
  } else {
    statusElem.textContent = 'Disconnected';
    statusElem.classList.remove('connected');
    statusElem.classList.add('disconnected');
  }

  // Add the dot span again since textContent resets content
  const dot = document.createElement('span');
  dot.className = 'status-dot';
  statusElem.prepend(dot);
}


const sensorDetails = {
    turbidity: {
        name: "Turbidity",
        model: "TurbSensor-100",
        detects: "Water clarity using NTU",
        thresholds: [
            { level: "Good", range: "0-5 NTU" },
            { level: "Moderate", range: "5-10 NTU" },
            { level: "Poor", range: "10+ NTU" }
        ]
    },
    tds: {
        name: "Total Dissolved Solids",
        model: "TDSSensor-X2",
        detects: "Minerals, salts, and impurities",
        thresholds: [
            { level: "Good", range: "0-300 ppm" },
            { level: "Moderate", range: "300-600 ppm" },
            { level: "Poor", range: "600+ ppm" }
        ]
    },
    temp: {
        name: "Water Temperature",
        model: "TempPro-V5",
        detects: "Water temperature in °C",
        thresholds: [
            { level: "Optimal", range: "20-28 °C" },
            { level: "Caution", range: "28-32 °C" },
            { level: "Danger", range: "32+ °C" }
        ]
    },
    ph: {
        name: "pH Level",
        model: "PHMeter-A1",
        detects: "Acidity or alkalinity of water",
        thresholds: [
            { level: "Ideal", range: "6.5-8.5" },
            { level: "Acidic", range: "< 6.5" },
            { level: "Basic", range: "> 8.5" }
        ]
    },
    oxygen: {
        name: "Dissolved Oxygen",
        model: "OxySense-M3",
        detects: "Oxygen levels in mg/L",
        thresholds: [
            { level: "Good", range: "6-9 mg/L" },
            { level: "Moderate", range: "4-6 mg/L" },
            { level: "Low", range: "< 4 mg/L" }
        ]
    }
};

const infoButtons = document.querySelectorAll(".sensor-info-btn");
const modal = document.getElementById("sensorModal");
const closeModalBtn = document.querySelector(".close-modal");

const sensorName = document.getElementById("modalSensorName");
const sensorModel = document.getElementById("modalSensorModel");
const sensorDetect = document.getElementById("modalSensorDetect");
const sensorThresholds = document.getElementById("modalSensorThresholds");

infoButtons.forEach(button => {
    button.addEventListener("click", () => {
        const sensorKey = button.getAttribute("data-sensor");
        const data = sensorDetails[sensorKey];

        if (data) {
            sensorName.textContent = data.name;
            sensorModel.textContent = data.model;
            sensorDetect.textContent = data.detects;

            // Ayusin ang thresholds gamit ang tamang template literal
            const thresholdList = data.thresholds.map(thresh =>
                `<li><strong>${thresh.level}:</strong> ${thresh.range}</li>`
            ).join("");

            sensorThresholds.innerHTML = `<p><strong>Thresholds:</strong></p><ul>${thresholdList}</ul>`;

            modal.style.display = "block";
        }
    });
});

closeModalBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});
const deviceStates = {
    feeder: false,
    waterPump: false,
    airPump: false
  };

  function toggleDevice(device) {
    // Toggle state
    deviceStates[device] = !deviceStates[device];

    // Get the button and status span
    const button = document.getElementById(`${device}Btn`);
    const statusSpan = document.getElementById(`${device}Status`);

    if (button && statusSpan) {
      const isOn = deviceStates[device];
      button.querySelector("span").textContent = isOn ? "Turn Off" : "Turn On";
      statusSpan.textContent = isOn ? "On" : "Off";
      button.classList.toggle("active", isOn);

      // Change status color green/red
      statusSpan.style.color = isOn ? "green" : "red";
    } else {
      console.error("Missing button or status span for", device);
    }
  }

function toCamelCase(text) {
  return text.replace(/_([a-z])/g, g => g[1].toUpperCase());
}
    function updateDashboardValue(id, value, unit = '') {
      const element = document.getElementById(id);
      if (element) {
        element.textContent = value ? `${value}${unit}` : `-- ${unit}`;
        element.classList.add('updating');
        setTimeout(() => element.classList.remove('updating'), 500);
      }
    }

    function updateTable(tableData) {
      const tbody = document.getElementById("data-body");
      tbody.innerHTML = tableData.map(row => `
        <tr data-id="${row.id}">
          <td>${row.id}</td>
          <td>${row.reading_time}</td>
          <td>${row.temperature}</td>
          <td>${row.tds}</td>
          <td>${row.turbidity}</td>
          <td>${row.ph}</td>
          <td>${row.oxygen}</td>
        </tr>
      `).join('');
    }

    function fetchData() {
      fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error('Error:', data.error);
            return;
          }

          // Update stat cards with latest readings
          const latest = data.latest;
          updateDashboardValue("temperature", latest.temperature, " °C");
          updateDashboardValue("tds", latest.tds);
          updateDashboardValue("turbidity", latest.turbidity, " NTU");
          updateDashboardValue("ph", latest.ph);
          updateDashboardValue("oxygen", latest.oxygen, " mg/L");

          // Update the table
          updateTable(data.tableData);
        })
        .catch(error => {
          console.error('Error fetching sensor data:', error);
        });
    }

    // Initial fetch and then every 5 seconds
    fetchData();
    setInterval(fetchData, 5000);

    // Add FontAwesome for icons
    const fontAwesome = document.createElement('link');
    fontAwesome.rel = 'stylesheet';
    fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
    document.head.appendChild(fontAwesome);
  </script>
</body>
</html>

