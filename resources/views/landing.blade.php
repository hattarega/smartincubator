<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Smart Egg Incubator</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🥚</text></svg>">
{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
/* =============================================
   THEME TOKENS — identik dengan dashboard
============================================= */
:root,
[data-theme="dark"] {
    --bg-base:      #0D0F14;
    --bg-card:      #13161E;
    --bg-elevated:  #1C2030;
    --border:       rgba(255,255,255,0.07);
    --border-light: rgba(255,255,255,0.12);
    --text:         #F1F0EB;
    --text-muted:   #6B7280;
    --text-dim:     #4B5563;
    --blob1:        rgba(245,158,11,0.06);
    --blob2:        rgba(96,165,250,0.05);
    --nav-bg:       rgba(13,15,20,0.85);
}

[data-theme="light"] {
    --bg-base:      #F3F2ED;
    --bg-card:      #FFFFFF;
    --bg-elevated:  #EEEDE8;
    --border:       rgba(0,0,0,0.08);
    --border-light: rgba(0,0,0,0.14);
    --text:         #1A1A1A;
    --text-muted:   #6B7280;
    --text-dim:     #9CA3AF;
    --blob1:        rgba(245,158,11,0.08);
    --blob2:        rgba(96,165,250,0.07);
    --nav-bg:       rgba(243,242,237,0.85);
}

:root {
    --amber:        #F59E0B;
    --amber-light:  #FCD34D;
    --amber-dim:    rgba(245,158,11,0.15);
    --amber-glow:   rgba(245,158,11,0.25);
    --temp:         #FF6B6B;
    --temp-dim:     rgba(255,107,107,0.12);
    --hum:          #60A5FA;
    --hum-dim:      rgba(96,165,250,0.12);
    --success:      #34D399;
    --success-dim:  rgba(52,211,153,0.12);
    --font:         'Plus Jakarta Sans', sans-serif;
    --font-mono:    'Space Mono', monospace;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
    background: var(--bg-base);
    font-family: var(--font);
    color: var(--text);
    overflow-x: hidden;
    transition: background .3s, color .3s;
}

/* ===== DECORATIVE BLOBS ===== */
.blob-tl {
    position: fixed; top: -250px; left: -250px;
    width: 700px; height: 700px;
    background: radial-gradient(circle, var(--blob1) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
}
.blob-br {
    position: fixed; bottom: -250px; right: -150px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, var(--blob2) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
}

/* Grid overlay */
.grid-bg {
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background-image:
        linear-gradient(var(--border) 1px, transparent 1px),
        linear-gradient(90deg, var(--border) 1px, transparent 1px);
    background-size: 64px 64px;
    mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 0%, transparent 100%);
    opacity: 0.5;
}

/* ===== NAVBAR ===== */
.navbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 32px;
    background: var(--nav-bg);
    border-bottom: 1px solid var(--border);
    backdrop-filter: blur(16px);
    transition: background .3s, border-color .3s;
}

.nav-brand {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none;
}

