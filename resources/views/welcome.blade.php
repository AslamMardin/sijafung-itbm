<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIJAFUNG — Sistem Informasi Jabatan Fungsional Dosen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>

<!-- ── NAVBAR ── -->
<nav id="navbar">
    <a href="#" class="nav-brand">
        <img src="{{asset('assets/img/logo.png')}}" alt="" style="height:40px; width:auto;">
        <div class="nav-brand-text">
            <h1>SIJAFUNG</h1>
            <span>Jabatan Fungsional Dosen</span>
        </div>
    </a>
    <ul class="nav-links">
        <li><a href="#fitur">Fitur</a></li>
        <li><a href="#tri-dharma">Tri Dharma</a></li>
        <li><a href="#jabatan">Jabatan</a></li>
        @auth
            <li><a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dosen.dashboard') }}" class="nav-cta">Dashboard</a></li>
        @else
            <li><a href="{{ route('login') }}" class="nav-cta">Masuk ke SIJAFUNG</a></li>
        @endauth
    </ul>
</nav>

@include('home.hero')

@include('home.fitur')

@include('home.tri')

<!-- ── JABATAN FUNGSIONAL ── -->
@include('home.jabatan')


<!-- ── CTA ── -->
@include('home.cta')

<!-- ── FOOTER ── -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <div style="width:40px;height:40px;background:white;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem"> <img src="{{asset('assets/img/logo.png')}}" alt="" style="height:40px; width:auto;"></div>
                <h2>SIJAFUNG</h2>
            </div>
            <p>Sistem Informasi Jabatan Fungsional Dosen — Platform digital untuk pengelolaan angka kredit dan simulasi kenaikan jabatan fungsional dosen perguruan tinggi Indonesia.</p>
        </div>
        <div class="footer-col">
            <h4>Menu</h4>
            <ul>
                <li><a href="#fitur">Fitur Sistem</a></li>
                <li><a href="#tri-dharma">Tri Dharma</a></li>
                <li><a href="#jabatan">Jabatan Fungsional</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Referensi</h4>
            <ul>
                <li><a >Permenpan-RB No. 17/2013</a></li>
                <li><a >Pedoman Angka Kredit Dikti</a></li>
                <li><a >Panduan Pengusulan JAD</a></li>
                <li><a >SK BAN-PT</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} SIJAFUNG — Sistem Informasi Jabatan Fungsional Dosen</span>
        <span>Dikembangkan oleh <span style="color:var(--gold)">♥</span> Tim Prodi Informatika</span>
    </div>
</footer>

<script>
// Navbar scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
});

// Scroll reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            // Stagger children
            e.target.querySelectorAll('.feature-card, .dharma-card, .jab-step, .role-card').forEach((el, i) => {
                el.style.transitionDelay = `${i * 0.1}s`;
                el.classList.add('reveal', 'visible');
            });
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Counter animation for hero stats
const counters = document.querySelectorAll('.hero-stat-item .num');
const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting && e.target.dataset.target) {
            const target = parseInt(e.target.dataset.target);
            let current = 0;
            const step = target / 40;
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                e.target.textContent = Math.round(current);
                if (current >= target) clearInterval(timer);
            }, 30);
        }
    });
}, { threshold: 0.5 });
counters.forEach(c => countObserver.observe(c));
</script>

</body>
</html>