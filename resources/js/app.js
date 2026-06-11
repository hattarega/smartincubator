import './bootstrap';
window.Echo.channel('sensor-channel')
    .listen('SensorUpdated', (e) => {
        console.log('Realtime masuk:', e);

        document.getElementById('suhu').innerText = e.data.suhu;
    });