.nav-icon {
    width: 36px; height: 36px;
    background: var(--amber-dim);
    border: 1px solid rgba(245,158,11,.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
}

.nav-logo-text {
    font-size: 16px; font-weight: 800;
    letter-spacing: -.03em; color: var(--text);
}

.nav-logo-text span { color: var(--amber); }

.nav-links {
    display: flex; align-items: center; gap: 6px;
    list-style: none;
}

.nav-links a {
    font-size: 13px; font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    padding: 7px 14px;
    border-radius: 10px;
    transition: color .2s, background .2s;
}

.nav-links a:hover { color: var(--text); background: var(--bg-elevated); }

.nav-right {
    display: flex; align-items: center; gap: 8px;
}

.btn-nav-outline {
    padding: 8px 16px;
    background: transparent;
    border: 1px solid var(--border-light);
    border-radius: 10px;
    color: var(--text-muted);
    font-family: var(--font);
    font-size: 13px; font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
}

.btn-nav-outline:hover {
    border-color: var(--amber);
    color: var(--amber);
}

.btn-nav-cta {
    padding: 8px 18px;
    background: var(--amber);
    border: none;
    border-radius: 10px;
    color: #0D0F14;
    font-family: var(--font);
    font-size: 13px; font-weight: 800;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, transform .15s;
}

.btn-nav-cta:hover { background: var(--amber-light); transform: translateY(-1px); }

.theme-toggle {
    width: 34px; height: 34px;
    background: var(--bg-elevated);
    border: 1px solid var(--border-light);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 15px; color: var(--text-muted);
    transition: all .2s;
}
.theme-toggle:hover { border-color: var(--amber); color: var(--amber); }

/* Hamburger */
.hamburger {
    display: none;
    flex-direction: column; gap: 5px;
    cursor: pointer; padding: 4px;
    background: none; border: none;
}
.hamburger span {
    display: block; width: 22px; height: 2px;
    background: var(--text-muted);
    border-radius: 2px;
    transition: all .3s;
}
.hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

.mobile-menu {
    display: none;
    position: fixed; top: 65px; left: 0; right: 0; z-index: 99;
    background: var(--bg-card);
    border-bottom: 1px solid var(--border);
    padding: 16px 24px 20px;
    flex-direction: column; gap: 4px;
}
.mobile-menu.open { display: flex; }
.mobile-menu a {
    font-size: 14px; font-weight: 600; color: var(--text-muted);
    text-decoration: none; padding: 10px 12px;
    border-radius: 10px; transition: all .2s;
}
.mobile-menu a:hover { background: var(--bg-elevated); color: var(--text); }
.mobile-menu .mobile-btns {
    display: flex; gap: 8px; margin-top: 8px; padding-top: 12px;
    border-top: 1px solid var(--border);
}

/* ===== SECTIONS ===== */
section {
    position: relative; z-index: 1;
}

/* ===== HERO ===== */
.hero {
    min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center;
    padding: 120px 24px 80px;
    position: relative; overflow: hidden;
}

.hero-egg-bg {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 600px; height: 700px;
    opacity: 0.04;
    pointer-events: none;
    z-index: 0;
}

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 6px 16px;
    background: var(--amber-dim);
    border: 1px solid rgba(245,158,11,.25);
    border-radius: 50px;
    font-size: 11px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--amber);
    font-family: var(--font-mono);
    margin-bottom: 28px;
    animation: fadeInDown .6s ease both;
}

.pulse-dot {
    width: 7px; height: 7px;
    background: var(--amber);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%,100% { opacity:1; transform: scale(1); }
    50%      { opacity:.5; transform: scale(.8); }
}

.hero-title {
    font-size: clamp(38px, 7vw, 72px);
    font-weight: 800;
    letter-spacing: -.04em;
    line-height: 1.05;
    margin-bottom: 22px;
    animation: fadeInUp .7s ease .1s both;
}

.hero-title em {
    font-style: normal;
    color: var(--amber);
    position: relative;
}

.hero-title em::after {
    content: '';
    position: absolute;
    left: 0; bottom: -2px; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--amber), var(--amber-light), transparent);
    border-radius: 3px;
}

.hero-desc {
    font-size: clamp(15px, 2vw, 18px);
    color: var(--text-muted);
    max-width: 560px;
    line-height: 1.7;
    margin: 0 auto 36px;
    animation: fadeInUp .7s ease .2s both;
}

.hero-cta-row {
    display: flex; align-items: center; justify-content: center;
    gap: 12px; flex-wrap: wrap;
    animation: fadeInUp .7s ease .3s both;
}

.btn-hero-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px;
    background: var(--amber);
    border: none; border-radius: 14px;
    color: #0D0F14;
    font-family: var(--font); font-size: 15px; font-weight: 800;
    text-decoration: none; cursor: pointer;
    transition: all .2s;
    letter-spacing: -.01em;
}
.btn-hero-primary:hover { background: var(--amber-light); transform: translateY(-2px); box-shadow: 0 12px 32px var(--amber-glow); }

.btn-hero-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 24px;
    background: var(--bg-elevated);
    border: 1px solid var(--border-light); border-radius: 14px;
    color: var(--text-muted);
    font-family: var(--font); font-size: 15px; font-weight: 600;
    text-decoration: none; cursor: pointer;
    transition: all .2s;
}
.btn-hero-secondary:hover { border-color: var(--amber); color: var(--amber); }

/* Hero stats row */
.hero-stats {
    display: flex; align-items: center; justify-content: center;
    gap: 32px; flex-wrap: wrap;
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid var(--border);
    animation: fadeInUp .7s ease .4s both;
}

.stat-item { text-align: center; }
.stat-value {
    font-size: 28px; font-weight: 800;
    letter-spacing: -.03em;
    font-family: var(--font-mono);
    color: var(--amber-light);
}
.stat-label {
    font-size: 11px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--text-dim); margin-top: 4px;
}
.stat-divider { width: 1px; height: 40px; background: var(--border); }

