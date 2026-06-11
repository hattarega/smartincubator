<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login - Smart Egg Incubator</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🥚</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Space+Mono&display=swap"
        rel="stylesheet">

    <style>
        /* =============================================
           THEME TOKENS — identik dengan dashboard
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
            --blob1: rgba(245, 158, 11, 0.08);
            --blob2: rgba(96, 165, 250, 0.07);
            --close-filter: none;
        }

        :root {
            --amber: #F59E0B;
            --amber-light: #FCD34D;
            --amber-dim: rgba(245, 158, 11, 0.15);
            --temp: #FF6B6B;
            --hum: #60A5FA;
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
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            transition: background .25s, color .25s;
        }

        /* Blob decorations — sama persis dengan dashboard */
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

        /* ===== LAYOUT ===== */
        .login-outer {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
        }

        /* ===== BRAND ===== */
        .brand-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            background: var(--amber-dim);
            border: 1px solid rgba(245, 158, 11, .3);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 0 28px rgba(245, 158, 11, .12);
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            letter-spacing: .06em;
        }

        /* ===== CARD — override Bootstrap .card ===== */
        .card {
            width: 100%;
            max-width: 400px;
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 22px !important;
            padding: 30px 28px !important;
            color: var(--text) !important;
            backdrop-filter: none !important;
            position: relative;
            overflow: hidden;
            transition: background .25s, border-color .25s;
        }

        /* Amber top-line accent */
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 22px 22px 0 0;
            background: linear-gradient(90deg, transparent, var(--amber), transparent);
        }

        .card-heading {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -.02em;
            margin-bottom: 4px;
        }

        .card-subheading {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 24px;
            font-family: var(--font-mono);
        }

        /* ===== ERROR — override Bootstrap .alert ===== */
        .alert-danger {
            background: rgba(255, 107, 107, .08) !important;
            border: 1px solid rgba(255, 107, 107, .22) !important;
            border-radius: 12px !important;
            color: var(--temp) !important;
            font-size: 12px !important;
            padding: 10px 14px !important;
            margin-bottom: 18px !important;
        }

        /* ===== FORM LABEL ===== */
        .field-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 7px;
            display: block;
        }

        /* ===== INPUT WRAPPER ===== */
        .input-wrap {
            position: relative;
            margin-bottom: 14px;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            pointer-events: none;
            transition: color .2s;
            display: flex;
            align-items: center;
        }

        /* Override Bootstrap .form-control */
        .form-control {
            background: var(--bg-elevated) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            color: var(--text) !important;
            padding: 11px 14px 11px 38px !important;
            font-family: var(--font) !important;
            font-size: 14px !important;
            transition: border-color .2s, box-shadow .2s, background .25s !important;
        }

        .form-control::placeholder {
            color: var(--text-dim) !important;
            font-size: 13px;
        }

        .form-control:focus {
            background: var(--bg-elevated) !important;
            color: var(--text) !important;
            border-color: rgba(245, 158, 11, .5) !important;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, .1) !important;
        }

        .form-control:focus+.input-icon-after,
        .input-wrap:focus-within .input-icon {
            color: var(--amber);
        }

        /* ===== SUBMIT BUTTON ===== */
        .btn-primary {
            background: var(--amber) !important;
            border: none !important;
            border-radius: 12px !important;
            color: #0D0F14 !important;
            font-family: var(--font) !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            padding: 12px !important;
            letter-spacing: -.01em;
            transition: background .2s, transform .15s, box-shadow .2s !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--amber-light) !important;
            color: #0D0F14 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, .28) !important;
        }

        .btn-primary:active {
            transform: translateY(0) !important;
            box-shadow: none !important;
        }

        /* Arrow icon inside button */
        .btn-arrow {
            display: inline-block;
            font-size: 15px;
        }

        /* ===== DIVIDER ===== */
        .divider-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-text {
            font-size: 11px;
            color: var(--text-dim);
            font-family: var(--font-mono);
            white-space: nowrap;
        }

        /* ===== REGISTER LINK ===== */
        .register-row {
            text-align: center;
            margin-top: 16px;
        }

        .register-row a.text-light {
            color: var(--amber) !important;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color .2s;
        }

        .register-row a.text-light:hover {
            color: var(--amber-light) !important;
        }

        /* ===== STATUS STRIP ===== */
        .status-strip {
            display: flex;
            gap: 14px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            color: var(--text-dim);
            font-family: var(--font-mono);
        }

        .pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--success);
            animation: pulse 2s infinite;
        }

        .pulse-dot.amber {
            background: var(--amber);
        }

        .pulse-dot.blue {
            background: var(--hum);
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

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 100;
            width: 36px;
            height: 36px;
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: var(--text-muted);
            transition: border-color .2s, color .2s;
        }

        .theme-toggle:hover {
            border-color: var(--amber);
            color: var(--amber);
        }

        /* ===== VERSION ===== */
        .version-tag {
            font-size: 11px;
            color: var(--text-dim);
            font-family: var(--font-mono);
        }

        .version-tag span {
            display: inline-block;
            padding: 2px 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 10px;
            margin-left: 4px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .card {
                padding: 24px 18px !important;
                border-radius: 18px !important;
            }

            .brand-icon {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }

            .brand-name {
                font-size: 17px;
            }

            .status-strip {
                gap: 10px;
            }
        }

        @media (max-width: 360px) {
            .card {
                padding: 20px 14px !important;
            }

            .brand-name {
                font-size: 15px;
            }
        }

        @media (max-height: 680px) {
            .login-outer {
                gap: 12px;
                padding: 12px 16px;
            }

            .card {
                padding: 22px 22px !important;
            }

            .card-subheading {
                margin-bottom: 16px;
            }

            .input-wrap {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    {{-- Theme toggle --}}
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle tema">🌙</button>

    <div class="login-outer">

        {{-- Brand --}}
        <div class="brand-wrap">
            <div class="brand-icon">🥚</div>
            <div class="brand-name">Smart Egg Incubator</div>
            <div class="brand-sub">Monitoring suhu, kelembapan &amp; aktuator realtime</div>
        </div>

        {{-- Card --}}
        <div class="card">

            <div class="card-heading">Login</div>
            <div class="card-subheading">Masuk untuk mengakses dashboard monitoring</div>

            {{-- ERROR — backend tidak diubah --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- FORM — action, method, @csrf, name tidak diubah --}}
            <form method="POST" action="/login">
                @csrf

                {{-- Email --}}
                <label class="field-label">Email</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="nama@domain.com" required>
                </div>

                {{-- Password --}}
                <label class="field-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <path stroke-linecap="round" d="M8 11V7a4 4 0 018 0v4" />
                        </svg>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button class="btn btn-primary w-100">
                    Masuk ke Dashboard
                    <span class="btn-arrow">→</span>
                </button>

            </form>

            {{-- Status strip --}}
            {{-- <div class="status-strip">
            <div class="status-item"><div class="pulse-dot"></div> SERVER ONLINE</div>
            <div class="status-item"><div class="pulse-dot amber"></div> 4 SENSOR AKTIF</div>
            <div class="status-item"><div class="pulse-dot blue"></div> MQTT CONNECTED</div>
        </div> --}}

            {{-- Register link — backend tidak diubah --}}
            <div class="register-row mt-3">
                <a href="/register" class="text-light">Belum punya akun? Daftar sekarang</a>
            </div>

        </div>

        {{-- Version --}}
        {{-- <div class="version-tag">IoT Monitor <span>v2.4.1</span> · © 2025</div> --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Deteksi preferensi sistem
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        let isDark = prefersDark;
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        document.querySelector('.theme-toggle').textContent = isDark ? '🌙' : '☀️';

        function toggleTheme() {
            isDark = !isDark;
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            document.querySelector('.theme-toggle').textContent = isDark ? '🌙' : '☀️';
        }
    </script>

</body>

</html>
