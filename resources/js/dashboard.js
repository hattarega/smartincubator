function updateDateTime() {
    const el = document.getElementById("datetime");
    if (!el) return;

    const now = new Date();

    const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });

    const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    el.innerText = `${date} - ${time}`;
}

document.addEventListener("DOMContentLoaded", function() {
    updateDateTime();
    setInterval(updateDateTime, 1000);
});

Echo.channel('sensor.' + window.APP_DATA.cageId)
    .listen('SensorUpdated', (e) => {
        document.getElementById('dht11-temp').innerText = e.data.temperature_dht11 + '°C';
    });

function toggleActuator(id) {
    fetch('/actuator/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.APP_DATA.csrf
        },
        body: JSON.stringify({ id })
    })
}

setTimeout(() => {
        const alert = document.getElementById('floatingAlert');
        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 2000);