/* Hero egg illustration */
.hero-visual {
    margin-top: 64px;
    position: relative;
    animation: fadeInUp .8s ease .35s both;
    max-width: 700px;
    width: 100%;
    margin-left: auto; margin-right: auto;
}

.dashboard-mockup {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.dashboard-mockup::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--amber), transparent);
}

.mock-topbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px;
}

.mock-title { font-size: 13px; font-weight: 700; }
.mock-badge {
    display: flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 600; color: var(--success);
    padding: 4px 10px;
    background: var(--success-dim);
    border: 1px solid rgba(52,211,153,.2);
    border-radius: 8px;
    font-family: var(--font-mono);
}

.mock-cards {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
    margin-bottom: 14px;
}

.mock-card {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px;
    position: relative; overflow: hidden;
}

.mock-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; border-radius: 12px 12px 0 0;
}
.mock-card.temp::before { background: linear-gradient(90deg, var(--temp), transparent); }
.mock-card.hum::before  { background: linear-gradient(90deg, var(--hum), transparent); }
.mock-card.egg::before  { background: linear-gradient(90deg, var(--amber), transparent); }
.mock-card.fan::before  { background: linear-gradient(90deg, var(--success), transparent); }

.mock-card-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-dim); margin-bottom: 6px; }
.mock-card-val { font-size: 20px; font-weight: 800; font-family: var(--font-mono); letter-spacing: -.02em; }
.mock-card-val.temp { color: var(--temp); }
.mock-card-val.hum  { color: var(--hum); }
.mock-card-val.egg  { color: var(--amber); }
.mock-card-val.fan  { color: var(--success); }

/* Mini chart */
.mock-chart {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px;
    height: 80px;
    display: flex; align-items: flex-end; gap: 4px;
    overflow: hidden;
}

.bar {
    flex: 1;
    border-radius: 3px 3px 0 0;
    animation: growBar 1s ease both;
}

@keyframes growBar {
    from { transform: scaleY(0); transform-origin: bottom; }
    to   { transform: scaleY(1); transform-origin: bottom; }
}

/* ===== SECTION SHARED ===== */
.section-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 100px 24px;
}

.section-label {
    font-size: 10px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--amber);
    font-family: var(--font-mono);
    margin-bottom: 12px;
    display: flex; align-items: center; gap: 10px;
}

.section-label::before {
    content: '';
    width: 20px; height: 2px;
    background: var(--amber);
    border-radius: 2px;
}

.section-title {
    font-size: clamp(28px, 4vw, 44px);
    font-weight: 800; letter-spacing: -.03em;
    line-height: 1.1;
    margin-bottom: 16px;
}

.section-desc {
    font-size: 16px; color: var(--text-muted);
    line-height: 1.7; max-width: 500px;
}

/* ===== FEATURES ===== */
.features-section { background: var(--bg-base); }

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
    margin-top: 56px;
}

.feature-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 28px;
    position: relative; overflow: hidden;
    transition: border-color .2s, transform .2s;
}

.feature-card:hover {
    border-color: var(--border-light);
    transform: translateY(-3px);
}

.feature-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    border-radius: 20px 20px 0 0;
    opacity: 0;
    transition: opacity .3s;
}

.feature-card:hover::before { opacity: 1; }
.feature-card.f1::before { background: linear-gradient(90deg, transparent, var(--temp), transparent); }
.feature-card.f2::before { background: linear-gradient(90deg, transparent, var(--hum), transparent); }
.feature-card.f3::before { background: linear-gradient(90deg, transparent, var(--amber), transparent); }
.feature-card.f4::before { background: linear-gradient(90deg, transparent, var(--success), transparent); }
.feature-card.f5::before { background: linear-gradient(90deg, transparent, var(--hum), transparent); }
.feature-card.f6::before { background: linear-gradient(90deg, transparent, var(--temp), transparent); }

.feature-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 18px;
}

.feature-icon.temp { background: var(--temp-dim); }
.feature-icon.hum  { background: var(--hum-dim); }
.feature-icon.egg  { background: var(--amber-dim); }
.feature-icon.ok   { background: var(--success-dim); }

