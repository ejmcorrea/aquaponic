document.addEventListener('DOMContentLoaded', () => {
    const refreshBtn = document.querySelector('.refresh-btn');
    
    // Helper: get status and class for each stat
    function getStatusAndClass(id, value) {
        switch(id) {
            case 'turbidity':
                if (value < 10) return {text: 'Normal', cls: 'normal'};
                if (value < 15) return {text: 'High', cls: 'warning'};
                return {text: 'Contaminated', cls: 'danger'};
            case 'level':
                if (value >= 80 && value <= 90) return {text: 'Normal', cls: 'normal'};
                if ((value >= 75 && value < 80) || (value > 90 && value <= 95)) return {text: 'Low', cls: 'warning'};
                return {text: 'Critical', cls: 'danger'};
            case 'nutrient': // TDS
                if (value >= 100 && value <= 140) return {text: 'Normal', cls: 'normal'};
                if ((value >= 90 && value < 100) || (value > 140 && value <= 160)) return {text: 'High', cls: 'warning'};
                return {text: 'Contaminated', cls: 'danger'};
            case 'temp':
                if (value >= 20 && value <= 25) return {text: 'Normal', cls: 'normal'};
                if ((value >= 18 && value < 20) || (value > 25 && value <= 27)) return {text: 'Low', cls: 'warning'};
                return {text: 'Critical', cls: 'danger'};
            case 'ph':
                if (value >= 6.8 && value <= 7.2) return {text: 'Normal', cls: 'normal'};
                if ((value >= 6.5 && value < 6.8) || (value > 7.2 && value <= 7.5)) return {text: 'Weak', cls: 'warning'};
                return {text: 'Strong', cls: 'danger'};
            case 'oxygen':
                if (value >= 6) return {text: 'Normal', cls: 'normal'};
                if (value >= 5) return {text: 'Low', cls: 'warning'};
                return {text: 'Critical', cls: 'danger'};
            default:
                return {text: '', cls: ''};
        }
    }

    // Refresh button animation and functionality
    refreshBtn.addEventListener('click', () => {
        const icon = refreshBtn.querySelector('i');
        icon.style.transform = 'rotate(360deg)';
        refreshBtn.disabled = true;
        refreshBtn.style.opacity = '0.7';
        
        updateSensorValues();
        
        setTimeout(() => {
            icon.style.transform = 'rotate(0deg)';
            refreshBtn.disabled = false;
            refreshBtn.style.opacity = '1';
        }, 500);
    });

    // Random value generator within range
    function getRandomValue(min, max, decimals = 1) {
        return (Math.random() * (max - min) + min).toFixed(decimals);
    }

    // Animate value change with color indication
    function animateValue(element, start, end, duration, unit = '') {
        if (isNaN(start)) start = 0;
        const range = end - start;
        const increment = range / (duration / 10);
        let current = start;
        
        // Add updating class for pulse animation
        element.classList.add('updating');
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment >= 0 && current >= end) || (increment < 0 && current <= end)) {
                clearInterval(timer);
                current = end;
                // Remove updating class after animation
                setTimeout(() => {
                    element.classList.remove('updating');
                }, 500);
            }
            element.textContent = current.toFixed(1) + unit;
            
            // Color indication based on optimal ranges
            const value = parseFloat(current.toFixed(1));
            let color = '#1e293b'; // default color
            
            switch(element.id) {
                case 'turbidity':
                    color = value < 10 ? '#22c55e' : (value < 15 ? '#f59e0b' : '#ef4444');
                    break;
                case 'level':
                    color = (value >= 80 && value <= 90) ? '#22c55e' : ((value >= 75 && value < 80) || (value > 90 && value <= 95)) ? '#f59e0b' : '#ef4444';
                    break;
                case 'nutrient':
                    color = (value >= 100 && value <= 140) ? '#22c55e' : ((value >= 90 && value < 100) || (value > 140 && value <= 160)) ? '#f59e0b' : '#ef4444';
                    break;
                case 'temp':
                    color = (value >= 20 && value <= 25) ? '#22c55e' : ((value >= 18 && value < 20) || (value > 25 && value <= 27)) ? '#f59e0b' : '#ef4444';
                    break;
                case 'ph':
                    color = (value >= 6.8 && value <= 7.2) ? '#22c55e' : ((value >= 6.5 && value < 6.8) || (value > 7.2 && value <= 7.5)) ? '#f59e0b' : '#ef4444';
                    break;
                case 'oxygen':
                    color = value >= 6 ? '#22c55e' : (value >= 5 ? '#f59e0b' : '#ef4444');
                    break;
            }
            element.style.color = color;
            // Stat range and status
            const statCard = element.closest('.stat-card');
            const statRange = statCard.querySelector('.stat-range');
            const statStatus = statCard.querySelector('.stat-status');
            const status = getStatusAndClass(element.id, value);
          
            statStatus.className = 'stat-status ' + status.cls;
            statStatus.textContent = status.text;
        }, 10);
    }

    // Update sensor values with animation
    function updateSensorValues() {
        // Turbidity (0-10 NTU is good)
        const turbidityValue = getRandomValue(2, 12);
        animateValue(document.getElementById('turbidity'), 
            parseFloat(document.getElementById('turbidity').textContent), 
            turbidityValue, 
            1000,
            ' NTU'
        );

        // Water Level (80-90% is optimal)
        const levelValue = getRandomValue(75, 95);
        animateValue(document.getElementById('level'),
            parseFloat(document.getElementById('level').textContent),
            levelValue,
            1000,
            ' %'
        );

        // Nutrient Level (100-140 mg/L is optimal)
        const nutrientValue = getRandomValue(90, 160);
        animateValue(document.getElementById('nutrient'),
            parseFloat(document.getElementById('nutrient').textContent),
            nutrientValue,
            1000,
            ' ppm'
        );

        // Water Temperature (20-25°C is optimal)
        const tempValue = getRandomValue(18, 27);
        animateValue(document.getElementById('temp'),
            parseFloat(document.getElementById('temp').textContent),
            tempValue,
            1000,
            ' °C'
        );

        // pH Level (6.8-7.2 is optimal)
        const phValue = getRandomValue(6.5, 7.5);
        animateValue(document.getElementById('ph'),
            parseFloat(document.getElementById('ph').textContent) || 6.8,
            phValue,
            1000,
            ''
        );

        // Dissolved Oxygen (>6 mg/L is optimal)
        const oxygenValue = getRandomValue(5, 9);
        animateValue(document.getElementById('oxygen'),
            parseFloat(document.getElementById('oxygen').textContent),
            oxygenValue,
            1000,
            ' mg/L'
        );
    }

    // Initial values
    updateSensorValues();

    // Update values periodically
    setInterval(updateSensorValues, 5000);

    // Add hover effects to cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.1)';
        });

        card.addEventListener('mouseout', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
        });
    });

    // Sensor info data
    const sensorInfo = {
        turbidity: {
            name: 'Turbidity Sensor',
            model: 'TSD-10',
            detects: 'Water Turbidity (cloudiness)',
            thresholds: [
                { label: 'Not Safe (Contaminated)', value: '≥ 15 NTU', color: 'danger' },
                { label: 'High', value: '10 - 14.9 NTU', color: 'warning' },
                { label: 'Ideal', value: '< 10 NTU', color: 'normal' }
            ]
        },
        level: {
            name: 'Water Level Sensor',
            model: 'WLS-200',
            detects: 'Water Level (%)',
            thresholds: [
                { label: 'Not Safe', value: '< 75% or > 95%', color: 'danger' },
                { label: 'Not Ideal', value: '75-79% or 91-95%', color: 'warning' },
                { label: 'Ideal', value: '80-90%', color: 'normal' }
            ]
        },
        tds: {
            name: 'TDS Sensor',
            model: 'TDS-3',
            detects: 'Total Dissolved Solids (ppm)',
            thresholds: [
                { label: 'Contaminated', value: '< 90 or > 160 ppm', color: 'danger' },
                { label: 'High', value: '141-160 ppm', color: 'warning' },
                { label: 'Ideal', value: '100-140 ppm', color: 'normal' },
                { label: 'Low', value: '90-99 ppm', color: 'warning' }
            ]
        },
        temp: {
            name: 'Water Temperature Sensor',
            model: 'DS18B20',
            detects: 'Water Temperature (°C)',
            thresholds: [
                { label: 'Not Safe', value: '< 18°C or > 27°C', color: 'danger' },
                { label: 'Not Ideal', value: '18-19.9°C or 25.1-27°C', color: 'warning' },
                { label: 'Ideal', value: '20-25°C', color: 'normal' }
            ]
        },
        ph: {
            name: 'pH Sensor',
            model: 'PH-4502C',
            detects: 'pH Level',
            thresholds: [
                { label: 'Strong', value: '< 6.5 or > 7.5', color: 'danger' },
                { label: 'Weak', value: '6.5-6.79 or 7.21-7.5', color: 'warning' },
                { label: 'Ideal', value: '6.8-7.2', color: 'normal' }
            ]
        },
        oxygen: {
            name: 'Dissolved Oxygen Sensor',
            model: 'DO-510',
            detects: 'Dissolved Oxygen (mg/L)',
            thresholds: [
                { label: 'Critical', value: '< 5 mg/L', color: 'danger' },
                { label: 'Low', value: '5-5.99 mg/L', color: 'warning' },
                { label: 'Ideal', value: '≥ 6 mg/L', color: 'normal' }
            ]
        }
    };

    // Modal logic
    const modal = document.getElementById('sensorModal');
    const modalName = document.getElementById('modalSensorName');
    const modalModel = document.getElementById('modalSensorModel');
    const modalDetect = document.getElementById('modalSensorDetect');
    const modalThresholds = document.getElementById('modalSensorThresholds');
    const closeModalBtn = document.querySelector('.close-modal');

    document.querySelectorAll('.sensor-info-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const key = btn.getAttribute('data-sensor');
            const info = sensorInfo[key];
            if (!info) return;
            modalName.textContent = info.name;
            modalModel.textContent = info.model;
            modalDetect.textContent = info.detects;
            // Thresholds
            let html = '<strong>Thresholds:</strong><ul>';
            info.thresholds.forEach(t => {
                html += `<li style="color: var(--${t.color}-color); font-weight: 600;">${t.label}: <span style="font-weight:400; color:#222;">${t.value}</span></li>`;
            });
            html += '</ul>';
            modalThresholds.innerHTML = html;
            modal.style.display = 'flex';
        });
    });
    closeModalBtn.onclick = () => { modal.style.display = 'none'; };
    window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

    // --- Records Table & Last Reading Logic ---
    const recordsPerPage = 5;
    let records = [];
    let currentPage = 1;

    // Generate sample data (10 records)
    function generateSampleRecords() {
        const now = new Date();
        const arr = [];
        for (let i = 0; i < 10; i++) {
            const d = new Date(now.getTime() - i * 60000);
            arr.push({
                time: d.toLocaleString(),
                turbidity: (Math.random() * 15).toFixed(1),
                level: (75 + Math.random() * 20).toFixed(1),
                tds: (90 + Math.random() * 70).toFixed(0),
                temp: (18 + Math.random() * 9).toFixed(1),
                ph: (6.5 + Math.random() * 1).toFixed(2),
                oxygen: (5 + Math.random() * 4).toFixed(2)
            });
        }
        return arr;
    }
    records = generateSampleRecords();

    function renderRecordsTable() {
        const tbody = document.getElementById('recordsTableBody');
        tbody.innerHTML = '';
        const start = (currentPage - 1) * recordsPerPage;
        const end = Math.min(start + recordsPerPage, records.length);
        for (let i = start; i < end; i++) {
            const r = records[i];
            tbody.innerHTML += `<tr>
                <td>${i + 1}</td>
                <td>${r.time}</td>
                <td>${r.turbidity} NTU</td>
                <td>${r.level} %</td>
                <td>${r.tds} ppm</td>
                <td>${r.temp} °C</td>
                <td>${r.ph}</td>
                <td>${r.oxygen} mg/L</td>
            </tr>`;
        }
        document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${Math.ceil(records.length / recordsPerPage)}`;
        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = end >= records.length;
    }

    // Update sensor cards with latest record
    function updateSensorCardsFromLatest() {
        if (!records.length) return;
        const latest = records[0];
        // Map: id in HTML => key in record
        const map = {
            turbidity: 'turbidity',
            level: 'level',
            nutrient: 'tds',
            temp: 'temp',
            ph: 'ph',
            oxygen: 'oxygen'
        };
        Object.entries(map).forEach(([id, key]) => {
            const el = document.getElementById(id);
            if (!el) return;
            let value = latest[key];
            let unit = '';
            if (id === 'turbidity') unit = ' NTU';
            if (id === 'level') unit = ' %';
            if (id === 'nutrient') unit = ' ppm';
            if (id === 'temp') unit = ' °C';
            if (id === 'oxygen') unit = ' mg/L';
            el.textContent = value + unit;
            // Update status color and text
            const statCard = el.closest('.stat-card');
            const statStatus = statCard.querySelector('.stat-status');
            const status = getStatusAndClass(id, parseFloat(value));
            statStatus.className = 'stat-status ' + status.cls;
            statStatus.textContent = status.text;
            el.style.color = status.cls === 'normal' ? '#22c55e' : status.cls === 'warning' ? '#f59e0b' : '#ef4444';
        });
    }

    // Call this after rendering records and on load
    renderRecordsTable();
    updateLastReadingTime();
    updateSensorCardsFromLatest();

    // Also update cards when paginating (simulate live update)
    document.getElementById('prevPage').onclick = () => {
        if (currentPage > 1) {
            currentPage--;
            renderRecordsTable();
            updateSensorCardsFromLatest();
        }
    };
    document.getElementById('nextPage').onclick = () => {
        if (currentPage * recordsPerPage < records.length) {
            currentPage++;
            renderRecordsTable();
            updateSensorCardsFromLatest();
        }
    };

    // Update last reading time
    function updateLastReadingTime() {
        if (records.length > 0) {
            document.getElementById('lastReadingTime').textContent = records[0].time;
        }
    }

    function randomValue(id) {
        switch(id) {
            case 'turbidity': return (Math.random() * 15).toFixed(1);
            case 'level': return (75 + Math.random() * 20).toFixed(1);
            case 'nutrient': return (90 + Math.random() * 70).toFixed(0);
            case 'temp': return (18 + Math.random() * 9).toFixed(1);
            case 'ph': return (6.5 + Math.random() * 1).toFixed(2);
            case 'oxygen': return (5 + Math.random() * 4).toFixed(2);
            default: return '--';
        }
    }

    function updateAllSensorCards() {
        const map = {
            turbidity: {unit: ' NTU'},
            level: {unit: ' %'},
            nutrient: {unit: ' ppm'},
            temp: {unit: ' °C'},
            ph: {unit: ''},
            oxygen: {unit: ' mg/L'}
        };
        Object.entries(map).forEach(([id, meta]) => {
            const el = document.getElementById(id);
            if (!el) return;
            const value = randomValue(id);
            el.textContent = value + meta.unit;
            // Status
            const statCard = el.closest('.stat-card');
            const statStatus = statCard.querySelector('.stat-status');
            const status = getStatusAndClass(id, parseFloat(value));
            statStatus.className = 'stat-status ' + status.cls;
            statStatus.textContent = status.text;
            el.style.color = status.cls === 'normal' ? '#22c55e' : status.cls === 'warning' ? '#f59e0b' : '#ef4444';
        });
    }

    updateAllSensorCards();
    setInterval(updateAllSensorCards, 4000);
});
