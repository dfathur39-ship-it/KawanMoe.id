<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Absensi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #6366f1; --primary-dark: #4f46e5; }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .register-container { width: 100%; max-width: 480px; }
        .register-card { background: white; border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .brand-logo { width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary-color) 0%, #ec4899 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .brand-logo i { font-size: 2rem; color: white; }
        .brand-title { font-size: 1.5rem; font-weight: 800; text-align: center; margin-bottom: 0.25rem; background: linear-gradient(135deg, var(--primary-color) 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .brand-subtitle { text-align: center; color: #64748b; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .form-label { font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 10px; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .btn-register { width: 100%; padding: 0.875rem; font-weight: 600; border-radius: 12px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border: none; color: white; }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4); }
        .login-link { text-align: center; color: #64748b; margin-top: 1.5rem; }
        .login-link a { color: var(--primary-color); font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="brand-logo"><i class="bi bi-person-plus-fill"></i></div>
            <h1 class="brand-title">Daftar Akun Siswa</h1>
            <p class="brand-subtitle">Gunakan NIS yang sudah terdaftar di sekolah. Admin tidak bisa mendaftar dari sini.</p>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa" value="{{ old('nis') }}" required>
                    <small class="text-muted">NIS harus sudah didaftarkan admin di Data Siswa</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-register"><i class="bi bi-person-plus me-2"></i>Daftar Sekarang</button>
            </form>
            <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>
</body>
</html>
