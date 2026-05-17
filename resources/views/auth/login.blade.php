<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Texoffice ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            padding: 48px;
            width: 100%;
            max-width: 420px;
        }
        .brand-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #1e3a5f, #c75b39);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            margin: 0 auto 24px;
        }
        .form-control {
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #1e3a5f;
            box-shadow: 0 0 0 4px rgba(30,58,95,0.1);
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a5f, #2c5282);
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30,58,95,0.3);
        }
        .input-group-text {
            background: transparent;
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-icon">
        <i class="bi bi-layers-fill"></i>
    </div>
    <h3 class="text-center fw-bold mb-1" style="color:#1e3a5f;">Texoffice</h3>
    <p class="text-center text-muted mb-4">ERP Gestion Textile</p>

    @if($errors->any())
        <div class="alert alert-danger rounded-3" style="font-size:0.9rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Email</label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="border-radius:12px 0 0 12px; border-right:none;">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0" style="border-radius:0 12px 12px 0;" placeholder="Votre email" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="border-radius:12px 0 0 12px; border-right:none;">
                    <i class="bi bi-lock text-muted"></i>
                </span>
                <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0" style="border-radius:0;" placeholder="••••••••" required>
                <span class="input-group-text border-start-0" style="border-radius:0 12px 12px 0; cursor:pointer;" onclick="togglePassword()">
                    <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
        </button>
            <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
        Pas encore de compte ? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#1e3a5f;">Créer un compte</a>
    </p>
    </form>

    <p class="text-center text-muted mt-4 mb-0" style="font-size:0.8rem;">
        © 2026 Texoffice - OFPPT ISTA
    </p>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>

</body>
</html>