.feature-title { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
.feature-desc  { font-size: 13px; color: var(--text-muted); line-height: 1.65; }

.feature-tag {
    display: inline-block;
    margin-top: 14px;
    padding: 3px 10px;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 10px; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: var(--text-dim);
    font-family: var(--font-mono);
}

/* ===== HOW IT WORKS ===== */
.how-section {
    background: var(--bg-card);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.how-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center;
}

.how-steps { display: flex; flex-direction: column; gap: 0; }

.how-step {
    display: flex; gap: 20px;
    padding: 24px 0;
    border-bottom: 1px solid var(--border);
    position: relative;
}
.how-step:last-child { border-bottom: none; }

.step-num {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--bg-elevated);
    border: 1px solid var(--border-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    font-family: var(--font-mono);
    color: var(--amber);
    flex-shrink: 0;
    transition: all .2s;
}

.how-step:hover .step-num {
    background: var(--amber-dim);
    border-color: rgba(245,158,11,.4);
}

.step-content {}
.step-title { font-size: 15px; font-weight: 700; margin-bottom: 5px; }
.step-desc  { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

/* Egg illustration */
.egg-visual {
    display: flex; align-items: center; justify-content: center;
    position: relative;
}

.egg-wrap {
    position: relative; width: 280px; height: 330px;
}

.egg-body {
    width: 200px; height: 240px;
    background: var(--amber-dim);
    border: 2px solid rgba(245,158,11,.2);
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
    margin: 0 auto;
    position: relative; overflow: hidden;
}

.egg-shine {
    position: absolute; top: 14px; left: 30px;
    width: 40px; height: 20px;
    background: rgba(255,255,255,.12);
    border-radius: 50%;
    transform: rotate(-30deg);
}

.egg-ring {
    position: absolute; inset: -14px;
    border: 1px dashed rgba(245,158,11,.15);
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
    animation: rotateSlow 12s linear infinite;
}

.egg-ring-2 {
    position: absolute; inset: -30px;
    border: 1px dashed rgba(96,165,250,.1);
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
    animation: rotateSlow 18s linear infinite reverse;
}

@keyframes rotateSlow { to { transform: rotate(360deg); } }

/* Floating sensor badges */
.sensor-badge {
    position: absolute;
    background: var(--bg-elevated);
    border: 1px solid var(--border-light);
    border-radius: 12px;
    padding: 8px 12px;
    font-size: 11px; font-weight: 700;
    font-family: var(--font-mono);
    display: flex; align-items: center; gap: 6px;
    animation: floatBadge 3s ease-in-out infinite;
}

.sensor-badge.top-left  { top: 20px; left: -20px; animation-delay: 0s; }
.sensor-badge.top-right { top: 30px; right: -10px; animation-delay: .8s; }
.sensor-badge.bot-left  { bottom: 50px; left: -10px; animation-delay: 1.4s; }
.sensor-badge.bot-right { bottom: 60px; right: -15px; animation-delay: .4s; }

@keyframes floatBadge {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-6px); }
}

.badge-dot { width: 7px; height: 7px; border-radius: 50%; }
.badge-dot.temp { background: var(--temp); animation: pulse 2s infinite; }
.badge-dot.hum  { background: var(--hum);  animation: pulse 2s .4s infinite; }
.badge-dot.ok   { background: var(--success); animation: pulse 2s .8s infinite; }
.badge-dot.egg  { background: var(--amber); animation: pulse 2s 1.2s infinite; }

/* ===== SPECS ===== */
.specs-section {}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin-top: 48px;
}

.spec-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 22px 20px;
    transition: border-color .2s;
}

.spec-card:hover { border-color: var(--border-light); }

.spec-icon { font-size: 22px; margin-bottom: 12px; }
.spec-key {
    font-size: 10px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase;
    color: var(--text-dim); font-family: var(--font-mono); margin-bottom: 6px;
}
.spec-val {
    font-size: 20px; font-weight: 800; letter-spacing: -.02em;
    font-family: var(--font-mono); color: var(--amber-light);
}
.spec-unit { font-size: 13px; color: var(--text-muted); font-weight: 400; margin-left: 2px; }

/* ===== TESTIMONIALS ===== */
.testimonials-section {
    background: var(--bg-card);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.testi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-top: 48px;
}

.testi-card {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 24px;
    transition: border-color .2s;
}

.testi-card:hover { border-color: var(--border-light); }

.testi-stars { color: var(--amber); font-size: 13px; margin-bottom: 12px; letter-spacing: 2px; }
.testi-text { font-size: 14px; color: var(--text-muted); line-height: 1.7; margin-bottom: 16px; font-style: italic; }
.testi-author { display: flex; align-items: center; gap: 10px; }

.testi-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--amber-dim);
    border: 1px solid rgba(245,158,11,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: var(--amber);
    font-family: var(--font-mono);
}

.testi-name  { font-size: 13px; font-weight: 700; }
.testi-role  { font-size: 11px; color: var(--text-dim); }

/* ===== CTA ===== */
.cta-section {}

