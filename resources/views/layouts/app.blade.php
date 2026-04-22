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
    <style>
        /* Submenu Styles for SISTER Menu Structure */
        .nav-submenu {
            padding: 4px 0 8px;
            margin-bottom: 4px;
            background: rgba(0,0,0,0.1);
            border-radius: 8px;
            margin: 4px 10px;
        }
        .nav-submenu-title {
            font-size: 0.65rem;
            padding: 8px 16px 4px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .nav-submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s;
            border-radius: 6px;
            margin: 2px 8px;
        }
        .nav-submenu-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(3px);
        }
        .nav-submenu-link.active {
            background: rgba(201,168,76,0.15);
            color: #C9A84C;
            font-weight: 600;
        }
        .nav-submenu-link i {
            width: 16px;
            text-align: center;
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        /* Custom Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(107,15,26,0.15);
            border-radius: 10px;
            transition: background 0.3s;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(107,15,26,0.3);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-nav {
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }
    </style>
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
                <a href="{{ route('admin.verifikasi.index') }}"
                    class="nav-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Verifikasi Kegiatan
                    @php $pendingNew = \App\Models\PelaksanaanPendidikan::where('status','Pending')->count() + \App\Models\PelaksanaanPenelitian::where('status','Pending')->count() + \App\Models\PelaksanaanPengabdian::where('status','Pending')->count() @endphp
                    @if ($pendingNew > 0)
                        <span class="nav-badge badge-maroon">{{ $pendingNew }}</span>
                    @endif
                </a>
            @else
                {{-- MENU DOSEN - STRUKTUR SISTER --}}
                <div class="nav-section-label">Menu Utama</div>
                <a href="{{ route('dosen.dashboard') }}"
                    class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                
                {{-- PELAKSANAAN PENDIDIKAN --}}
                <div class="nav-section-label">Pelaksanaan Pendidikan</div>
                
                <a href="{{ route('dosen.pendidikan.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.pendidikan.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Daftar Kegiatan
                    @php $pendPending = auth()->user()->pelaksanaanPendidikan()->where('status','Pending')->count() @endphp
                    @if($pendPending > 0)
                        <span class="nav-badge">{{ $pendPending }}</span>
                    @endif
                </a>
                
                <div class="nav-submenu">
                    <div class="nav-submenu-title" style="font-size: 0.7rem; padding: 6px 12px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px;">
                        Input Kegiatan
                    </div>
                    <a href="{{ route('dosen.pendidikan.create', 'pengajaran') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'pengajaran' ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i> Pengajaran
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'bimbingan') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'bimbingan' ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Bimbingan Mahasiswa
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'pengujian') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'pengujian' ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i> Pengujian Mahasiswa
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'bahan_ajar') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'bahan_ajar' ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Bahan Ajar
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'pembinaan') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'pembinaan' ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Pembinaan Mahasiswa
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'visiting_scientist') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'visiting_scientist' ? 'active' : '' }}">
                        <i class="fas fa-plane"></i> Visiting Scientist
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'detasering') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'detasering' ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i> Detasering
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'orasi_ilmiah') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'orasi_ilmiah' ? 'active' : '' }}">
                        <i class="fas fa-microphone"></i> Orasi Ilmiah
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'pembimbing_dosen') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'pembimbing_dosen' ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Pembimbing Dosen
                    </a>
                    <a href="{{ route('dosen.pendidikan.create', 'tugas_tambahan') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pendidikan.create') && request()->route('jenisKegiatan') === 'tugas_tambahan' ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i> Tugas Tambahan
                    </a>
                </div>
                
                {{-- PELAKSANAAN PENELITIAN --}}
                <div class="nav-section-label">Pelaksanaan Penelitian</div>
                
                <a href="{{ route('dosen.penelitian.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.penelitian.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Daftar Kegiatan
                    @php $penelitianPending = auth()->user()->pelaksanaanPenelitian()->where('status','Pending')->count() @endphp
                    @if($penelitianPending > 0)
                        <span class="nav-badge">{{ $penelitianPending }}</span>
                    @endif
                </a>
                
                <div class="nav-submenu">
                    <div class="nav-submenu-title" style="font-size: 0.7rem; padding: 6px 12px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px;">
                        Input Kegiatan
                    </div>
                    <a href="{{ route('dosen.penelitian.create', 'penelitian') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.penelitian.create') && request()->route('jenisKegiatan') === 'penelitian' ? 'active' : '' }}">
                        <i class="fas fa-flask"></i> Penelitian
                    </a>
                    <a href="{{ route('dosen.penelitian.create', 'publikasi_karya') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.penelitian.create') && request()->route('jenisKegiatan') === 'publikasi_karya' ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Publikasi Karya
                    </a>
                    <a href="{{ route('dosen.penelitian.create', 'paten_hki') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.penelitian.create') && request()->route('jenisKegiatan') === 'paten_hki' ? 'active' : '' }}">
                        <i class="fas fa-copyright"></i> Paten/HKI
                    </a>
                </div>
                
                {{-- PELAKSANAAN PENGABDIAN --}}
                <div class="nav-section-label">Pelaksanaan Pengabdian</div>
                
                <a href="{{ route('dosen.pengabdian.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.pengabdian.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Daftar Kegiatan
                    @php $pengabdianPending = auth()->user()->pelaksanaanPengabdian()->where('status','Pending')->count() @endphp
                    @if($pengabdianPending > 0)
                        <span class="nav-badge">{{ $pengabdianPending }}</span>
                    @endif
                </a>
                
                <div class="nav-submenu">
                    <div class="nav-submenu-title" style="font-size: 0.7rem; padding: 6px 12px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px;">
                        Input Kegiatan
                    </div>
                    <a href="{{ route('dosen.pengabdian.create', 'pengabdian') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pengabdian.create') && request()->route('jenisKegiatan') === 'pengabdian' ? 'active' : '' }}">
                        <i class="fas fa-hands-helping"></i> Pengabdian
                    </a>
                    <a href="{{ route('dosen.pengabdian.create', 'pembicara') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pengabdian.create') && request()->route('jenisKegiatan') === 'pembicara' ? 'active' : '' }}">
                        <i class="fas fa-microphone-alt"></i> Pembicara
                    </a>
                    <a href="{{ route('dosen.pengabdian.create', 'pengelola_jurnal') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pengabdian.create') && request()->route('jenisKegiatan') === 'pengelola_jurnal' ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> Pengelola Jurnal
                    </a>
                    <a href="{{ route('dosen.pengabdian.create', 'jabatan_struktural') }}"
                        class="nav-submenu-link {{ request()->routeIs('dosen.pengabdian.create') && request()->route('jenisKegiatan') === 'jabatan_struktural' ? 'active' : '' }}">
                        <i class="fas fa-building"></i> Jabatan Struktural
                    </a>
                </div>
                
                {{-- SIMULASI --}}
                <div class="nav-section-label">Simulasi</div>
                <a href="{{ route('dosen.simulasi.index') }}"
                    class="nav-link {{ request()->routeIs('dosen.simulasi.index') || request()->routeIs('dosen.simulasi.show') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i> Simulasi Angka Kredit
                </a>
                <a href="{{ route('dosen.simulasi.create') }}" 
                    class="nav-link {{ request()->routeIs('dosen.simulasi.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Buat Simulasi Baru
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
