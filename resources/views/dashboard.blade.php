<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard - Smart Egg Incubator</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🥚</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        /* =============================================
           THEME TOKENS
        ============================================= */
        :root,
        [data-theme="dark"] {
            --bg-base: #0D0F14;
            --bg-card: #13161E;
            --bg-elevated: #1C2030;
            --border: rgba(255, 255, 255, 0.07);
            --border-light: rgba(255, 255, 255, 0.12);
            --text: #F1F0EB;
            --text-muted: #6B7280;
            --text-dim: #4B5563;
            --chart-grid: rgba(255, 255, 255, 0.04);
            --chart-tooltip-bg: #1C2030;
            --chart-tooltip-border: rgba(255, 255, 255, 0.1);
            --chart-tooltip-title: #F1F0EB;
            --chart-tooltip-body: #9CA3AF;
            --chart-tick: #4B5563;
            --blob1: rgba(245, 158, 11, 0.06);
            --blob2: rgba(96, 165, 250, 0.05);
            --close-filter: invert(1);
        }

        [data-theme="light"] {
            --bg-base: #F3F2ED;
            --bg-card: #FFFFFF;
            --bg-elevated: #EEEDE8;
            --border: rgba(0, 0, 0, 0.08);
            --border-light: rgba(0, 0, 0, 0.14);
            --text: #1A1A1A;
            --text-muted: #6B7280;
            --text-dim: #9CA3AF;
            --chart-grid: rgba(0, 0, 0, 0.05);
            --chart-tooltip-bg: #FFFFFF;
            --chart-tooltip-border: rgba(0, 0, 0, 0.1);
            --chart-tooltip-title: #1A1A1A;
            --chart-tooltip-body: #6B7280;
            --chart-tick: #9CA3AF;
            --blob1: rgba(245, 158, 11, 0.08);
            --blob2: rgba(96, 165, 250, 0.07);
            --close-filter: none;
        }

        /* Accents — identical in both themes */
        :root {
            --amber: #F59E0B;
            --amber-light: #FCD34D;
            --amber-dim: rgba(245, 158, 11, 0.15);
            --temp: #FF6B6B;
            --temp-dim: rgba(255, 107, 107, 0.12);
            --hum: #60A5FA;
            --hum-dim: rgba(96, 165, 250, 0.12);
            --success: #34D399;
            --success-dim: rgba(52, 211, 153, 0.12);
            --font: 'Plus Jakarta Sans', sans-serif;
            --font-mono: 'Space Mono', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg-base);
            font-family: var(--font);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background .25s, color .25s;
        }

        body::before {
            content: '';
            position: fixed;
            top: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--blob1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -200px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--blob2) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .app-wrapper {
            position: relative;
            z-index: 1;
            padding: 16px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ===== TOP NAV ===== */
        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 18px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            margin-bottom: 18px;
            transition: background .25s, border-color .25s;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--amber-dim);
            border: 1px solid rgba(245, 158, 11, .3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -.02em;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Datetime — always visible */
        .datetime-badge {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 6px 12px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            white-space: nowrap;
            transition: background .25s;
        }

        .datetime-badge i {
            color: var(--amber);
            font-size: 12px;
        }

        .status-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--success-dim);
            border: 1px solid rgba(52, 211, 153, .2);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            color: var(--success);
            white-space: nowrap;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(.8);
            }
        }

        /* Theme toggle */
        .theme-toggle {
            width: 34px;
            height: 34px;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            background: var(--bg-elevated);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            transition: all .2s;
            flex-shrink: 0;
        }

        .theme-toggle:hover {
            border-color: var(--amber);
            color: var(--amber);
        }

        /* Logout button */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 13px;
            border: 1px solid rgba(255, 107, 107, 0.25);
            border-radius: 10px;
            background: rgba(255, 107, 107, 0.08);
            color: var(--temp);
            font-size: 12px;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
        }

        .logout-btn:hover {
            background: rgba(255, 107, 107, 0.18);
            border-color: rgba(255, 107, 107, 0.5);
        }

        .logout-btn i {
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .logout-btn span {
                display: none;
            }

            .logout-btn {
                width: 34px;
                height: 34px;
                padding: 0;
                justify-content: center;
            }
        }

        /* ===== SECTION LABEL ===== */
        .section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-dim);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ===== INFO ROW ===== */
        .info-row {
            display: grid;
            grid-template-columns: 1fr repeat(3, minmax(130px, auto));
            gap: 12px;
            margin-bottom: 18px;
        }

        .info-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px 20px;
            position: relative;
            transition: background .25s, border-color .25s;
        }

        .info-card-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .info-card-value {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1;
            color: var(--amber-light);
            font-family: var(--font-mono);
        }

        .welcome-card .info-card-value {
            font-size: 18px;
            font-family: var(--font);
            font-weight: 700;
            color: var(--text);
        }

        .info-card-sub {
            font-size: 11px;
            color: var(--text-dim);
            margin-top: 6px;
        }

        .edit-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 28px;
            height: 28px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 11px;
            color: var(--text-muted);
            transition: all .2s;
            text-decoration: none;
        }

        .edit-btn:hover {
            background: var(--amber-dim);
            border-color: rgba(245, 158, 11, .4);
            color: var(--amber);
        }

        /* ===== SENSOR ROW ===== */
        .sensor-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .sensor-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            position: relative;
            overflow: hidden;
            transition: background .25s, border-color .25s;
        }

        .sensor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 18px 18px 0 0;
        }

        .sensor-card.temp::before {
            background: linear-gradient(90deg, var(--temp), transparent);
        }

        .sensor-card.hum::before {
            background: linear-gradient(90deg, var(--hum), transparent);
        }

        .sensor-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .sensor-icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .sensor-icon-wrap.temp {
            background: var(--temp-dim);
            color: var(--temp);
        }

        .sensor-icon-wrap.hum {
            background: var(--hum-dim);
            color: var(--hum);
        }

        .sensor-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .sensor-readings {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .sensor-reading-block {
            flex: 1;
            background: var(--bg-elevated);
            border-radius: 11px;
            padding: 10px 12px;
            transition: background .25s;
        }

        .sensor-reading-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-dim);
            margin-bottom: 3px;
        }

        .sensor-reading-value {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.02em;
            font-family: var(--font-mono);
        }

        .sensor-reading-value.temp {
            color: var(--temp);
        }

        .sensor-reading-value.hum {
            color: var(--hum);
        }

        .sensor-limit {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--text-dim);
            padding: 6px 10px;
            background: var(--bg-elevated);
            border-radius: 8px;
            transition: background .25s;
        }

        /* ===== ACTUATOR CARDS ===== */
        .actuator-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: border-color .25s, background .25s;
            overflow: hidden;
        }

        .actuator-card.active {
            border-color: rgba(245, 158, 11, .25);
            background: linear-gradient(160deg, rgba(245, 158, 11, .06) 0%, var(--bg-card) 60%);
        }

        .actuator-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 18px 18px 0 0;
            background: linear-gradient(90deg, transparent, var(--amber), transparent);
            opacity: 0;
            transition: opacity .3s;
        }

        .actuator-card.active::before {
            opacity: 1;
        }

        .actuator-icon-bg {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 22px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            transition: all .3s;
        }

        .actuator-card.active .actuator-icon-bg {
            background: var(--amber-dim);
            border-color: rgba(245, 158, 11, .3);
            color: var(--amber);
            box-shadow: 0 0 18px rgba(245, 158, 11, .15);
        }

        .actuator-name {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-switch {
            width: 44px;
            height: 24px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 50px;
            position: relative;
            cursor: pointer;
            transition: all .3s;
            flex-shrink: 0;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            background: var(--text-dim);
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all .3s;
        }

        .toggle-switch.on {
            background: rgba(245, 158, 11, .18);
            border-color: rgba(245, 158, 11, .5);
        }

        .toggle-switch.on::after {
            background: var(--amber);
            left: 22px;
            box-shadow: 0 0 8px rgba(245, 158, 11, .5);
        }

        .toggle-status {
            font-size: 11px;
            font-weight: 700;
            font-family: var(--font-mono);
            letter-spacing: .05em;
        }

        .toggle-status.on {
            color: var(--amber);
        }

        .toggle-status.off {
            color: var(--text-dim);
        }

        .auto-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 26px;
            height: 26px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-elevated);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 11px;
            color: var(--text-dim);
            transition: all .2s;
        }

        .auto-btn:hover {
            border-color: var(--hum);
            color: var(--hum);
        }

        .auto-btn.auto-active {
            background: rgba(96, 165, 250, .1);
            border-color: rgba(96, 165, 250, .3);
            color: var(--hum);
        }

        /* ===== CHART ===== */
        .chart-section {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 18px;
            transition: background .25s, border-color .25s;
        }

        .chart-header {
            position: relative;
            margin-bottom: 16px;
            min-height: 42px;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;

            padding-right: 150px;
        }

        /* Clickable legend chips */
        .legend-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .legend-chip {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
            transition: all .2s;
        }

        .legend-chip.active {
            color: var(--text);
            border-color: var(--border-light);
        }

        .legend-chip.inactive {
            opacity: .38;
        }

        .legend-chip:hover {
            border-color: var(--border-light);
        }

        .legend-chip-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-chip-dash {
            width: 16px;
            height: 2px;
            flex-shrink: 0;
            background: repeating-linear-gradient(90deg, currentColor 0, currentColor 4px, transparent 4px, transparent 8px);
        }

        .date-input {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;

            background: var(--bg-elevated);
            border: 1px solid var(--border);

            border-radius: 10px;
            padding: 7px 12px;

            font-size: 12px;
            color: var(--text);

            font-family: var(--font);
            outline: none;

            transition: all .2s;
        }

        .date-input:focus {
            border-color: var(--amber);
        }

        /* ===== MODALS ===== */
        .modal-content {
            background: var(--bg-elevated);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            color: var(--text);
            transition: background .25s;
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 18px 22px 14px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 15px;
        }

        .btn-close {
            filter: var(--close-filter);
            opacity: .5;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 18px 22px;
        }

        .modal-body label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        .modal-body small.text-muted {
            color: var(--text-dim) !important;
            font-size: 11px;
            display: block;
            margin-top: 6px;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 14px 22px;
            gap: 8px;
        }

        .form-control {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: 12px;
            color: var(--text);
            padding: 10px 14px;
            font-family: var(--font-mono);
            font-size: 14px;
            transition: border-color .2s, background .25s, color .25s;
        }

        .form-control:focus {
            background: var(--bg-card);
            color: var(--text);
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, .1);
        }

        .btn-secondary {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            color: var(--text-muted);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
        }

        .btn-primary {
            background: var(--amber);
            border: none;
            color: #0D0F14;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 16px;
        }

        .btn-primary:hover {
            background: var(--amber-light);
            color: #0D0F14;
        }

        /* floating alert */
        .floating-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(52, 211, 153, .12);
            border: 1px solid rgba(52, 211, 153, .3);
            color: var(--success);
            padding: 11px 22px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            z-index: 9999;
            backdrop-filter: blur(10px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sensor-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .info-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .app-wrapper {
                padding: 10px 12px;
            }

            /* Nav wraps: brand on top row, nav-right fills below */
            .top-nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-right {
                width: 100%;
            }

            /* datetime stretches to fill available space */
            .datetime-badge {
                flex: 1;
                min-width: 0;
            }
        }

        @media (max-width: 480px) {
            .sensor-row {
                grid-template-columns: 1fr 1fr;
            }

            .info-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 360px) {
            .sensor-row {
                grid-template-columns: 1fr;
            }

            .info-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width:640px) {

            .chart-title {
                padding-right: 120px;
                font-size: 13px;
            }

            .date-input {
                width: 110px;
                font-size: 11px;
                padding: 6px 8px;
            }
        }
    </style>

    @vite('resources/js/app.js')
