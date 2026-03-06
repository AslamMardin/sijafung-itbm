<section class="cta-section">
    <div style="position:relative;z-index:1" class="reveal">
        <h2 class="section-title">Kelola Jabatan Fungsional Anda<br>Lebih <em style="color: yellow">Cerdas & Efisien</em></h2>
        <p class="section-desc">Bergabunglah dan rasakan kemudahan mengelola angka kredit serta merencanakan karir akademik Anda.</p>
        <div class="cta-buttons">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dosen.dashboard') }}" class="btn-hero-primary">
                    <i class="fas fa-th-large"></i> Buka Dashboard Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke SIJAFUNG
                </a>
              
            @endauth
        </div>
    </div>
</section>