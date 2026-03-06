<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIJAFUNG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
</head>
<body>

<div class="bg-panel">
    <div class="logo-wrap">
        <div class="logo-icon"> <img src="{{asset('assets/img/logo.png')}}" alt="" style="height:80px; width:auto;"></div>
        <h1>SIJAFUNG</h1>
        <p>Sistem Informasi Jabatan Fungsional Dosen Perguruan Tinggi</p>
    </div>
    <div class="tagline" style="color: white">
        <div class="tagline-item">
            <div class="tagline-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <span>Pendataan kegiatan Tri Dharma Perguruan Tinggi</span>
        </div>
        <div class="tagline-item">
            <div class="tagline-icon"><i class="fa-solid fa-chart-line"></i></div>
            <span>Simulasi perhitungan angka kredit dosen</span>
        </div>
        <div class="tagline-item">
            <div class="tagline-icon"><i class="fas fa-solid fa-desktop" style="color: whi"></i></div>
            <span>Monitoring kenaikan jabatan fungsional</span>
        </div>
    </div>
</div>

<div class="login-panel">
    <div class="login-box">
        <div class="login-header">
            <h2>Selamat Datang</h2>
            <p>Masuk ke akun SIJAFUNG Anda</p>
        </div>

        @if($errors->any())
            <div style="background:#fdf0ef;border:1px solid #f0b0a8;color:#7a1508;padding:11px 16px;border-radius:8px;font-size:0.85rem;margin-bottom:18px;">
                <i class="fas fa-exclamation-circle" style="margin-right:6px"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="nama@sijafung.ac.id" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt" style="margin-right:8px"></i> Masuk ke SIJAFUNG
            </button>
        </form>

        <div class="demo-accounts">
            <div class="demo-title">🔑 Akun Demo</div>
            <div class="demo-item">
                <span class="demo-role">Admin</span>
                <span class="demo-info"><strong>admin@itbmpolman.ac.id</strong> / admin</span>
            </div>
            <div class="demo-item">
                <span class="demo-role gold">Dosen</span>
                <span class="demo-info"><strong>aslam@itbmpolman.ac.id</strong> / 123456</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>
