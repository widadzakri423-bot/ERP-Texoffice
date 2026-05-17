<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Texoffice ERP</title>
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
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            padding: 48px;
            width: 100%;
            max-width: 480px;
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
        .form-control, .form-select {
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1e3a5f;
            box-shadow: 0 0 0 4px rgba(30,58,95,0.1);
        }
        .btn-register {
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
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30,58,95,0.3);
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="brand-icon">
        <i class="bi bi-layers-fill"></i>
    </div>
    <h3 class="text-center fw-bold mb-1" style="color:#1e3a5f;">Créer un compte</h3>
    <p class="text-center text-muted mb-4">Texoffice ERP</p>

    @if($errors->any())
        <div class="alert alert-danger rounded-3" style="font-size:0.9rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Nom complet *</label>
            <div class="input-group">
                <span class="input-group-text border-end-0 bg-white" style="border-radius:12px 0 0 12px; border-right:none;">
                    <i class="bi bi-person text-muted"></i>
                </span>
                <input type="text" name="name" class="form-control border-start-0" style="border-radius:0 12px 12px 0;" placeholder="Votre nom" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Email *</label>
            <div class="input-group">
                <span class="input-group-text border-end-0 bg-white" style="border-radius:12px 0 0 12px; border-right:none;">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0" style="border-radius:0 12px 12px 0;" placeholder="Votre email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Rôle *</label>
            <select name="role" class="form-select" required>
                <option value="">Choisir un rôle...</option>
                <option value="administrateur" {{ old('role') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                <option value="commercial" {{ old('role') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                <option value="magasinier" {{ old('role') == 'magasinier' ? 'selected' : '' }}>Magasinier</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Mot de passe *</label>
            <input type="password" name="password" class="form-control" placeholder="Minimum 6 caractères" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:0.9rem; color:#475569;">Confirmer le mot de passe *</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Répéter le mot de passe" required>
        </div>

        <button type="submit" class="btn-register">
            <i class="bi bi-person-plus me-2"></i> Créer mon compte
        </button>
    </form>

    <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
        Déjà un compte ? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#1e3a5f;">Se connecter</a>
    </p>
</div>

</body>
</html>