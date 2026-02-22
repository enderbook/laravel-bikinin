<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Account Blocked - Bikinin Freelance Platform</title>
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/font-awesome.min.css')}}">
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
            background-image: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)),
                              url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: var(--dark-color);
        }

        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .error-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-icon {
            font-size: 5rem;
            color: var(--error-color);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .error-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--error-color);
            margin-bottom: 1rem;
        }

        .error-subtitle {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .error-message {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .error-details {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 2rem;
        }

        .btn-return {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 2rem;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-return:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
            color: white;
        }

        @media (max-width: 576px) {
            .error-card {
                padding: 2rem;
            }
            .error-title {
                font-size: 2.5rem;
            }
            .error-subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fa fa-ban"></i>
            </div>
            <h1 class="error-title">SORRY</h1>
            <h3 class="error-subtitle">
                <i class="fa fa-warning"></i> Maaf! Akun Ini Telah Diblokir
            </h3>
            <p class="error-message">Harap mematuhi aturan platform kami.</p>
            <p class="error-details">Akun akan aktif kembali setelah 30 hari sejak pemblokiran.</p>
            <a href="{{url('logout')}}" class="btn-return">Kembali ke Halaman Login</a>
        </div>
    </div>

    <script src="{{url('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('assets/js/popper.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
</body>
</html>