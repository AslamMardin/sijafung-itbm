<style>

.hero-bg {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(
            to bottom,
            rgba(0,0,0,0) 0%,
            rgba(58,12,24,0.4) 50%,
            rgba(58,12,24,0.95) 100%
        ),
        url('/assets/img/hero.png');

    background-size: cover;
    background-position: center;
}

.hero-blur {
    position: absolute;
    inset: 0;
    z-index: 1;

    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);

    mask-image: linear-gradient(
        to bottom,
        transparent 0%,
        rgba(0,0,0,0.6) 50%,
        black 100%
    );
}

</style>

<!-- ── HERO ── -->


<section class="hero">
     <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-blur"></div>

    <div class="hero-content">
        <div class="hero-badge">Platform Jabatan Fungsional Terpadu</div>

        <h1 class="hero-title">
            Sistem <em>Cerdas</em><br>
            Jabatan Fungsional<br>
            
        </h1>

        <p class="hero-desc">
            SIJAFUNG membantu dosen mengelola kegiatan Tri Dharma,
            menghitung angka kredit secara otomatis, dan mensimulasikan
            kelayakan kenaikan jabatan fungsional berdasarkan aturan Dikti.
        </p>

        <div class="hero-actions">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dosen.dashboard') }}" class="btn-hero-primary">
                    <i class="fas fa-th-large"></i> Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </a>
            @endauth
            <a href="#fitur" class="btn-hero-outline">
                <i class="fas fa-play-circle"></i> Pelajari Fitur
            </a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat-item">
                <div class="num">4</div>
                <div class="lbl">Tingkat Jabatan</div>
            </div>
            <div class="hero-stat-item">
                <div class="num">3</div>
                <div class="lbl">Kategori Tri Dharma</div>
            </div>
            <div class="hero-stat-item">
                <div class="num">∞</div>
                <div class="lbl">Simulasi AK</div>
            </div>
        </div>
    </div>

    <!-- Floating Cards -->
    <div class="hero-visual">
        <div class="hero-card">
            <div class="hero-card-title">Progress Kenaikan Jabatan</div>
            <div class="hero-card-val">Lektor → <span style="color:var(--gold)">Lektor Kepala</span></div>
            <div class="hero-card-sub">245 / 400 Angka Kredit</div>
            <div class="mini-progress" style="margin-top:14px">
                <div class="mini-progress-fill" style="width:61%"></div>
            </div>
            <div style="text-align:right;font-size:0.72rem;color:rgba(255,255,255,0.5);margin-top:6px">61% terpenuhi</div>
        </div>

        <div class="hero-card">
            <div class="hero-card-title">Angka Kredit Bulan Ini</div>
            <div class="hero-card-val">+35.5 AK</div>
            <div class="hero-card-row">
                <div class="ak-pill">🎓 <span>10</span> Pendidikan</div>
                <div class="ak-pill">🔬 <span>20</span> Penelitian</div>
            </div>
            <div style="margin-top:8px">
                <div class="ak-pill">🤝 <span>5.5</span> Pengabdian</div>
            </div>
        </div>

        <div class="hero-card">
            <div class="hero-card-title">Hasil Simulasi Terbaru</div>
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:50%;background:rgba(26,122,69,0.3);border:2px solid #1a7a45;display:flex;align-items:center;justify-content:center;font-size:1rem">✅</div>
                <div>
                    <div style="color:#fff;font-weight:600;font-size:0.9rem">Memenuhi Syarat</div>
                   <div style="color:rgba(255,255,255,0.5);font-size:0.75rem">
    Simulasi {{ date('Y') }}-{{ date('Y') + 1 }}
</div>
                </div>
            </div>
        </div>
    </div>
</section>