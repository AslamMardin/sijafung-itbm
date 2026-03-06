<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIJAFUNG') — Sistem Jabatan Fungsional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')
</head>

<body>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon"><img src="{{ asset('assets/img/logo.png') }}" alt=""
                        style="height:40px; width:auto;"></div>
                <div class="brand-text">
                    <h1>SIJAFUNG</h1>
                    <span>Sistem Jabatan Fungsional</span>
                </div>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="user-info">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ ucfirst(auth()->user()->role) }}</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if (auth()->user()->isAdmin())
                <div class="nav-section-label">Menu Utama</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <div class="nav-section-label">Manajemen</div>
                <a href="{{ route('admin.dosen.index') }}"
                    class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i> Data Dosen
                </a>
                <a href="{{ route('admin.kegiatan.index') }}"
                    class="nav-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Kegiatan Tri Dharma
                    @php $pending = \App\Models\KegiatanTriDharma::where('status','Pending')->count() @endphp
                    @if ($pending > 0)
                        <span class="nav-badge">{{ $pending }}</span>
                    @endif
                </a>
            @else
                <div class="nav-section-label">Menu Utama</div>
                <a href="{{ route('dosen.dashboard') }}"
                    class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <div class="nav-section-label">Tri Dharma</div>
                <a href="{{ route('dosen.kegiatan.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.kegiatan.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Kegiatan Saya
                </a>
                <a href="{{ route('dosen.kegiatan.create') }}"
                    class="nav-link {{ request()->routeIs('dosen.kegiatan.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Input Kegiatan
                </a>
                <div class="nav-section-label">Simulasi</div>
                <a href="{{ route('dosen.simulasi.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.simulasi.*') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i> Simulasi Angka Kredit
                </a>
                <a href="{{ route('dosen.simulasi.create') }}" class="nav-link">
                    <i class="fas fa-flask"></i> Buat Simulasi Baru
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-wrap">
        <header class="topbar">
            <button class="topbar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-breadcrumb">
                @yield('breadcrumb')
            </div>
            <div class="topbar-right">
                <span class="topbar-date">
                    <i class="far fa-calendar-alt" style="margin-right:5px"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        <main class="page-content">
            @if (session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>

</html>