.cta-box {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 64px 40px;
    text-align: center;
    position: relative; overflow: hidden;
}

.cta-box::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--amber), transparent);
}

.cta-box-glow {
    position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
    width: 400px; height: 300px;
    background: radial-gradient(circle, rgba(245,158,11,.08) 0%, transparent 70%);
    pointer-events: none;
}

.cta-title {
    font-size: clamp(26px, 4vw, 42px);
    font-weight: 800; letter-spacing: -.03em;
    margin-bottom: 14px;
}
.cta-desc { font-size: 16px; color: var(--text-muted); margin-bottom: 32px; max-width: 460px; margin-left: auto; margin-right: auto; }
.cta-btns { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }

/* ===== FOOTER ===== */
footer {
    border-top: 1px solid var(--border);
    padding: 32px 24px;
    position: relative; z-index: 1;
}

.footer-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}

.footer-brand { display: flex; align-items: center; gap: 8px; }
.footer-logo { font-size: 14px; font-weight: 800; letter-spacing: -.02em; color: var(--text); }
.footer-logo span { color: var(--amber); }
.footer-copy { font-size: 12px; color: var(--text-dim); font-family: var(--font-mono); }

.footer-links { display: flex; gap: 20px; }
.footer-links a {
    font-size: 12px; color: var(--text-dim);
    text-decoration: none; transition: color .2s;
}
.footer-links a:hover { color: var(--amber); }

/* ===== ANIMATIONS ===== */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Scroll reveal */
.reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity .6s ease, transform .6s ease;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .nav-links { display: none; }
    .btn-nav-outline, .btn-nav-cta { display: none; }
    .hamburger { display: flex; }
    .how-inner { grid-template-columns: 1fr; gap: 48px; }
    .egg-visual { order: -1; }
}

@media (max-width: 640px) {
    .hero { padding: 100px 20px 60px; }
    .mock-cards { grid-template-columns: repeat(2, 1fr); }
    .hero-stats { gap: 20px; }
    .stat-divider { display: none; }
    .section-container { padding: 72px 20px; }
    .cta-box { padding: 40px 24px; }
    .footer-inner { flex-direction: column; align-items: flex-start; }
    .footer-links { flex-wrap: wrap; gap: 14px; }
}

@media (max-width: 400px) {
    .hero-title { font-size: 32px; }
    .mock-cards { grid-template-columns: 1fr 1fr; }
    .sensor-badge { display: none; }
}
</style>
</head>
<body>

<div class="blob-tl"></div>
<div class="blob-br"></div>
<div class="grid-bg"></div>

{{-- ===== NAVBAR ===== --}}
<nav class="navbar">
    <a href="{{ url('/') }}" class="nav-brand">
        <div class="nav-icon">🥚</div>
        <span class="nav-logo-text">Smart<span>Egg</span>Incubator</span>
    </a>

    <ul class="nav-links">
        <li><a href="#features">Fitur</a></li>
        <li><a href="#how">Cara Kerja</a></li>
        <li><a href="#specs">Spesifikasi</a></li>
        {{-- <li><a href="#testimonials">Ulasan</a></li> --}}
    </ul>

    <div class="nav-right">
        <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle tema" id="themeBtn">🌙</button>
        <a href="{{ route('login') }}" class="btn-nav-outline">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-cta">Daftar</a>
        <button class="hamburger" id="hamburger" aria-label="Menu" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile menu --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="#features" onclick="toggleMenu()">Fitur</a>
    <a href="#how" onclick="toggleMenu()">Cara Kerja</a>
    <a href="#specs" onclick="toggleMenu()">Spesifikasi</a>
    {{-- <a href="#testimonials" onclick="toggleMenu()">Ulasan</a> --}}
    <div class="mobile-btns">
        <a href="{{ route('login') }}" class="btn-nav-outline" style="flex:1;text-align:center">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-cta" style="flex:1;text-align:center">Daftar</a>
    </div>
</div>

