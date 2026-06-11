<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register - Smart Egg Incubator</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🥚</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Space+Mono&display=swap"
        rel="stylesheet">

    <style>
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
            overflow-x: hidden;
            position: relative;
            transition: background .25s, color .25s;
            padding: 20px;
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

        .login-outer {
            position: relative;
            z-index: 1;
            width: 100%;
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

        /* ===== CARD ===== */
        .card {
            width: 100%;
            max-width: 420px;
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 22px !important;
            padding: 30px 28px !important;
            color: var(--text) !important;
            position: relative;
            overflow: hidden;
            transition: background .25s, border-color .25s;
        }

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
            margin-bottom: 22px;
            font-family: var(--font-mono);
        }

        /* ===== ALERTS ===== */
        .alert-danger {
            background: rgba(255, 107, 107, .08) !important;
            border: 1px solid rgba(255, 107, 107, .22) !important;
            border-radius: 12px !important;
            color: var(--temp) !important;
            font-size: 12px !important;
            padding: 10px 14px !important;
            margin-bottom: 16px !important;
        }

        .alert-success {
            background: var(--success-dim) !important;
            border: 1px solid rgba(52, 211, 153, .25) !important;
            border-radius: 12px !important;
            color: var(--success) !important;
            font-size: 12px !important;
            padding: 10px 14px !important;
            margin-bottom: 16px !important;
        }

        /* ===== FIELD LABEL ===== */
        .field-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 7px;
            display: block;
        }

        /* ===== INPUT ===== */
        .input-wrap {
            position: relative;
            margin-bottom: 13px;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            pointer-events: none;
            display: flex;
            align-items: center;
            transition: color .2s;
        }

        .input-wrap:focus-within .input-icon {
            color: var(--amber);
        }

        .form-control {
            background: var(--bg-elevated) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            color: var(--text) !important;
            padding: 11px 14px 11px 38px !important;
            font-family: var(--font) !important;
            font-size: 14px !important;
            width: 100%;
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
            outline: none;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }

        .strength-seg {
            flex: 1;
            height: 3px;
            border-radius: 3px;
            background: var(--border-light);
            transition: background .3s;
        }

        .strength-seg.weak {
            background: var(--temp);
        }

        .strength-seg.medium {
            background: var(--amber);
        }

        .strength-seg.strong {
            background: var(--success);
        }

        .strength-label {
            font-size: 10px;
            font-family: var(--font-mono);
            color: var(--text-dim);
            margin-top: 4px;
            min-height: 14px;
            transition: color .2s;
        }

        /* Password match hint */
        .match-hint {
            font-size: 10px;
            font-family: var(--font-mono);
            margin-top: 5px;
            min-height: 14px;
        }

        .match-hint.ok {
            color: var(--success);
        }

        .match-hint.err {
            color: var(--temp);
        }

        /* ===== BUTTON ===== */
        .btn-success {
            background: var(--amber) !important;
            border: none !important;
            border-radius: 12px !important;
            color: #0D0F14 !important;
            font-family: var(--font) !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            padding: 12px !important;
            letter-spacing: -.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .15s, box-shadow .2s !important;
        }

        .btn-success:hover {
            background: var(--amber-light) !important;
            color: #0D0F14 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, .28) !important;
        }

        .btn-success:active {
            transform: translateY(0) !important;
            box-shadow: none !important;
        }

        /* ===== DIVIDER ===== */
        .divider-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
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
        .login-row {
            text-align: center;
            margin-top: 14px;
        }

        .login-row a.text-light {
            color: var(--amber) !important;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color .2s;
        }

        .login-row a.text-light:hover {
            color: var(--amber-light) !important;
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
        }

        @media (max-width: 360px) {
            .card {
                padding: 20px 14px !important;
            }

            .brand-name {
                font-size: 15px;
            }
        }

        @media (max-height: 780px) {
            .login-outer {
                gap: 12px;
            }

            .card {
                padding: 22px 24px !important;
            }

            .card-subheading {
                margin-bottom: 14px;
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

    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle tema">🌙</button>

    <div class="login-outer">

        <div class="brand-wrap">
            <div class="brand-icon">🥚</div>
            <div class="brand-name">Smart Egg Incubator</div>
            <div class="brand-sub">Monitoring suhu, kelembapan &amp; aktuator realtime</div>
        </div>

        <div class="card">

            <div class="card-heading">Register</div>
            <div class="card-subheading">Daftarkan diri untuk mengakses sistem monitoring</div>

            {{-- 🔥 ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- 🔥 SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                {{-- Nama --}}
                <label class="field-label">Nama lengkap</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input type="text" name="name" class="form-control" placeholder="Nama Anda"
                        value="{{ old('name') }}" required>
                </div>

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
                    <input type="email" name="email" class="form-control" placeholder="nama@domain.com"
                        value="{{ old('email') }}" required>
                </div>

                {{-- Password --}}
                <label class="field-label">Password</label>
                <div class="input-wrap" style="margin-bottom:6px">
                    <span class="input-icon">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <path stroke-linecap="round" d="M8 11V7a4 4 0 018 0v4" />
                        </svg>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter"
                        id="passwordInput" required>
                </div>
                <div class="strength-bar-wrap">
                    <div class="strength-seg" id="s1"></div>
                    <div class="strength-seg" id="s2"></div>
                    <div class="strength-seg" id="s3"></div>
                    <div class="strength-seg" id="s4"></div>
                </div>
                <div class="strength-label" id="strengthLabel"></div>

                {{-- Konfirmasi Password --}}
                <label class="field-label" style="margin-top:13px">Konfirmasi password</label>
                <div class="input-wrap" style="margin-bottom:4px">
                    <span class="input-icon">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password" id="confirmInput" required>
                </div>
                <div class="match-hint" id="matchHint"></div>

                <button class="btn btn-success w-100" style="margin-top:18px">
                    Buat Akun
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>

            </form>

            <div class="login-row mt-3">
                <a href="/login" class="text-light">Sudah punya akun? Masuk di sini</a>
            </div>

        </div>

        {{-- <div class="version-tag">IoT Monitor <span>v2.4.1</span> · © 2025</div> --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        let isDark = prefersDark;
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        document.querySelector('.theme-toggle').textContent = isDark ? '🌙' : '☀️';

        function toggleTheme() {
            isDark = !isDark;
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            document.querySelector('.theme-toggle').textContent = isDark ? '🌙' : '☀️';
        }

        // Password strength
        const pwInput = document.getElementById('passwordInput');
        const segs = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document
            .getElementById('s4')
        ];
        const strengthLabel = document.getElementById('strengthLabel');

        function calcStrength(pw) {
            let score = 0;
            if (pw.length >= 8) score++;
            if (pw.length >= 12) score++;
            if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
            if (/[0-9]/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++;
            return score;
        }

        const levels = ['', 'weak', 'medium', 'medium', 'strong'];
        const labels = {
            weak: 'Lemah',
            medium: 'Sedang',
            strong: 'Kuat'
        };
        const labelColors = {
            weak: 'var(--temp)',
            medium: 'var(--amber)',
            strong: 'var(--success)'
        };

        pwInput.addEventListener('input', () => {
            const pw = pwInput.value;
            if (!pw) {
                segs.forEach(s => {
                    s.className = 'strength-seg';
                });
                strengthLabel.textContent = '';
                return;
            }
            const score = calcStrength(pw);
            segs.forEach((s, i) => {
                s.className = 'strength-seg' + (i < score ? ' ' + levels[score] : '');
            });
            const lvl = levels[score];
            strengthLabel.textContent = lvl ? labels[lvl] : '';
            strengthLabel.style.color = lvl ? labelColors[lvl] : 'var(--text-dim)';
            checkMatch();
        });

        // Password match
        const confirmInput = document.getElementById('confirmInput');
        const matchHint = document.getElementById('matchHint');

        function checkMatch() {
            const pw = pwInput.value;
            const cf = confirmInput.value;
            if (!cf) {
                matchHint.textContent = '';
                matchHint.className = 'match-hint';
                return;
            }
            if (pw === cf) {
                matchHint.textContent = '✓ Password cocok';
                matchHint.className = 'match-hint ok';
            } else {
                matchHint.textContent = '✗ Password tidak cocok';
                matchHint.className = 'match-hint err';
            }
        }

        confirmInput.addEventListener('input', checkMatch);
    </script>

</body>

</html>
