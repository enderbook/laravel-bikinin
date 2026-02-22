<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="logoweb.png">
    <title>Register - Bikinin</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <style>
        :root {
            --primary-color: #ff8000;
            --secondary-color: #ff9933;
            --accent-color: #e67300;
            --dark-color: #2f3640;
            --light-color: #f5f6fa;
            --error-color: #e74a3b;
            --success-color: #1cc88a;
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

        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
            border-radius: 6px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .alert-error i,
        .alert-success i {
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

        /* Register container */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Header styles */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h2 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .register-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .logo {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: inline-block;
        }

        .logo img {
            max-height: 60px;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.8rem 1.2rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 0.95rem;
            width: 100%;
            color: #495057;
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 128, 0, 0.2);
            outline: none;
        }

        .btn-register {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 0.5rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .btn-register:hover {
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
            font-size: 1rem;
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

        /* Role selection buttons */
        .role-dialog {
            display: flex;
            gap: 0.8rem;
            margin-top: 0.5rem;
        }

        .role-button {
            flex: 1;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            color: var(--dark-color);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .role-button:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .role-button.selected {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Login link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .register-container {
                padding: 2rem;
            }
            .floating-work {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            .register-wrapper {
                padding: 0.5rem;
                padding-top: 2rem;
                align-items: flex-start;
            }
            .floating-work {
                display: none;
            }
            .role-dialog {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Floating background elements -->
    <i class="floating-work design fa fa-paint-brush"></i>
    <i class="floating-work code fa fa-code"></i>
    <i class="floating-work writing fa fa-pencil-alt"></i>
    <i class="floating-work marketing fa fa-bullhorn"></i>
    <i class="floating-work video fa fa-video"></i>
    <i class="floating-work business fa fa-briefcase"></i>
    <i class="floating-work translate fa fa-language"></i>
    <i class="floating-work music fa fa-music"></i>

    <div class="register-wrapper">
        <div class="register-container">
            <div class="register-header">
                <div class="logo">
                    <img src="bin.jpg" alt="Bikinin Logo">
                </div>
                <h2>Create Your Account</h2>
            </div>

            @if(session('pesan'))
                <div class="alert-{{ session('pesan')['type'] === 'error' ? 'error' : 'success' }}">
                    <i class="fa fa-{{ session('pesan')['type'] === 'error' ? 'exclamation-circle' : 'check-circle' }}"></i>
                    {{ session('pesan')['message'] }}
                </div>
            @endif

            <form action="{{ url('register/registeraction') }}" method="post">
                @csrf
                <input type="hidden" name="status" value="1">
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="icon-input">
                        <i class="fa fa-user"></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="icon-input">
                        <i class="fa fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="icon-input">
                        <i class="fa fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Register As</label>
                    <div class="role-dialog">
                        <button type="button" class="role-button" data-role="freelancer">
                            <i class="fa fa-user-tie"></i> Freelancer
                        </button>
                        <button type="button" class="role-button" data-role="client">
                            <i class="fa fa-building"></i> Client
                        </button>
                    </div>
                    <input type="hidden" name="role" id="role-input" value="" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-register">Create Account</button>
                </div>
                
                <div class="login-link">
                    Already have an account? <a href="{{ url('/') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-button');
            const roleInput = document.getElementById('role-input');
            
            // Add click event to role buttons
            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove selected class from all buttons
                    roleButtons.forEach(btn => btn.classList.remove('selected'));
                    
                    // Add selected class to clicked button
                    this.classList.add('selected');
                    
                    // Set the hidden input value
                    roleInput.value = this.getAttribute('data-role');
                });
            });
            
            // Form validation - ensure a role is selected
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!roleInput.value) {
                    e.preventDefault();
                    alert('Please select whether you are registering as a freelancer or company');
                    roleButtons.forEach(btn => btn.classList.add('shake'));
                    setTimeout(() => {
                        roleButtons.forEach(btn => btn.classList.remove('shake'));
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>