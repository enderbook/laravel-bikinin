@extends('template')

@section('konten')
<style>
    :root {
        --primary-color: #ff8000;
        --secondary-color: #ff9933;
        --accent-color: #e67300;
        --dark-color: #2f3640;
        --light-color: #f5f6fa;
        --success-color: #1cc88a;
        --error-color: #e74a3b;
    }

    .recruitment-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 2rem;
        background-color: #f9f9f9;
    }

    .recruitment-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        width: 100%;
        max-width: 500px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .recruitment-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .recruitment-header h2 {
        color: var(--dark-color);
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.8rem;
    }

    .alert-message {
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

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
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 128, 0, 0.2);
        outline: none;
    }

    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.8rem;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 1rem;
        width: 100%;
    }

    .btn-submit:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
    }

    .role-badge {
        display: inline-block;
        background-color: rgba(255, 128, 0, 0.1);
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    @media (max-width: 576px) {
        .recruitment-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="recruitment-container">
    <div class="recruitment-card">
        <div class="recruitment-header">
            <h2>Rekrut Admin</h2>
            <p>Tambahkan admin baru untuk platform Bikinin</p>
        </div>

        @if(session('pesan'))
            <div class="alert-message">
                <i class="fa fa-exclamation-circle"></i> {{ session('pesan') }}
            </div>
        @endif

        <form action="{{ url('rekrut/rekrutaction') }}" method="post">
            @csrf
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="role" id="role-input" value="admin">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat password" required>
            </div>

            <div class="form-group text-center">
                <div class="role-badge">Role: Admin</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Rekrut Admin</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ url('assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ url('assets/js/popper.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>

@endsection