{{-- ===== HERO ===== --}}
<section class="hero">
    {{-- Big egg background --}}
    <svg class="hero-egg-bg" viewBox="0 0 300 360" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="150" cy="180" rx="130" ry="160" fill="white"/>
    </svg>

    <div class="hero-badge">
        <div class="pulse-dot"></div>
        Monitoring Real-Time 
    </div>

    <h1 class="hero-title">
        Inkubator <br>
         <em>Telur</em> 
    </h1>

    <p class="hero-desc">
        Pantau suhu, kelembapan, dan perputaran telur secara real-time dari mana saja.
        Tingkatkan tingkat penetasan hingga <strong style="color:var(--amber)">95%</strong> dengan otomasi berbasis sensor dan aktuator.
    </p>

    <div class="hero-cta-row">
        {{-- "Mulai Monitoring" diarahkan ke /login --}}
        <a href="{{ route('login') }}" class="btn-hero-primary">
            Mulai Monitoring
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        <a href="#how" class="btn-hero-secondary">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M10 8l4 4-4 4"/></svg>
            Lihat Cara Kerja
        </a>
    </div>

    {{-- Stats --}}
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-value">95%</div>
            <div class="stat-label">Tingkat Penetasan</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">±0.1°C</div>
            <div class="stat-label">Akurasi Suhu</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">24/7</div>
            <div class="stat-label">Monitoring Aktif</div>
        </div>
        {{-- <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">500+</div>
            <div class="stat-label">Pengguna Aktif</div>
        </div> --}}
    </div>

    {{-- Dashboard mockup --}}
    {{-- <div class="hero-visual reveal">
        <div class="dashboard-mockup">
            <div class="mock-topbar">
                <span class="mock-title">🥚 OvoSmart Dashboard</span>
                <span class="mock-badge">
                    <span style="width:6px;height:6px;border-radius:50%;background:var(--success);animation:pulse 2s infinite"></span>
                    Live
                </span>
            </div>
            <div class="mock-cards">
                <div class="mock-card temp">
                    <div class="mock-card-label">Suhu</div>
                    <div class="mock-card-val temp">37.8°C</div>
                </div>
                <div class="mock-card hum">
                    <div class="mock-card-label">Kelembapan</div>
                    <div class="mock-card-val hum">62%</div>
                </div>
                <div class="mock-card egg">
                    <div class="mock-card-label">Hari ke-</div>
                    <div class="mock-card-val egg">14</div>
                </div>
                <div class="mock-card fan">
                    <div class="mock-card-label">Kipas</div>
                    <div class="mock-card-val fan">ON</div>
                </div>
            </div>
            <div class="mock-chart" id="mockChart"></div>
        </div>
    </div> --}}
</section>

