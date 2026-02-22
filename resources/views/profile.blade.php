@extends('template')

@section('konten')

<style>
    :root {
        --primary-color: #ff8000;
        --secondary-color: #ff9933;
        --accent-color: #e67300;
        --dark-color: #2f3640;
        --light-color: #f5f6fa;
        --error-color: #e74a3b;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
    }

    .profile-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .profile-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 2rem;
    }

    .profile-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .page-title {
        color: var(--dark-color);
        font-weight: 600;
        font-size: 1.5rem;
        margin: 0;
    }

    .btn-edit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .btn-edit:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
    }

    .btn-edit i {
        margin-right: 0.5rem;
    }

    .profile-content {
        display: flex;
        flex-wrap: wrap;
    }

    .profile-img-container {
        flex: 0 0 150px;
        margin-right: 2rem;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
    }

    .profile-info {
        flex: 1;
        min-width: 300px;
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        text-transform: capitalize;
    }

    .profile-specialty {
        font-style: italic;
        color: var(--secondary-color);
        margin-bottom: 1rem;
        display: block;
    }

    .profile-description {
        color: #495057;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .rating-stars {
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .rating-stars .text-warning {
        color: var(--warning-color) !important;
    }

    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        margin-top: 1rem;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .btn-whatsapp i {
        margin-right: 0.5rem;
    }

    .personal-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .personal-info li {
        margin-bottom: 0.8rem;
        display: flex;
        flex-wrap: wrap;
    }

    .info-title {
        font-weight: 600;
        color: var(--dark-color);
        min-width: 150px;
    }

    .info-value {
        color: #495057;
        flex: 1;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .experience-content {
        color: #495057;
        line-height: 1.8;
    }

    .review-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .review-header {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .review-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .review-user {
        flex: 1;
    }

    .review-name {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.2rem;
    }

    .review-date {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .review-text {
        color: #495057;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .profile-content {
            flex-direction: column;
        }
        
        .profile-img-container {
            margin-right: 0;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .personal-info li {
            flex-direction: column;
        }
        
        .info-title {
            margin-bottom: 0.3rem;
        }
    }
</style>

<div class="content">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-header-row">
                <h4 class="page-title">Profile</h4>
                @if($profile->id_user == Auth::user()->id_user)
                <a href="{{ url('profile/edit/' . $profile->id_profile) }}" class="btn-edit">
                    <i class="fa fa-edit"></i> Edit Profile
                </a>
                @endif
            </div>
            
            <div class="profile-content">
                <div class="profile-img-container">
                    <img class="profile-avatar" src="{{ url('imageup/'.$profile->foto_profile) }}" alt="Profile Image">
                </div>
                
                <div class="profile-info">
                    <h1 class="profile-name">{{$profile->nm_depan}} {{$profile->nm_belakang}}</h1>
                    
                    @if($profile->role_user == "freelancer")
                    <span class="profile-specialty">@ {{$profile->bidang_name}}</span>
                    @endif
                    
                    @if($profile->id_user != Auth::user()->id_user)
                        <a href="{{ url('https://wa.me/'.$profile->no_wa) }}" target="_blank" class="btn-whatsapp">
                            <i class="fa fa-whatsapp"></i> Chat WhatsApp
                        </a>
                    @else
                        <p class="profile-description">{{$profile->des_singkat}}</p>
                    @endif
                    <br>
                    <br>

                    @if($profile->role_user == "freelancer")
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i <= round($average_rating) ? ' text-warning' : ' text-secondary' }}"></i>
                        @endfor
                        <span>({{ number_format($average_rating, 1) }})</span>
                    </div>
                    @endif
                </div>
                
                <div class="personal-details" style="flex: 1; min-width: 300px; margin-top: 1.5rem;">
                    <ul class="personal-info">
                        <li>
                            <span class="info-title">Email:</span>
                            <span class="info-value">{{$profile->email_user}}</span>
                        </li>
                        <li>
                            <span class="info-title">Kelahiran:</span>
                            <span class="info-value">{{$profile->tgl_lahir}}</span>
                        </li>
                        <li>
                            <span class="info-title">Alamat:</span>
                            <span class="info-value">{{$profile->alamat}}</span>
                        </li>
                        <li>
                            <span class="info-title">No. WhatsApp:</span>
                            <span class="info-value">{{$profile->no_wa}}</span>
                        </li>
                        @if(Auth::user()->role == "freelancer")
                        <li>
                            <span class="info-title">Gender:</span>
                            <span class="info-value">{{$profile->jns_kelamin}}</span>
                        </li>
                        @endif

                        @if($profile->id_user == Auth::user()->id_user)
                            @if(Auth::user()->role != "admin")
                            <li>
                                <span class="info-title">Nama Rekening:</span>
                                <span class="info-value">{{$profile->nm_rek}}</span>
                            </li>
                            <li>
                                <span class="info-title">No. Rekening:</span>
                                <span class="info-value">{{$profile->no_rek}}</span>
                            </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            
            @if($profile->id_user != Auth::user()->id_user)
            <div class="profile-description-section" style="margin-top: 2rem;">
                <h4 class="section-title">Deskripsi Singkat</h4>
                <p class="profile-description"><i>{{$profile->des_singkat}}</i></p>
            </div>
            @endif
        </div>
        
        @if($profile->role_user == "freelancer")
        <div class="profile-sections">
            <div class="experience-section" style="margin-top: 3rem;">
                <h3 class="section-title">Pengalaman & Riwayat Pendidikan</h3>
                <div class="experience-content">
                    {!! $profile->bio !!}
                </div>
            </div>
            
            <div class="reviews-section" style="margin-top: 3rem;">
                <h3 class="section-title">Ulasan</h3>
                @foreach($ulasan as $u)
                <div class="review-card">
                    <div class="review-header">
                        <img src="{{ url('imageup/'.$u->pp) }}" class="review-avatar" alt="Reviewer Avatar">
                        <div class="review-user">
                            <div class="review-name">{{$u->nm_depan}} {{$u->nm_belakang}}</div>
                            <div class="review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star{{ $i <= $u->rating ? ' text-warning' : ' text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="review-date">({{$u->created_at->format('d M Y')}})</div>
                    </div>
                    <div class="review-text">
                        {{$u->ulasan}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function warning() {
        Swal.fire({
            title: 'Maaf?',
            text: "Anda harus melengkapi data profile terlebih dahulu",
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }
</script>

<script>
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            title: 'Awas!',
            text: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    @endif
</script>

@endsection