<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Pro/logo/TRY.png') }}" height="200px"  whidt="200px" />

    <title>Connexion - {{ config('app.name', 'APP | AUTOGEST') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #ffffff;
            color: #333;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 0;
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #e6f2ff 100%);
            overflow: hidden;
        }

        /* Floating Orbs Animation */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.1;
            animation: float 25s infinite ease-in-out;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #0066cc, #00d4ff);
            top: -15%;
            left: -10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            bottom: -15%;
            right: -10%;
            animation-delay: 7s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #0066cc, #2563eb);
            top: 50%;
            left: 40%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(60px, -60px) scale(1.1);
            }
            66% {
                transform: translate(-40px, 40px) scale(0.9);
            }
        }

        /* Animated Grid Pattern */
        .grid-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 102, 204, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 102, 204, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 30s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(60px, 60px);
            }
        }

        /* Wave Animation for Logo Section */
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            overflow: hidden;
            pointer-events: none;
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background-repeat: repeat-x;
            animation: wave 15s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite;
        }

        .wave:nth-child(1) {
            background: linear-gradient(90deg, transparent, rgba(0, 102, 204, 0.1), transparent);
            animation-duration: 18s;
            opacity: 0.4;
        }

        .wave:nth-child(2) {
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.08), transparent);
            animation-duration: 12s;
            animation-delay: -5s;
            opacity: 0.3;
        }

        .wave:nth-child(3) {
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.06), transparent);
            animation-duration: 20s;
            animation-delay: -2s;
            opacity: 0.2;
        }

        @keyframes wave {
            0% {
                transform: translateX(0) translateY(0);
            }
            50% {
                transform: translateX(-25%) translateY(-15px);
            }
            100% {
                transform: translateX(-50%) translateY(0);
            }
        }

        /* Ripple Effect Behind Logo */
        .ripple-container {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .ripple {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px solid rgba(0, 102, 204, 0.2);
            border-radius: 50%;
            animation: ripple 4s ease-out infinite;
        }

        .ripple:nth-child(2) {
            animation-delay: 1.3s;
        }

        .ripple:nth-child(3) {
            animation-delay: 2.6s;
        }

        @keyframes ripple {
            0% {
                width: 300px;
                height: 300px;
                opacity: 1;
            }
            100% {
                width: 800px;
                height: 800px;
                opacity: 0;
            }
        }

        /* Main Container */
        .login-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        /* Left Section - Logo */
        .brand-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            overflow: hidden;
        }

        /* Glow effect behind logo */
        .brand-section::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 102, 204, 0.08) 0%, transparent 70%);
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        .logo-container {
            text-align: center;
            animation: fadeInScale 1.2s ease-out;
            position: relative;
            z-index: 2;
        }

        .main-logo {
            position: relative;
            animation: logoFloat 6s ease-in-out infinite;
        }

        .main-logo img {
            max-width: 650px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 25px 50px rgba(0, 102, 204, 0.15));
            transition: all 0.5s ease;
        }

        .main-logo:hover img {
            transform: scale(1.08);
            filter: drop-shadow(0 30px 60px rgba(0, 102, 204, 0.25));
        }

        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #0066cc;
            border-radius: 50%;
            animation: sparkle 3s ease-in-out infinite;
            opacity: 0;
        }

        .sparkle:nth-child(1) {
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }

        .sparkle:nth-child(2) {
            top: 40%;
            right: 20%;
            animation-delay: 1s;
        }

        .sparkle:nth-child(3) {
            bottom: 30%;
            left: 25%;
            animation-delay: 2s;
        }

        @keyframes sparkle {
            0%, 100% {
                opacity: 0;
                transform: scale(0);
            }
            50% {
                opacity: 1;
                transform: scale(1.5);
            }
        }

        /* Right Section - Form */
        .form-section {
            width: 540px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            box-shadow: -8px 0 40px rgba(0, 0, 0, 0.06);
        }

        /* Decorative line */
        .form-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: linear-gradient(180deg, transparent, #0066cc, transparent);
            border-radius: 0 2px 2px 0;
        }

        .form-wrapper {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.8s ease-out 0.3s backwards;
        }

        .form-header {
            margin-bottom: 50px;
        }

        .form-header h2 {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1e293b;
            letter-spacing: -0.5px;
            position: relative;
            display: inline-block;
        }

        .form-header h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #0066cc, #00d4ff);
            border-radius: 2px;
        }

        .form-header p {
            color: #64748b;
            font-size: 15px;
            font-weight: 400;
            margin-top: 16px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 15px;
            font-weight: 400;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-control:hover {
            border-color: #cbd5e1;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #0066cc;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
            transform: translateY(-2px);
        }

        .form-group:focus-within label {
            color: #0066cc;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* Input line animation */
        .input-line {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0066cc, #00d4ff);
            transition: width 0.4s ease;
            border-radius: 2px;
        }

        .form-control:focus ~ .input-line {
            width: 100%;
        }

        /* Remember Me */
        .remember-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 32px 0;
        }

        .remember-left {
            display: flex;
            align-items: center;
        }

        .custom-checkbox {
            position: relative;
            width: 22px;
            height: 22px;
            margin-right: 12px;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            width: 22px;
            height: 22px;
            border: 2px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .custom-checkbox:hover .checkmark {
            border-color: #0066cc;
            transform: scale(1.1);
        }

        .custom-checkbox input:checked ~ .checkmark {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            border-color: #0066cc;
        }

        .checkmark::after {
            content: '';
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2.5px 2.5px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox input:checked ~ .checkmark::after {
            display: block;
        }

        .remember-label {
            font-size: 14px;
            color: #475569;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #0066cc;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #20254B, #00d4ff);
            transition: width 0.3s ease;
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        .forgot-link:hover {
            color: #0052a3;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 40px;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: #ffffff;
            padding: 17px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 102, 204, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* Footer */
        .form-footer {
            margin-top: 45px;
            padding-top: 28px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .form-footer p {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 400;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 1199px) {
            .brand-section {
                padding: 50px;
            }
            .main-logo img {
                max-width: 550px;
            }
            .form-section {
                width: 500px;
                padding: 50px 40px;
            }
        }

        @media (max-width: 991px) {
            .login-container {
                flex-direction: column;
            }
            .brand-section {
                padding: 60px 40px;
                min-height: 50vh;
            }
            .main-logo img {
                max-width: 500px;
            }
            .form-section {
                width: 100%;
                padding: 50px 40px;
                box-shadow: 0 -8px 40px rgba(0, 0, 0, 0.06);
            }
            .form-section::before {
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 60%;
                height: 4px;
            }
        }

        @media (max-width: 767px) {
            .brand-section {
                padding: 50px 30px;
                min-height: 40vh;
            }
            .main-logo img {
                max-width: 400px;
            }
            .form-section {
                padding: 40px 30px;
            }
            .form-header h2 {
                font-size: 30px;
            }
        }

        @media (max-width: 575px) {
            .brand-section {
                padding: 40px 25px;
            }
            .main-logo img {
                max-width: 300px;
            }
            .form-section {
                padding: 40px 25px;
            }
            .form-header h2 {
                font-size: 28px;
            }
            .remember-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        /* Selection color */
        ::selection {
            background: rgba(0, 102, 204, 0.2);
            color: #1e293b;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-background">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="grid-pattern"></div>
    </div>

    <!-- Main Container -->
    <div class="login-container">
        <!-- Brand Section -->
        <div class="brand-section">
            <!-- Ripple Effect -->
            <div class="ripple-container">
                <div class="ripple"></div>
                <div class="ripple"></div>
                <div class="ripple"></div>
            </div>

            <!-- Wave Container -->
            <div class="wave-container">
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </div>

            <div class="logo-container">
                <div class="main-logo">
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                    <img src="Pro/logo/1.png" alt="Logo Plateforme">
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Bienvenue</h2>
                    <p>Connectez-vous à votre espace académique</p>
                </div>

                  <form method="POST" action="{{ route('login') }}">
                       @csrf
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control"
                                placeholder="exemple@universite.edu"
                                required
                                autofocus
                            >
                            <div class="input-line"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control"
                                placeholder="Entrez votre mot de passe"
                                required
                            >
                            <div class="input-line"></div>
                        </div>
                    </div>

                    <div class="remember-wrapper">
                        <div class="remember-left">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="remember" id="remember">
                                <span class="checkmark"></span>
                            </label>
                            <label for="remember" class="remember-label">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-login">Se connecter</button>
                    </div>
                </form>

                <div class="form-footer">
                    <p>© 2025 {{ config('app.name', 'APP | AUTOGEST') }}. Tous droits réservés</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>