</head>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Prevent flash of wrong theme -->
<script>
    (function() {
        var t = localStorage.getItem('incubator-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', t);
    })();
</script>

<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>


{{-- <script>
    window.history.forward();

    function noBack() {
        window.history.forward();
    }

    window.onload = noBack;
    window.onpageshow = function(evt) {
        if (evt.persisted) noBack();
    };

    window.onunload = function() {};
</script> --}}

<!-- Backend functions — unchanged -->
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
        }).then(r => r.json()).then(d => console.log('toggle', d));
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
        }).then(r => r.json()).then(d => console.log('auto', d));
    }
</script>

<script>
    const MAX_TEMP = {{ optional($cage->setting)->max_temperature ?? 37.5 }};
    const MIN_HUM = {{ optional($cage->setting)->min_humidity ?? 60 }};
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* =========================================
           THEME TOGGLE
        ========================================= */
        var html = document.documentElement;
        var themeBtn = document.getElementById('theme-toggle-btn');
        var themeIcon = document.getElementById('theme-icon');

        function applyTheme(t) {
            html.setAttribute('data-theme', t);
            localStorage.setItem('incubator-theme', t);
            themeIcon.className = (t === 'dark') ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            if (window._chart) buildChart(window._rawData || []);
        }

        // Set icon to match saved theme on load
        applyTheme(html.getAttribute('data-theme'));

        themeBtn.addEventListener('click', function() {
            applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });


        /* =========================================
           REALTIME CLOCK — always visible
        ========================================= */
        function updateDateTime() {
            var el = document.getElementById('datetime');
            if (!el) return;
            var now = new Date();
            var date = now.toLocaleDateString('id-ID', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            var time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            el.innerText = date + '  ' + time;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        function updateRotationSchedule() {

            const now = new Date();

            // Jadwal perputaran tiap 4 jam
            const schedules = [0, 4, 8, 12, 16, 20];

            let completed = 0;
            let nextHour = null;

            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();

            // Hitung jumlah putaran yang sudah lewat
            schedules.forEach(hour => {

                if (
                    currentHour > hour ||
                    (currentHour === hour && currentMinute >= 0)
                ) {
                    completed++;
                }

            });

            // Cari jadwal berikutnya
            for (let i = 0; i < schedules.length; i++) {

                if (currentHour < schedules[i]) {
                    nextHour = schedules[i];
                    break;
                }

            }

            // Jika sudah lewat jam 20:00
            if (nextHour === null) {
                nextHour = 0;
            }

            // Format jam berikutnya
            const nextText =
                String(nextHour).padStart(2, '0') + ':00';

            // Update tampilan
            document.getElementById('rotation-count').innerText = completed;


            document.getElementById('rotation-info').innerHTML =
                'Sudah berputar <strong>' + completed + '/6</strong> kali<br>' +
                'Jadwal berikutnya pukul <strong>' + nextText + '</strong>';

        }

        // jalankan pertama kali
        updateRotationSchedule();

        // update tiap 1 menit
        setInterval(updateRotationSchedule, 60000);



        /* =========================================
           ALERT AUTO HIDE
        ========================================= */
        setTimeout(function() {
            var a = document.getElementById('floatingAlert');
            if (a) {
                a.style.transition = 'opacity .5s';
                a.style.opacity = '0';
                setTimeout(function() {
                    a.remove();
                }, 500);
            }
        }, 2500);


        /* =========================================
           ECHO — REALTIME
        ========================================= */
        if (typeof Echo !== 'undefined') {
            Echo.channel('sensor.{{ $latest->cage_id ?? 1 }}')
                .subscribed(function() {
                    console.log('✅ SENSOR CONNECTED');
                })
                .listen('.sensor.updated', function(e) {
                    var map = {
                        'dht11-temp': e.data.temperature_dht11 + '°',
                        'dht11-hum': e.data.humidity_dht11 + '%',
                        'dht22-temp': e.data.temperature_dht22 + '°',
                        'dht22-hum': e.data.humidity_dht22 + '%',
                    };
                    Object.keys(map).forEach(function(id) {
                        var el = document.getElementById(id);
                        if (el) el.innerText = map[id];
                    });
                });

            Echo.channel('actuator.{{ $cage->id }}')
                .subscribed(function() {
                    console.log('✅ ACTUATOR CONNECTED');
                })
                .listen('.actuator.updated', function(e) {
                    var a = e.actuator;
                    var isOn = a.state === 'ON';
                    var toggle = document.getElementById('toggle-' + a.id);
                    var card = document.getElementById('act-card-' + a.id);
                    var status = document.getElementById('status-' + a.id);
                    var autoBtn = document.getElementById('auto-btn-' + a.id);
                    var autoIco = document.getElementById('auto-icon-' + a.id);
                    if (toggle) toggle.classList.toggle('on', isOn);
                    if (card) card.classList.toggle('active', isOn);
                    if (status) {
                        status.innerText = a.state;
                        status.className = 'toggle-status ' + (isOn ? 'on' : 'off');
                    }
                    if (autoBtn) autoBtn.classList.toggle('auto-active', a.mode === 'AUTO');
                    if (autoIco) autoIco.style.color = a.mode === 'AUTO' ? 'var(--hum)' : 'var(--text-dim)';
                });
        } else {
            console.error('❌ Echo belum dimuat');
        }


        /* =========================================
           CHART
        ========================================= */
        window._chart = null;
        window._rawData = [];

        // Per-dataset visibility state
        var visible = [true, true, true, true];

        var META = [{
                label: 'DHT11 Suhu',
                color: '#FF6B6B',
                dash: false,
                axis: 'y'
            },
            {
                label: 'DHT22 Suhu',
                color: '#FCA5A5',
                dash: true,
                axis: 'y'
            },
            {
                label: 'DHT11 Kelembapan',
                color: '#60A5FA',
                dash: false,
                axis: 'y1'
            },
            {
                label: 'DHT22 Kelembapan',
                color: '#93C5FD',
                dash: true,
                axis: 'y1'
            },
        ];

        function hexRgba(hex, a) {
            var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);
            return 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
        }

        function parseData(raw) {
            var filtered = raw.filter(function(item) {
                var d = new Date(item.created_at);
                //return d.getMinutes() === 0 || d.getMinutes() === 30;
                //return d.getMinutes() % 10 === 0;

                // tampil tiap 30 menit
                var regularPoint =
                    d.getMinutes() === 0 ||
                    d.getMinutes() === 30;

                // tampil jika melewati batas setting
                var abnormal =
                    item.temperature > MAX_TEMP ||
                    item.humidity < MIN_HUM;

                return regularPoint || abnormal;
            });
            var grouped = {};
            filtered.forEach(function(item) {
                var d = new Date(item.created_at);
                var key = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString()
                    .padStart(2, '0');
                if (!grouped[key]) grouped[key] = {
                    dht11: {},
                    dht22: {}
                };
                if (item.type === 'dht11') grouped[key].dht11 = item;
                else grouped[key].dht22 = item;
            });
            var labels = [],
                rows = [
                    [],
                    [],
                    [],
                    []
                ];
            Object.keys(grouped).forEach(function(t) {
                labels.push(t);
                rows[0].push(grouped[t].dht11.temperature ?? null);
                rows[1].push(grouped[t].dht22.temperature ?? null);
                rows[2].push(grouped[t].dht11.humidity ?? null);
                rows[3].push(grouped[t].dht22.humidity ?? null);
            });
            return {
                labels: labels,
                rows: rows
            };
        }

        function getCSSVar(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        function buildChart(raw) {
            var parsed = parseData(raw);
            var canvas = document.getElementById('sensorChart');
            if (!canvas) return;
            if (window._chart) {
                window._chart.destroy();
                window._chart = null;
            }

            var datasets = META.map(function(m, i) {
                return {
                    label: m.label,
                    data: parsed.rows[i],
                    borderColor: m.color,
                    backgroundColor: hexRgba(m.color, 0.08),
                    borderWidth: 2,
                    borderDash: m.dash ? [5, 4] : [],
                    pointRadius: 3,
                    pointBackgroundColor: m.color,
                    tension: 0.4,
                    fill: !m.dash,
                    yAxisID: m.axis,
                    hidden: !visible[i],
                };
            });

            window._chart = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: parsed.labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: getCSSVar('--chart-tooltip-bg'),
                            borderColor: getCSSVar('--chart-tooltip-border'),
                            borderWidth: 1,
                            titleColor: getCSSVar('--chart-tooltip-title'),
                            bodyColor: getCSSVar('--chart-tooltip-body'),
                            padding: 12,
                            cornerRadius: 10,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: getCSSVar('--chart-grid'),
                                drawBorder: false
                            },
                            ticks: {
                                color: getCSSVar('--chart-tick'),
                                font: {
                                    family: "'Space Mono',monospace",
                                    size: 10
                                }
                            }
                        },
                        y: {
                            position: 'left',
                            grid: {
                                color: getCSSVar('--chart-grid'),
                                drawBorder: false
                            },
                            ticks: {
                                color: '#FF6B6B',
                                font: {
                                    family: "'Space Mono',monospace",
                                    size: 10
                                },
                                callback: function(v) {
                                    return v + '°C';
                                }
                            }
                        },
                        y1: {
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                color: '#60A5FA',
                                font: {
                                    family: "'Space Mono',monospace",
                                    size: 10
                                },
                                callback: function(v) {
                                    return v + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        function loadChart(date) {
            fetch('/chart-data?date=' + (date || ''))
                .then(function(r) {
                    return r.json();
                })
                .then(function(data) {
                    window._rawData = data;
                    buildChart(data);
                    syncChips();
                });
        }

        /* Legend chip clicks — toggle dataset */
        document.querySelectorAll('.legend-chip').forEach(function(chip) {
            chip.addEventListener('click', function() {
                var idx = parseInt(chip.dataset.idx);
                visible[idx] = !visible[idx];
                if (window._chart) {
                    window._chart.data.datasets[idx].hidden = !visible[idx];
                    window._chart.update();
                }
                syncChips();
            });
        });

        function syncChips() {
            document.querySelectorAll('.legend-chip').forEach(function(chip) {
                var idx = parseInt(chip.dataset.idx);
                chip.classList.toggle('active', visible[idx]);
                chip.classList.toggle('inactive', !visible[idx]);
            });
        }

        loadChart();
        syncChips();

        var filterEl = document.getElementById('filter-date');
        if (filterEl) filterEl.addEventListener('change', function() {
            loadChart(this.value);
        });

    });
</script>

<body>
    <div class="app-wrapper">

        @if (session('success'))
            <div id="floatingAlert" class="floating-alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- ===== TOP NAV ===== -->
        <div class="top-nav">
            <div class="brand">
                <div class="brand-icon">🥚</div>
                <div>
                    <div class="brand-name">Smart Egg Incubator</div>
                    <div class="brand-sub">Monitoring suhu, kelembapan &amp; aktuator realtime</div>
                </div>
            </div>

            <div class="nav-right">
                <!-- Jam — SELALU tampil (tidak hidden di mobile) -->
                <div class="datetime-badge">
                    <i class="bi bi-clock"></i>
                    <span id="datetime">—</span>
                </div>

                {{-- <div class="status-pill">
                <div class="pulse-dot"></div>
                Live
            </div> --}}

                <button class="theme-toggle" id="theme-toggle-btn" title="Ganti tema">
                    <i class="bi bi-sun-fill" id="theme-icon"></i>
                </button>

                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="logout-btn" title="Keluar">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- ===== INFO ROW ===== -->
        <div class="section-label">Informasi Kandang</div>
        <div class="info-row">

            <div class="info-card welcome-card">
                <div class="info-card-label">Inkubator Saat ini</div>
                <div class="info-card-value">🦆Telur Bebek</div>
                <div class="info-card-sub mt-2">Selamat memantau inkubator!</div>
            </div>

            <div class="info-card position-relative">
                <div class="info-card-label">Hari ke-</div>
                @if ($cage)
                    <div class="info-card-value">{{ floor($day) }}</div>
                    <div class="info-card-sub">Dibuat pada
                        <strong>
                            {{ \Carbon\Carbon::parse($cage->start_date)->translatedFormat('d/m/Y') }}
                        </strong>
                        pukul
                        <strong>
                            {{ \Carbon\Carbon::parse($cage->start_date)->translatedFormat('H:i') }}
                        </strong>
                    </div>
                @else
                    <div class="info-card-value" style="color:var(--text-dim)">—</div>
                    <div class="info-card-sub">Belum ada kandang</div>
                @endif
                <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modalTanggalKandang">
                    <i class="bi bi-pencil"></i>
                </a>
            </div>

            <div class="info-card position-relative">
                <div class="info-card-label">Jumlah Telur</div>
                <div class="info-card-value">{{ $cage->egg_count ?? 0 }}</div>
                <div class="info-card-sub">butir</div>
                <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modalJumlahTelur">
                    <i class="bi bi-pencil"></i>
                </a>
            </div>

            <div class="info-card" id="rotation-card">
                <div class="info-card-label">Perputaran Motor</div>

                <!-- jumlah putaran hari ini -->
                <div class="info-card-value" id="rotation-count">0</div>

                <!-- info jadwal -->
                <div class="info-card-sub" id="rotation-info">
                    Menunggu jadwal...
                </div>
            </div>

        </div>

        <!-- ===== SENSOR & ACTUATOR ===== -->
        <div class="section-label">Sensor &amp; Aktuator</div>
        <div class="sensor-row">

            <!-- Suhu -->
            <div class="sensor-card temp">
                <div class="sensor-header-row">
                    <div class="d-flex align-items-center gap-2">
                        <div class="sensor-icon-wrap temp"><i class="bi bi-thermometer-half"></i></div>
                        <span class="sensor-title">Suhu</span>
                    </div>
                    <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modalSuhu" style="position:static">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                <div class="sensor-readings">
                    <div class="sensor-reading-block">
                        <div class="sensor-reading-label">DHT11</div>
                        <div class="sensor-reading-value temp" id="dht11-temp">{{ $latest->temperature_dht11 ?? '—' }}°
                        </div>
                    </div>
                    <div class="sensor-reading-block">
                        <div class="sensor-reading-label">DHT22</div>
                        <div class="sensor-reading-value temp" id="dht22-temp">{{ $latest->temperature_dht22 ?? '—' }}°
                        </div>
                    </div>
                </div>
                <div class="sensor-limit">
                    <i class="bi bi-arrow-up-circle" style="color:var(--temp)"></i>
                    Maks <strong
                        style="color:var(--text);margin-left:4px">{{ optional($cage->setting)->max_temperature ?? '—' }}
                        °C</strong>
                </div>
            </div>

            <!-- Kelembapan -->
            <div class="sensor-card hum">
                <div class="sensor-header-row">
                    <div class="d-flex align-items-center gap-2">
                        <div class="sensor-icon-wrap hum"><i class="bi bi-droplet-half"></i></div>
                        <span class="sensor-title">Kelembapan</span>
                    </div>
                    <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modalKelembapan"
                        style="position:static">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                <div class="sensor-readings">
                    <div class="sensor-reading-block">
                        <div class="sensor-reading-label">DHT11</div>
                        <div class="sensor-reading-value hum" id="dht11-hum">{{ $latest->humidity_dht11 ?? '—' }}%
                        </div>
                    </div>
                    <div class="sensor-reading-block">
                        <div class="sensor-reading-label">DHT22</div>
                        <div class="sensor-reading-value hum" id="dht22-hum">{{ $latest->humidity_dht22 ?? '—' }}%
                        </div>
                    </div>
                </div>
                <div class="sensor-limit">
                    <i class="bi bi-arrow-down-circle" style="color:var(--hum)"></i>
                    Min <strong
                        style="color:var(--text);margin-left:4px">{{ optional($cage->setting)->min_humidity ?? '—' }}
                        %</strong>
                </div>
            </div>

            <!-- Actuators -->
            @foreach ($actuators as $actuator)
                @php
                    $icons = ['lampu' => 'bi-lightbulb-fill', 'mistmaker' => 'bi-cloud-fog2-fill'];
                    $icon = $icons[strtolower($actuator->name)] ?? 'bi-cpu-fill';
                    $isOn = $actuator->state === 'ON';
                    $isAuto = $actuator->mode === 'AUTO';
                @endphp

                <div class="actuator-card {{ $isOn ? 'active' : '' }}" id="act-card-{{ $actuator->id }}">
                    <button onclick="setAuto({{ $actuator->id }})" id="auto-btn-{{ $actuator->id }}"
                        class="auto-btn {{ $isAuto ? 'auto-active' : '' }}" title="Mode Auto">
                        <i class="bi bi-cpu-fill" id="auto-icon-{{ $actuator->id }}"></i>
                    </button>
                    <div class="actuator-icon-bg" id="icon-wrap-{{ $actuator->id }}">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="actuator-name">{{ ucfirst($actuator->name) }}</div>
                    <div class="toggle-wrap">
                        <div class="toggle-switch {{ $isOn ? 'on' : '' }}" id="toggle-{{ $actuator->id }}"
                            onclick="toggleActuator({{ $actuator->id }})">
                        </div>
                        <span class="toggle-status {{ $isOn ? 'on' : 'off' }}" id="status-{{ $actuator->id }}">
                            {{ $actuator->state }}
                        </span>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- ===== CHART ===== -->
        <div class="section-label">Riwayat Sensor</div>
        <div class="chart-section">
            <div class="chart-header">
                <input type="date" id="filter-date" class="date-input">
                <div>
                    <div class="chart-title">Grafik Suhu &amp; Kelembapan

                    </div>

                    <!-- Klik chip untuk show/hide dataset -->
                    <div class="legend-chips">
                        <div class="legend-chip active" data-idx="0">
                            <span class="bi bi-thermometer-half"></span>
                            DHT11
                        </div>
                        <div class="legend-chip active" data-idx="1">
                            <span class="bi bi-thermometer-half"></span>
                            DHT22
                        </div>
                        <div class="legend-chip active" data-idx="2">
                            <span class="bi bi-droplet-half"></span>
                            DHT11
                        </div>
                        <div class="legend-chip active" data-idx="3">
                            <span class="bi bi-droplet-half"></span>
                            DHT22
                        </div>
                    </div>
                </div>

            </div>
            <div style="height:280px; position:relative;">
                <canvas id="sensorChart"></canvas>
            </div>
        </div>

    </div><!-- /app-wrapper -->


    <!-- ===== MODALS ===== -->

    <form action="{{ route('setting.updateTemperature') }}" method="POST">
        @csrf @method('PUT')
        <div class="modal fade" id="modalSuhu" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-thermometer-half me-2"
                                style="color:var(--temp)"></i>Setting Batas Suhu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Batas Suhu Maksimum (°C)</label>
                        <input type="number" name="max_temperature" class="form-control" step="0.1"
                            value="{{ optional($cage->setting)->max_temperature }}" required>
                        <small class="text-muted">Lampu akan otomatis mati jika suhu melebihi batas ini</small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('setting.updateHumidity') }}" method="POST">
        @csrf @method('PUT')
        <div class="modal fade" id="modalKelembapan" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-droplet-half me-2"
                                style="color:var(--hum)"></i>Setting Batas Kelembapan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Batas Kelembapan Minimum (%)</label>
                        <input type="number" name="min_humidity" class="form-control" step="0.1"
                            value="{{ optional($cage->setting)->min_humidity }}" required>
                        <small class="text-muted">Mistmaker akan otomatis menyala jika kelembapan di bawah batas
                            ini</small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('cage.updateDate', $cage->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal fade" id="modalTanggalKandang" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-calendar3 me-2"
                                style="color:var(--amber)"></i>Tanggal Mulai Kandang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Tanggal Pembuatan Kandang</label>
                        <input type="datetime-local" class="form-control" name="start_date"
                            value="{{ $cage ? \Carbon\Carbon::parse($cage->start_date)->format('Y-m-d\TH:i') : '' }}"
                            required>
                        <small class="text-muted">Pilih tanggal dan jam saat inkubasi dimulai</small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('cage.updateEgg', $cage->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal fade" id="modalJumlahTelur" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-egg-fill me-2" style="color:var(--amber)"></i>Jumlah
                            Telur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Jumlah Telur (butir)</label>
                        <input type="number" name="egg_count" class="form-control" placeholder="Contoh: 100"
                            min="0" value="{{ $cage->egg_count ?? 0 }}" required>
                        <small class="text-muted">Menampilkan jumlah telur pada kandang</small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
