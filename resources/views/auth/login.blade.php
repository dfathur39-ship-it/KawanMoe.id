<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #6366f1; --primary-dark: #4f46e5; --secondary-color: #ec4899; }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .login-container { width: 100%; max-width: 450px; }
        .login-card { background: white; border-radius: 24px; padding: 3rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .brand-logo { width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .brand-logo i { font-size: 2.5rem; color: white; }
        .brand-title { font-size: 1.75rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .brand-subtitle { text-align: center; color: #64748b; margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
        .form-control { border-radius: 12px; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .input-group-text { border-radius: 12px 0 0 12px; border: 2px solid #e2e8f0; border-right: none; background: #f8fafc; }
        .input-group .form-control { border-radius: 0 12px 12px 0; border-left: none; }
        .btn-login { width: 100%; padding: 0.875rem; font-size: 1rem; font-weight: 600; border-radius: 12px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border: none; color: white; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4); }
        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; color: #94a3b8; font-size: 0.875rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .register-link { text-align: center; color: #64748b; }
        .register-link a { color: var(--primary-color); font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
            <h1 class="brand-title">Absensi Siswa</h1>
            <p class="brand-subtitle">Login untuk Admin atau Siswa</p>
            @if($errors->any())
                <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-login"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</button>
            </form>
            <div class="divider">atau</div>
            <p class="register-link">Siswa belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
