<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kandang Telur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        :root {
            --bg: #FFFDF8;
            --card: #ffffffcc;
            --border: #F3EDE1;

            --primary: #F59E0B;
            --primary-dark: #D97706;

            --temp: #FDBA74;
            /* orange soft */
            --hum: #7DD3FC;
            /* sky blue soft */

            --success: #6EE7B7;
            /* green soft */
            --danger: #FCA5A5;
            /* red soft */

            --text: #3A3128;
            --muted: #8B7E74;
        }

        body {
            background:
                radial-gradient(circle at top left, #FFF7E6 0%, transparent 30%),
                radial-gradient(circle at top right, #EFF8FF 0%, transparent 30%),
                var(--bg);

            font-family: 'Segoe UI', sans-serif;
            color: var(--text);
            min-height: 100vh;
        }

        .dashboard-title {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 4px;
        }

        .dashboard-subtitle {
            color: var(--muted);
            font-size: 14px;
        }

        .card-custom {
            background: var(--card);
            backdrop-filter: blur(14px);

            border: 1px solid var(--border);

            border-radius: 22px;

            box-shadow:
                0 8px 25px rgba(0, 0, 0, .04);

            transition: .25s;
        }

        .card-custom:hover {
            transform: translateY(-3px);
        }

        .metric-title {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .metric-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .metric-sub {
            font-size: 12px;
            color: var(--muted);
        }

        .sensor-icon {
            width: 40px;
            height: 40px;

            border-radius: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
            color: white;
        }

        .temp-bg {
            background: linear-gradient(135deg,
                    #FB923C,
                    #F97316);
        }

        .hum-bg {
            background: linear-gradient(135deg,
                    #38BDF8,
                    #0284C7);
        }

        .edit-btn-modern {
            position: absolute;

            top: 20px;
            right: 20px;

            width: 28px;
            height: 28px;

            border: none;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(248, 248, 213, 0.9);
            color: #8b7e74;

            font-size: 11px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);

            z-index: 10;

            transition: .2s;
        }

        .edit-btn-modern:hover {
            background: #f59e0b;
            color: white;
            transform: scale(1.08);
        }

        .toggle {
            width: 50px;
            height: 26px;

            background: #E7E5E4;
            border-radius: 50px;

            position: relative;
            cursor: pointer;

            transition: .3s;
        }

        .toggle::after {
            content: '';

            width: 20px;
            height: 20px;

            background: white;
            border-radius: 50%;

            position: absolute;

            top: 3px;
            left: 4px;

            transition: .3s;
        }

        .toggle.active {
            background: var(--success);
        }

        .toggle.active::after {
            left: 26px;
        }

        .status-on {
            color: var(--success);
            font-weight: 700;
        }

        .status-off {
            color: var(--danger);
            font-weight: 700;
        }

        .section-title {
            font-weight: 700;
            font-size: 18px;
        }

        .chart-card {
            min-height: 420px;
        }

        canvas {
            margin-top: 20px;
        }

        .auto-chip {
            width: 34px;
            height: 34px;

            border: none;
            border-radius: 50%;
        }

        @media(max-width:768px) {

            .dashboard-title {
                font-size: 22px;
            }

            .metric-value {
                font-size: 22px;
            }
        }

        .sensor-header {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 42px;
            margin-bottom: 12px;
        }

        .sensor-header .sensor-icon {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .sensor-header .edit-btn-modern {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .sensor-title {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);

            margin: 0;
            font-weight: 600;
            white-space: nowrap;
            text-align: center;
        }

        .actuator-icon-wrapper {
            width: 52px;
            height: 52px;
            margin: 0 auto 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50px;
            background: #f8fafc;
        }

        .actuator-main-icon {
            font-size: 24px;
            color: #000000;
        }

        /* aktif */
        /* .card-custom:has(.toggle.active) .actuator-icon-wrapper {
            background: #dbeafe;
        }

        .card-custom:has(.toggle.active) .actuator-main-icon {
            color: #2563eb;
        } */

        @media (max-width: 576px) {

            .sensor-title {
                font-size: .85rem;
            }

            .sensor-header {
                height: 38px;
            }

            .sensor-header .edit-btn-modern {
                width: 28px;
                height: 28px;
                font-size: .75rem;
            }
        }
    </style>

    @vite('resources/js/app.js')
</head>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function toggleActuator(id) {
        fetch('/actuator/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('toggle success', data);
            });
    }

    function setAuto(id) {
        fetch('/actuator/auto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('auto mode', data);
            });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // =========================
        // JAM REALTIME
        // =========================
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

        updateDateTime();
        setInterval(updateDateTime, 1000);


        // =========================
        // ALERT AUTO HIDE
        // =========================
        setTimeout(() => {
            const alert = document.getElementById('floatingAlert');
            if (alert) {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);


        // =========================
        // ECHO (REALTIME)
        // =========================
        if (typeof Echo !== 'undefined') {

            Echo.channel('sensor.{{ $latest->cage_id ?? 1 }}')
                .subscribed(() => console.log('✅ SENSOR CONNECTED'))
                .listen('.sensor.updated', (e) => {

                    console.log('🔥 SENSOR EVENT:', e);

                    const dht11Temp = document.getElementById('dht11-temp');
                    const dht11Hum = document.getElementById('dht11-hum');
                    const dht22Temp = document.getElementById('dht22-temp');
                    const dht22Hum = document.getElementById('dht22-hum');

                    if (dht11Temp) dht11Temp.innerText = e.data.temperature_dht11 + '°C';
                    if (dht11Hum) dht11Hum.innerText = e.data.humidity_dht11 + '%';

                    if (dht22Temp) dht22Temp.innerText = e.data.temperature_dht22 + '°C';
                    if (dht22Hum) dht22Hum.innerText = e.data.humidity_dht22 + '%';
                });


            Echo.channel('actuator.{{ $cage->id }}')
                .subscribed(() => console.log('✅ ACTUATOR CONNECTED'))
                .listen('.actuator.updated', (e) => {

                    let a = e.actuator;

                    let toggle = document.getElementById(`toggle-${a.id}`);
                    if (toggle) {
                        toggle.classList.toggle('active', a.state === 'ON');
                    }

                    let status = document.getElementById(`status-${a.id}`);
                    if (status) {
                        status.innerText = a.state;
                        status.className = a.state === 'ON' ? 'status-on' : 'status-off';
                    }
                    let autoBtn = document.getElementById(`auto-btn-${a.id}`);
                    let autoIcon = document.getElementById(`auto-icon-${a.id}`);
                    if (autoBtn) autoBtn.style.background = a.mode === 'AUTO' ? '#dbeafe' : '#f3f4f6';
                    if (autoIcon) autoIcon.style.color = a.mode === 'AUTO' ? '#3b82f6' : '#9ca3af';

                    console.log('🔥 ACTUATOR EVENT:', e);
                });

        } else {
            console.error('❌ Echo belum dimuat (cek Vite & bootstrap.js)');
        }


        // =========================
        // CHART
        // =========================
        let chart;

        function loadChart(date = null) {
            fetch(`/chart-data?date=${date ?? ''}`)
                .then(res => res.json())
                .then(data => {

                    let labels = [];
                    let dht11Temp = [],
                        dht22Temp = [];
                    let dht11Hum = [],
                        dht22Hum = [];

                    let filtered = data.filter(item => {
                        let d = new Date(item.created_at);
                        return d.getMinutes() === 0 || d.getMinutes() === 30;
                    });

                    let grouped = {};

                    filtered.forEach(item => {
                        let d = new Date(item.created_at);
                        let key = d.getHours().toString().padStart(2, '0') + ':' +
                            d.getMinutes().toString().padStart(2, '0');

                        if (!grouped[key]) {
                            grouped[key] = {
                                dht11: {},
                                dht22: {}
                            };
                        }

                        if (item.type === 'dht11') {
                            grouped[key].dht11 = item;
                        } else {
                            grouped[key].dht22 = item;
                        }
                    });

                    Object.keys(grouped).forEach(time => {
                        labels.push(time);

                        dht11Temp.push(grouped[time].dht11.temperature ?? null);
                        dht22Temp.push(grouped[time].dht22.temperature ?? null);
                        dht11Hum.push(grouped[time].dht11.humidity ?? null);
                        dht22Hum.push(grouped[time].dht22.humidity ?? null);
                    });

                    if (chart) chart.destroy();

                    const canvas = document.getElementById('sensorChart');
                    if (!canvas) return;

                    chart = new Chart(canvas, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                    label: 'DHT11 Temp',
                                    data: dht11Temp,
                                    borderColor: 'red',
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'DHT22 Temp',
                                    data: dht22Temp,
                                    borderColor: 'orange',
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'DHT11 Hum',
                                    data: dht11Hum,
                                    borderColor: 'blue',
                                    yAxisID: 'y1'
                                },
                                {
                                    label: 'DHT22 Hum',
                                    data: dht22Hum,
                                    borderColor: 'green',
                                    yAxisID: 'y1'
                                }
                            ]
                        }
                    });

                });
        }

        loadChart();

        // ✅ FIX ERROR addEventListener NULL
        const filter = document.getElementById('filter-date');
        if (filter) {
            filter.addEventListener('change', function() {
                loadChart(this.value);
            });
        }

    });