{{-- ===== FEATURES ===== --}}
<section class="features-section" id="features">
    <div class="section-container">
        <div class="reveal">
            <div class="section-label">Fitur Unggulan</div>
            <h2 class="section-title">Teknologi di Balik<br>Setiap Penetasan</h2>
            <p class="section-desc">Sensor presisi tinggi dan aktuator otomatis yang bekerja bersama untuk memastikan kondisi optimal selama masa inkubasi.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card f1 reveal">
                <div class="feature-icon temp">🌡</div>
                <div class="feature-title">Kontrol Suhu </div>
                <div class="feature-desc">Sensor DHT22 dengan akurasi ±0.1°C memantau dan mengatur suhu secara otomatis dalam rentang optimal sesuai hari inkubasi</div>
                <span class="feature-tag">DHT22 Sensor</span>
            </div>
            <div class="feature-card f2 reveal">
                <div class="feature-icon hum">💧</div>
                <div class="feature-title">Kontrol Kelembapan</div>
                <div class="feature-desc">Kontrol kelembapan otomatis untuk memastikan keseimbangan air dalam cangkang telur tidak terganggu.</div>
                <span class="feature-tag">Auto Humidifier</span>
            </div>
            <div class="feature-card f3 reveal">
                <div class="feature-icon egg">🔄</div>
                <div class="feature-title">Rotasi Telur Otomatis</div>
                <div class="feature-desc">Servo motor memutar telur setiap interval waktu yang telah ditentukan — mencegah embrio menempel pada cangkang.</div>
                <span class="feature-tag">Servo Motor</span>
            </div>
            <div class="feature-card f4 reveal">
                <div class="feature-icon ok">📊</div>
                <div class="feature-title">Grafik Real-Time</div>
                <div class="feature-desc">Visualisasi data historis suhu dan kelembapan dengan grafik interaktif.</div>
                <span class="feature-tag"> Chart</span>
            </div>
            {{-- <div class="feature-card f5 reveal">
                <div class="feature-icon hum">🔔</div>
                <div class="feature-title">Notifikasi Peringatan</div>
                <div class="feature-desc">Alarm otomatis saat suhu atau kelembapan keluar dari batas aman. Kiriman notifikasi langsung ke perangkat Anda.</div>
                <span class="feature-tag">Alert System</span>
            </div> --}}
            <div class="feature-card f6 reveal">
                <div class="feature-icon temp">📱</div>
                <div class="feature-title">Akses Multi-Perangkat</div>
                <div class="feature-desc">Dashboard responsif yang bisa diakses dari PC, tablet, maupun smartphone kapan saja dan di mana saja.</div>
                <span class="feature-tag">Responsive UI</span>
            </div>
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="how-section" id="how">
    <div class="section-container">
        <div class="how-inner">
            <div>
                <div class="reveal">
                    <div class="section-label">Cara Kerja</div>
                    <h2 class="section-title">Dari Sensor<br>ke Dashboard</h2>
                    <p class="section-desc" style="margin-bottom:32px">Sistem IoT terintegrasi yang menghubungkan IoT langsung ke antarmuka web Anda.</p>
                </div>

                <div class="how-steps">
                    <div class="how-step reveal">
                        <div class="step-num">01</div>
                        <div class="step-content">
                            <div class="step-title">Sensor Membaca Data</div>
                            <div class="step-desc">DHT22 mengukur suhu dan kelembapan setiap 2 detik. Data dikirim ke mikrokontroler ESP32.</div>
                        </div>
                    </div>
                    <div class="how-step reveal">
                        <div class="step-num">02</div>
                        <div class="step-content">
                            <div class="step-title">Data Dikirim via MQTT</div>
                            <div class="step-desc">ESP32 mempublikasikan data ke broker MQTT melalui WiFi secara real-time dengan latensi rendah.</div>
                        </div>
                    </div>
                    <div class="how-step reveal">
                        <div class="step-num">03</div>
                        <div class="step-content">
                            <div class="step-title">Server Memproses & Menyimpan</div>
                            <div class="step-desc">Backend Laravel menerima, memvalidasi, dan menyimpan data ke database untuk analisis historis.</div>
                        </div>
                    </div>
                    <div class="how-step reveal">
                        <div class="step-num">04</div>
                        <div class="step-content">
                            <div class="step-title">Dashboard Menampilkan Live</div>
                            <div class="step-desc">Antarmuka web memperbarui grafik dan angka secara real-time. Anda bisa pantau dan kendalikan dari mana saja.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Egg illustration --}}
            <div class="egg-visual reveal">
                <div class="egg-wrap">
                    <div class="egg-body">
                        <div class="egg-shine"></div>
                        <div class="egg-ring"></div>
                        <div class="egg-ring-2"></div>
                    </div>

                    <div class="sensor-badge top-left">
                        <div class="badge-dot temp"></div>
                        <span style="color:var(--temp)">37.8°C</span>
                    </div>
                    <div class="sensor-badge top-right">
                        <div class="badge-dot hum"></div>
                        <span style="color:var(--hum)">62% RH</span>
                    </div>
                    <div class="sensor-badge bot-left">
                        <div class="badge-dot ok"></div>
                        <span style="color:var(--success)">Hari ke-14</span>
                    </div>
                    <div class="sensor-badge bot-right">
                        <div class="badge-dot egg"></div>
                        <span style="color:var(--amber)">Rotasi Count</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SPECS ===== --}}
