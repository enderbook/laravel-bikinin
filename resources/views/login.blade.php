<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="logoweb.png">
    <title>Login | Freelancer Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff8000;
            --secondary-color: #ff9933;
            --accent-color: #e67300;
            --dark-color: #2f3640;
            --light-color: #f5f6fa;
            --error-color: #e74a3b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
                              url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Error message styling */
        .alert-error {
            background-color: rgba(231, 74, 59, 0.1);
            border-left: 4px solid var(--error-color);
            color: var(--error-color);
            border-radius: 6px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .alert-error i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Rest of your existing styles... */
        /* Floating work animations */
        .floating-work {
            position: fixed;
            z-index: 0;
            font-size: 1.5rem;
            opacity: 0;
            pointer-events: none;
            animation: float 12s linear infinite;
            bottom: -50px;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% {
                transform: translateY(-120vh) translateX(20vw) rotate(180deg);
                opacity: 0;
            }
        }

        /* Work icons colors and positions */
        .design { color: #ff8000; left: 5%; animation-duration: 15s; }
        .code { color: #e67300; left: 15%; animation-delay: 2s; animation-duration: 18s; }
        .writing { color: #36b9cc; left: 25%; animation-delay: 4s; animation-duration: 16s; }
        .marketing { color: #1cc88a; left: 35%; animation-delay: 1s; animation-duration: 17s; }
        .video { color: #f6c23e; left: 45%; animation-delay: 3s; animation-duration: 19s; }
        .business { color: #e74a3b; left: 55%; animation-delay: 5s; animation-duration: 14s; }
        .translate { color: #6610f2; left: 65%; animation-delay: 2.5s; animation-duration: 20s; }
        .music { color: #fd7e14; left: 75%; animation-delay: 3.5s; animation-duration: 16s; }

        /* Login container */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Header styles */
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header h2 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .logo {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.8rem;
        }

        /* Form styles */
        .form-control {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 128, 0, 0.2);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 0.5rem;
            color: white;
            font-size: 0.9rem;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
        }

        /* Input with icons */
        .icon-input {
            position: relative;
        }

        .icon-input i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .icon-input.is-invalid i {
            color: var(--error-color);
        }

        .icon-input input {
            padding-left: 2.8rem;
        }

        .icon-input input:focus + i {
            color: var(--secondary-color);
        }

        /* Social buttons */
        .btn-social {
            border-radius: 8px;
            padding: 0.6rem;
            font-weight: 500;
            transition: all 0.3s;
            margin-bottom: 0.7rem;
            font-size: 0.85rem;
        }

        .btn-social:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-container {
                padding: 1.8rem;
            }
            .floating-work {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            .login-wrapper {
                padding: 0.5rem;
                padding-top: 2rem;
                align-items: flex-start;
            }
            .floating-work {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Floating work animations -->
    <div class="floating-work design"><i class="fas fa-paint-brush"></i></div>
    <div class="floating-work code"><i class="fas fa-code"></i></div>
    <div class="floating-work writing"><i class="fas fa-pen-fancy"></i></div>
    <div class="floating-work marketing"><i class="fas fa-bullhorn"></i></div>
    <div class="floating-work video"><i class="fas fa-video"></i></div>
    <div class="floating-work business"><i class="fas fa-chart-line"></i></div>
    <div class="floating-work translate"><i class="fas fa-language"></i></div>
    <div class="floating-work music"><i class="fas fa-music"></i></div>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo">
                    <img src="bin.jpg" alt="">
                </div>
                <p>Masuk untuk memulai proyek Anda</p>
            </div>

            @if(session('pesan'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            <form action="{{ url('/loginaction') }}" method="post" id="loginForm">
                @csrf
                <div class="icon-input @error('username') is-invalid @enderror">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username atau Email" required value="{{ old('username') }}">
                </div>
                @error('username')
                    <div class="text-danger mb-2" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror

                <div class="icon-input @error('password') is-invalid @enderror">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                </div>
                @error('password')
                    <div class="text-danger mb-2" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.85rem;">Ingat saya</label>
                    </div>
                    <a href="/forgot-password" class="text-decoration-none" style="color: var(--primary-color); font-size: 0.85rem;">Lupa password?</a>
                </div>

                <button class="btn btn-login w-100 mb-3" type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                </button>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="px-3">ATAU</span>
                    <hr class="flex-grow-1">
                </div>

                <button type="button" class="btn btn-outline-danger w-100 btn-social">
                    <i class="fab fa-google me-2"></i>Masuk dengan Google
                </button>
                <button type="button" class="btn btn-outline-primary w-100 btn-social">
                    <i class="fab fa-facebook-f me-2"></i>Masuk dengan Facebook
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-1">Pengguna baru?</p>
                <a href="/register" class="fw-bold text-decoration-none" style="color: var(--primary-color);">Daftar akun baru</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                const parent = this.parentElement;
                parent.querySelector('i').style.color = parent.classList.contains('is-invalid') 
                    ? 'var(--error-color)' 
                    : 'var(--secondary-color)';
            });

            input.addEventListener('blur', function() {
                const parent = this.parentElement;
                parent.querySelector('i').style.color = parent.classList.contains('is-invalid')
                    ? 'var(--error-color)'
                    : 'var(--primary-color)';
            });
        });

        @if(session('error') || $errors->any())
            document.querySelector('#loginForm').classList.add('shake');
            setTimeout(() => {
                document.querySelector('#loginForm').classList.remove('shake');
            }, 500);
        @endif
    </script>
</body>
</html>