</script>


<body>

    <div class="container-fluid p-3 p-md-4">

        @if (session('success'))
            <div id="floatingAlert" class="alert alert-success shadow-sm"
                style="
           position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 800px;
            font-size: 14px;
            padding: 12px 20px;
            z-index: 9999;
            border-radius: 10px;
         ">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="row g-3 mb-3">

            <div class="col-12 col-lg-6">
                <div class="card card-custom p-3 h-100">
                    <div>
                        <div class="dashboard-title">
                            🥚 Smart Duck Incubator
                        </div>

                        <div class="dashboard-subtitle">
                            Monitoring suhu, kelembapan, dan aktuator realtime
                        </div>

                        <small id="datetime"></small>
                    </div>
                    <small class="text-muted" id="datetime"></small>
                </div>
            </div>

            <div class="col-4 col-lg-2">
                <div class="card card-custom p-3 h-100 position-relative">
                    <small>Hari ke</small>
                    @if ($cage)
                        <h4>{{ floor($day) }}</h4>
                        <small>
                            Dibuat pada
                            {{ \Carbon\Carbon::parse($cage->start_date)->translatedFormat('d/m/Y') }}
                        </small>
                    @else
                        <h4>-</h4>
                        <small>Belum ada kandang</small>
                    @endif

                    <button class="edit-btn-modern" data-bs-toggle="modal" data-bs-target="#modalTanggalKandang">
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>
            </div>

            <div class="col-4 col-lg-2">
                <div class="card card-custom p-3 h-100 position-relative">

                    <button class="edit-btn-modern" data-bs-toggle="modal" data-bs-target="#modalJumlahTelur">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <small>Jumlah Telur</small>
                    <h4>{{ $cage->egg_count ?? 0 }}</h4>



                </div>
            </div>

            <div class="col-4 col-lg-2">
                <div class="card card-custom p-3 h-100 position-relative">
                    <small>Perputaran</small>
                    <h4>6</h4>
                </div>
            </div>

        </div>

        <!-- Sensor & Control -->
        <div class="row g-3 mb-3">

            <div class="col-6 col-lg-3">
                <div class="card card-custom p-3 h-100 position-relative">
                    <!-- Header -->
                    <div class="sensor-header mb-2">

                        <div class="sensor-icon temp-bg">
                            <i class="bi bi-thermometer-half"></i>
                        </div>

                        <h6 class="sensor-title mb-0">Suhu</h6>

                        <button class="edit-btn-modern" data-bs-toggle="modal" data-bs-target="#modalSuhu">
                            <i class="bi bi-pencil"></i>
                        </button>

                    </div>

                    <!-- DHT11 -->
                    <div class="row text-center">
                        <div class="col-6 border-end pe-2">
                            <small>DHT11</small>
                            <h5 id="dht11-temp">{{ $latest->temperature_dht11 ?? '-' }}°C</h5>
                        </div>
                        <div class="col-6 ps-2">
                            <small>DHT22</small>
                            <h5 id="dht22-temp">{{ $latest->temperature_dht22 ?? '-' }}°C</h5>
                        </div>
                    </div>

                    <small>Batas tinggi suhu {{ optional($cage->setting)->max_temperature ?? '-' }} °C</small>

                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card card-custom p-3 h-100 position-relative">
                    <!-- Header -->
                    <div class="sensor-header mb-2">

                        <div class="sensor-icon hum-bg">
                            <i class="bi bi-droplet-half"></i>
                        </div>
                        <h6 class="sensor-title mb-0">Kelembapan</h6>
                        <button class="edit-btn-modern" data-bs-toggle="modal" data-bs-target="#modalKelembapan">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>

                    <!-- DHT11 -->
                    <div class="row text-center">
                        <div class="col-6 border-end pe-2">
                            <small>DHT11</small>
                            <h5 id="dht11-hum">{{ $latest->humidity_dht11 ?? '-' }}%</h5>
                        </div>
                        <div class="col-6 ps-2">
                            <small>DHT22</small>
                            <h5 id="dht22-hum">{{ $latest->humidity_dht22 ?? '-' }}%</h5>
                        </div>
                    </div>
                    <small>Batas rendah kelembapan {{ optional($cage->setting)->min_humidity ?? '-' }} %</small>


                </div>
            </div>

            {{-- <div class="col-4 col-lg-2">
                <div class="card card-custom text-center p-3 h-100">
                    <h6>Kipas</h6>
                    <div class="toggle active"></div>
                </div>
            </div> --}}

            @foreach ($actuators as $actuator)
                @php
                    $icons = [
                        'lampu' => 'bi-lightbulb-fill',
                        'mistmaker' => 'bi-cloud-fog2-fill',
                    ];

                    $icon = $icons[strtolower($actuator->name)] ?? 'bi-cpu-fill';
                @endphp

                <div class="col-6 col-lg-3">
                    <div class="card card-custom text-center p-3 h-100 position-relative">

                        <!-- AUTO BUTTON -->
                        <button onclick="setAuto({{ $actuator->id }})" id="auto-btn-{{ $actuator->id }}"
                            title="Mode Auto" class="btn btn-sm position-absolute top-0 end-0 m-2 rounded-circle"
                            style="width:30px; height:30px; padding:0; z-index:2; border:none;background: {{ $actuator->mode == 'AUTO' ? '#dbeafe' : '#f3f4f6' }};"
                            id="auto-{{ $actuator->id }}">
                            <i class="bi bi-cpu-fill" id="auto-icon-{{ $actuator->id }}"
                                style="font-size:13px; color: {{ $actuator->mode == 'AUTO' ? '#3b82f6' : '#9ca3af' }}">
                            </i>
                        </button>

                        <div class="actuator-icon-wrapper">
                            <i class="bi {{ $icon }} actuator-main-icon"></i>
                        </div>

                        <h6 class="mb-3">{{ ucfirst($actuator->name) }}</h6>

                        <!-- TOGGLE + STATUS -->
                        <div class="d-flex justify-content-center align-items-center gap-2">

                            <!-- TOGGLE -->
                            <div class="toggle {{ $actuator->state == 'ON' ? 'active' : '' }}"
                                onclick="toggleActuator({{ $actuator->id }})" id="toggle-{{ $actuator->id }}"
                                style="z-index:3; position:relative;">
                            </div>

                            <!-- STATUS -->
                            <small id="status-{{ $actuator->id }}"
                                class="{{ $actuator->state == 'ON' ? 'status-on' : 'status-off' }}">
                                {{ $actuator->state }}
                            </small>

                        </div>

                    </div>
                </div>
            @endforeach

            {{-- <div class="col-4 col-lg-2">
                <div class="card card-custom text-center p-3 h-100">
                    <h6>Mist</h6>
                    <div class="toggle active"></div>
                </div>
            </div> --}}

        </div>

        <!-- Bottom Section -->
        <div class="row g-3 mb-3">

            <!-- RIWAYAT -->
            <div class="col-12">
                <div class="card card-custom p-3">

                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <h6 class="mb-0">Riwayat</h6>

                        <input type="date" id="filter-date" class="form-control form-control-sm"
                            style="max-width:150px;">
                    </div>

                    <canvas id="sensorChart" style="max-height:300px;"></canvas>

                </div>
            </div>

        </div>

    </div>

    </div>


    <form action="{{ route('setting.updateTemperature') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="modalSuhu" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Setting Batas Suhu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Batas Suhu Maksimum (°C)</label>

                        <input type="number" name="max_temperature" class="form-control" step="0.1"
                            value="{{ optional($cage->setting)->max_temperature }}" required>

                        <small class="text-muted">
                            Lampu akan otomatis mati jika suhu melebihi batas ini
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('setting.updateHumidity') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="modalKelembapan" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Setting Batas Kelembapan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Batas Kelembapan Minimum (%)</label>

                        <input type="number" name="min_humidity" class="form-control" step="0.1"
                            value="{{ optional($cage->setting)->min_humidity }}" required>

                        <small class="text-muted">
                            Mistmaker akan otomatis menyala jika kelembapan di bawah batas ini
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('cage.updateDate', $cage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="modalTanggalKandang" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Tanggal Pembuatan Kandang</h5> <button type="button"
                            class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body"> <label class="form-label">Tanggal Pembuatan Kandang</label>
                        <!-- Input kalender -->
                        <input type="date" class="form-control" name="start_date"
                            value="{{ $cage->start_date ?? '' }}" required>
                        <small class="text-muted"> Pilih tanggal saat kandang dibuat atau mulai digunakan </small>
                    </div>
                    <div class="modal-footer"> <button class="btn btn-secondary"
                            data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('cage.updateEgg', $cage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="modalJumlahTelur" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Masukkan Jumlah Telur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Jumlah Telur</label>

                        <input type="number" name="egg_count" class="form-control" placeholder="Contoh: 100"
                            min="0" value="{{ $cage->egg_count ?? 0 }}" required>

                        <small class="text-muted">
                            Menampilakan jumlah telur pada kandang
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
