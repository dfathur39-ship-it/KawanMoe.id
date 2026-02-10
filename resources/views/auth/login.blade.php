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
        :root { --primary-color: #6366f1; --primary-dark: #4f46e5; --secondary-color: #ec4899; --bg-dark: #0f172a; --bg-card: #1e293b; --border-dark: #334155; --text-primary: #f1f5f9; --text-muted: #94a3b8; }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; background: var(--bg-dark); display: flex; align-items: center; justify-content: center; padding: 2rem; color: var(--text-primary); }
        .login-container { width: 100%; max-width: 450px; }
        .login-card { background: var(--bg-card); border: 1px solid var(--border-dark); border-radius: 24px; padding: 3rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .brand-logo { width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .brand-logo i { font-size: 2.5rem; color: white; }
        .brand-title { font-size: 1.75rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .brand-subtitle { text-align: center; color: var(--text-muted); margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; }
        .form-control { border-radius: 12px; padding: 0.875rem 1rem; border: 2px solid var(--border-dark); background: var(--bg-dark); color: var(--text-primary); }
        .form-control::placeholder { color: var(--text-muted); }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2); background: var(--bg-dark); color: var(--text-primary); }
        .input-group-text { border-radius: 12px 0 0 12px; border: 2px solid var(--border-dark); border-right: none; background: var(--bg-dark); color: var(--text-muted); }
        .input-group .form-control { border-radius: 0; border-left: none; }
        .input-group .form-control:last-child { border-radius: 0 12px 12px 0; }
        .input-group .btn-password-toggle { border-radius: 0 12px 12px 0; border: 2px solid var(--border-dark); border-left: none; }
        .btn-login { width: 100%; padding: 0.875rem; font-size: 1rem; font-weight: 600; border-radius: 12px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border: none; color: white; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4); color: white; }
        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; color: var(--text-muted); font-size: 0.875rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border-dark); }
        .register-link { text-align: center; color: var(--text-muted); }
        .register-link a { color: #93c5fd; font-weight: 600; text-decoration: none; }
        .register-link a:hover { color: #bfdbfe; }
        .form-check-label { color: var(--text-primary); }
        .alert { border: 1px solid var(--border-dark); }
        .btn-password-toggle { cursor: pointer; color: var(--text-muted); border-color: var(--border-dark); background: var(--bg-dark); }
        .btn-password-toggle:hover { color: var(--text-primary); }
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
                        <button type="button" class="input-group-text btn-password-toggle" tabindex="-1" aria-label="Tampilkan password" title="Tampilkan password"><i class="bi bi-eye"></i></button>
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
    <script>
        document.querySelectorAll('.btn-password-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var wrap = this.closest('.input-group');
                var input = wrap && wrap.querySelector('input');
                if (!input) return;
                var icon = this.querySelector('i');
                if (input.type === 'password') { input.type = 'text'; icon.classList.replace('bi-eye', 'bi-eye-slash'); this.setAttribute('aria-label', 'Sembunyikan password'); }
                else { input.type = 'password'; icon.classList.replace('bi-eye-slash', 'bi-eye'); this.setAttribute('aria-label', 'Tampilkan password'); }
            });
        });
    </script>
</body>
</html>
