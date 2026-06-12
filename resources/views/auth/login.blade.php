<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalmi Gestion — Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f0c29;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            top: -100px; left: -100px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50%       { transform: scale(1.15); opacity: 1; }
        }

        /* Floating icons */
        .floating-icons {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .float-icon {
            position: absolute;
            color: rgba(255,255,255,0.06);
            font-size: 2rem;
            animation: floatUp 10s linear infinite;
        }

        .float-icon:nth-child(1) { left: 10%; animation-delay: 0s;   font-size: 1.5rem; }
        .float-icon:nth-child(2) { left: 25%; animation-delay: 2s;   font-size: 2.5rem; }
        .float-icon:nth-child(3) { left: 45%; animation-delay: 4s;   font-size: 1.8rem; }
        .float-icon:nth-child(4) { left: 65%; animation-delay: 1s;   font-size: 2rem;   }
        .float-icon:nth-child(5) { left: 80%; animation-delay: 3s;   font-size: 1.5rem; }
        .float-icon:nth-child(6) { left: 55%; animation-delay: 6s;   font-size: 1.2rem; }

        @keyframes floatUp {
            0%   { transform: translateY(110vh) rotate(0deg);   opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh)  rotate(360deg); opacity: 0; }
        }

        .brand-logo {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-logo .icon-wrap {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 20px 40px rgba(99,102,241,0.4);
        }

        .brand-logo .icon-wrap i { font-size: 36px; color: white; }
        .brand-logo h1 { font-size: 2.2rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .brand-logo span { font-size: 2.2rem; font-weight: 300; color: rgba(255,255,255,0.6); }

        .brand-tagline {
            position: relative; z-index: 2;
            color: rgba(255,255,255,0.5);
            font-size: 0.95rem;
            margin-bottom: 60px;
            letter-spacing: 0.5px;
        }

        .stats-grid {
            position: relative; z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            width: 100%;
            max-width: 380px;
        }

        .stat-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 20px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s;
        }

        .stat-card:hover { transform: translateY(-4px); }

        .stat-card .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .stat-card .stat-value { font-size: 1.4rem; font-weight: 700; color: #fff; }
        .stat-card .stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 2px; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 480px;
            min-width: 480px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
        }

        .login-header { width: 100%; margin-bottom: 36px; }
        .login-header h2 { font-size: 1.8rem; font-weight: 800; color: #1e1b4b; }
        .login-header p  { color: #94a3b8; font-size: 0.9rem; margin-top: 6px; }

        .form-group { width: 100%; margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            transition: color 0.3s;
        }

        .input-wrap input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            color: #1e1b4b;
            background: #f9fafb;
            transition: all 0.3s;
            outline: none;
        }

        .input-wrap input:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }

        .input-wrap input:focus + i,
        .input-wrap i:has(+ input:focus) { color: #6366f1; }

        .input-wrap .eye-toggle {
            position: absolute;
            right: 16px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; color: #94a3b8;
            font-size: 16px;
            transition: color 0.3s;
            left: auto;
        }

        .input-wrap .eye-toggle:hover { color: #6366f1; }

        .error-msg {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-check {
            display: flex; align-items: center; gap: 8px;
            cursor: pointer;
        }

        .remember-check input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: #6366f1;
            cursor: pointer;
        }

        .remember-check span { font-size: 0.85rem; color: #6b7280; }

        .forgot-link {
            font-size: 0.85rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #4f46e5; text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(99,102,241,0.35);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-login:hover::before { opacity: 1; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(99,102,241,0.45); }
        .btn-login:active { transform: translateY(0); }
        .btn-login span { position: relative; z-index: 1; }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        .login-footer i { color: #ef4444; margin: 0 3px; }

        /* Alert errors */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #b91c1c;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 24px;
            color: #15803d;
            font-size: 0.875rem;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; min-width: unset; padding: 40px 30px; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="floating-icons">
            <i class="float-icon fas fa-chart-line"></i>
            <i class="float-icon fas fa-shopping-cart"></i>
            <i class="float-icon fas fa-box"></i>
            <i class="float-icon fas fa-truck"></i>
            <i class="float-icon fas fa-money-bill-wave"></i>
            <i class="float-icon fas fa-tags"></i>
        </div>

        <div class="brand-logo">
            <div class="icon-wrap">
                <i class="fas fa-cube"></i>
            </div>
            <h1>Kalmi <span>Gestion</span></h1>
        </div>

        <p class="brand-tagline">Gérez votre activité commerciale en toute simplicité</p>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(99,102,241,0.2);">
                    <i class="fas fa-shopping-cart" style="color: #818cf8;"></i>
                </div>
                <div class="stat-value">Ventes</div>
                <div class="stat-label">Gestion des commandes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(34,197,94,0.2);">
                    <i class="fas fa-truck" style="color: #4ade80;"></i>
                </div>
                <div class="stat-value">Livraisons</div>
                <div class="stat-label">Suivi en temps réel</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(251,146,60,0.2);">
                    <i class="fas fa-box" style="color: #fb923c;"></i>
                </div>
                <div class="stat-value">Stocks</div>
                <div class="stat-label">Inventaire produits</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239,68,68,0.2);">
                    <i class="fas fa-chart-bar" style="color: #f87171;"></i>
                </div>
                <div class="stat-value">Rapports</div>
                <div class="stat-label">Analyses et stats</div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="login-header">
            <h2>Bienvenue 👋</h2>
            <p>Connectez-vous à votre espace de gestion</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert-success" style="width:100%;">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Errors -->
        @if ($errors->any())
            <div class="alert-error" style="width:100%;">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="width:100%;">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label>Adresse email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="votre@email.com"
                           required autofocus autocomplete="username">
                </div>
                @error('email')
                    <div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                    <button type="button" class="eye-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Options -->
            <div class="form-options">
                <label class="remember-check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login">
                <span><i class="fas fa-arrow-right-to-bracket" style="margin-right:8px;"></i>Se connecter</span>
            </button>
        </form>

        <div class="login-footer">
            Fait avec <i class="fas fa-heart"></i> par l'équipe Kalmi Gestion &copy; {{ date('Y') }}
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Focus animation
        document.querySelectorAll('.input-wrap input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.querySelector('i:not(.eye-toggle i)').style.color = '#6366f1';
            });
            input.addEventListener('blur', () => {
                input.parentElement.querySelector('i:not(.eye-toggle i)').style.color = '#94a3b8';
            });
        });
    </script>
</body>
</html>
