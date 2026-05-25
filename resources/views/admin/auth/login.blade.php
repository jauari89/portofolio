<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Jauari Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.6.1/dist/css/coreui.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at 20% 15%, rgba(37, 99, 235, .36), transparent 32rem),
                linear-gradient(135deg, #212631, #111827);
            display: grid;
            place-items: center;
        }

        .login-card {
            width: min(100%, 440px);
            border: 0;
            border-radius: .5rem;
            box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, .3);
        }

        .brand-mark {
            width: 3rem;
            height: 3rem;
            display: inline-grid;
            place-items: center;
            border-radius: .75rem;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: #fff;
            font-weight: 800;
        }

        .btn-primary {
            --cui-btn-bg: #2563eb;
            --cui-btn-border-color: #2563eb;
            --cui-btn-hover-bg: #1d4ed8;
            --cui-btn-hover-border-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="card login-card mx-auto">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="brand-mark">JA</span>
                    <div>
                        <h1 class="h4 fw-bold mb-1">Admin Login</h1>
                        <p class="text-muted mb-0">Kelola landing page dan konten portofolio.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-1"></i>Login</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