<section class="specs-section" id="specs">
    <div class="section-container">
        <div class="reveal" style="text-align:center; max-width:500px; margin:0 auto 0">
            <div class="section-label" style="justify-content:center">Spesifikasi Teknis</div>
            <h2 class="section-title">Dibangun dengan<br>Komponen Terbaik</h2>
        </div>

        <div class="specs-grid" style="margin-top:48px">
            <div class="spec-card reveal">
                <div class="spec-icon">🌡</div>
                <div class="spec-key">Akurasi Suhu</div>
                <div class="spec-val">±0.1<span class="spec-unit">°C</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">💧</div>
                <div class="spec-key">Rentang Kelembapan</div>
                <div class="spec-val">0–100<span class="spec-unit">% RH</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">⏱</div>
                <div class="spec-key">Interval Sampling</div>
                <div class="spec-val">2<span class="spec-unit">detik</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">🔄</div>
                <div class="spec-key">Rotasi Otomatis</div>
                <div class="spec-val">4<span class="spec-unit">×/hari</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">📡</div>
                <div class="spec-key">Protokol</div>
                <div class="spec-val" style="font-size:15px">MQTT</div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">🥚</div>
                <div class="spec-key">Kapasitas Telur</div>
                <div class="spec-val">200<span class="spec-unit">butir</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">🕐</div>
                <div class="spec-key">Masa Inkubasi</div>
                <div class="spec-val">28<span class="spec-unit">hari</span></div>
            </div>
            <div class="spec-card reveal">
                <div class="spec-icon">⚡</div>
                <div class="spec-key">Mikrokontroler</div>
                <div class="spec-val" style="font-size:14px">ESP32</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS ===== --}}
{{-- <section class="testimonials-section" id="testimonials">
    <div class="section-container">
        <div class="reveal" style="text-align:center; max-width:500px; margin:0 auto">
            <div class="section-label" style="justify-content:center">Ulasan Pengguna</div>
            <h2 class="section-title">Dipercaya Peternak<br>di Seluruh Indonesia</h2>
        </div>

        <div class="testi-grid">
            <div class="testi-card reveal">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">"Sejak pakai OvoSmart, tingkat penetasan ayam kampung saya naik dari 70% ke 93%. Dashboard-nya mudah dipahami bahkan oleh istri saya yang baru belajar."</div>
                <div class="testi-author">
                    <div class="testi-avatar">BH</div>
                    <div>
                        <div class="testi-name">Budi Hartono</div>
                        <div class="testi-role">Peternak Ayam, Jawa Tengah</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">"Notifikasi peringatan suhu sangat membantu. Pernah listrik mati tengah malam, langsung dapat alert. Telur selamat semua karena bisa cepat ditangani."</div>
                <div class="testi-author">
                    <div class="testi-avatar">SR</div>
                    <div>
                        <div class="testi-name">Siti Rahayu</div>
                        <div class="testi-role">Peternak Bebek, Jawa Timur</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal">
                <div class="testi-stars">★★★★☆</div>
                <div class="testi-text">"Sangat cocok untuk tugas akhir saya tentang IoT pertanian. Dokumentasinya lengkap, dan data histori dari dashboard bisa diekspor untuk laporan."</div>
                <div class="testi-author">
                    <div class="testi-avatar">AP</div>
                    <div>
                        <div class="testi-name">Ahmad Prasetyo</div>
                        <div class="testi-role">Mahasiswa Teknik, Universitas Brawijaya</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- ===== CTA ===== --}}
<section class="cta-section">
    <div class="section-container">
        <div class="cta-box reveal">
            <div class="cta-box-glow"></div>
            <div style="font-size:48px; margin-bottom:16px">🥚</div>
            <h2 class="cta-title">Mulai Inkubasi Telur</h2>
            <p class="cta-desc">Daftar akun sekarang untuk memantau inkubator Anda.</p>
            <div class="cta-btns">
                {{-- "Daftar Gratis" diarahkan ke /register --}}
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    Daftar Gratis
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('login') }}" class="btn-hero-secondary">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <span style="font-size:20px">🥚</span>
            <span class="footer-logo">Smart<span>Egg</span>Incubator</span>
            <span class="footer-copy" style="margin-left:8px">· v1.0.0 · © {{ date('Y') }}</span>
        </div>
        <div class="footer-links">
            <a href="#features">Fitur</a>
            <a href="#specs">Spesifikasi</a>
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>
</footer>

<script>
// ===== THEME =====
const html = document.documentElement;
const themeBtn = document.getElementById('themeBtn');
let isDark = true;

function setTheme(dark) {
    isDark = dark;
    html.setAttribute('data-theme', dark ? 'dark' : 'light');
    themeBtn.textContent = dark ? '🌙' : '☀️';
}

setTheme(window.matchMedia('(prefers-color-scheme: dark)').matches !== false);

function toggleTheme() { setTheme(!isDark); }

// ===== HAMBURGER =====
function toggleMenu() {
    const hb = document.getElementById('hamburger');
    const mm = document.getElementById('mobileMenu');
    hb.classList.toggle('open');
    mm.classList.toggle('open');
}

// ===== SCROLL REVEAL =====
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('visible'), i * 80);
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.12 });
reveals.forEach(r => observer.observe(r));

// ===== MOCK CHART BARS =====
const chart = document.getElementById('mockChart');
const barData = [55,62,58,70,65,60,68,72,67,63,71,74,69,66,73,70,68,75,72,78];
const colors = ['var(--temp)', 'var(--hum)', 'var(--amber)', 'var(--success)'];
barData.forEach((h, i) => {
    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.cssText = `height:${h}%; background:${colors[i % 4]}; opacity:${0.5 + (i/barData.length)*0.5}; animation-delay:${i*0.04}s`;
    chart.appendChild(bar);
});

// ===== SMOOTH NAV ACTIVE =====
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.navbar');
    if (window.scrollY > 20) {
        nav.style.borderBottomColor = 'var(--border-light)';
    } else {
        nav.style.borderBottomColor = 'var(--border)';
    }
});
</script>
</body>
</html>
