@extends('template')

@section('konten')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<style>
    :root {
        --primary-color: #ff8000;
        --secondary-color: #ff9933;
        --accent-color: #e67300;
        --dark-color: #2f3640;
        --light-color: #f5f6fa;
        --success-color: #1cc88a;
    }

    .job-detail-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .job-title {
        color: var(--dark-color);
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    .job-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .meta-left {
        display: flex;
        align-items: center;
    }

    .meta-item {
        display: flex;
        align-items: center;
        margin-right: 1.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .meta-item i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }

    .client-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.5rem;
    }

    .job-content {
        margin: 2rem 0;
    }

    .job-description {
        color: #495057;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .price-card {
        background: #f6f6f6;
        padding: 1rem 1.5rem;
        border-left: 4px solid var(--primary-color);
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .price-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .price-value {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .offer-section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: rgba(255, 128, 0, 0.05);
        border-radius: 8px;
        border: 1px dashed var(--primary-color);
    }

    .offer-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--dark-color);
    }

    .offer-form .form-group {
        margin-bottom: 1rem;
    }

    .btn-submit-offer {
        background-color: var(--success-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-submit-offer:hover {
        background-color: #17a673;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28, 200, 138, 0.3);
    }

    .offer-list {
        margin: 2rem 0;
    }

    .offer-item {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }

    .offer-item:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .offer-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1.5rem;
        border: 2px solid var(--primary-color);
    }

    .offer-content {
        flex: 1;
    }

    .offer-username {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .offer-username a {
        color: var(--dark-color);
        text-decoration: none;
    }

    .offer-username a:hover {
        color: var(--primary-color);
    }

    .offer-text {
        color: #495057;
        line-height: 1.6;
    }

    .social-share {
        display: flex;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .social-share a {
        color: var(--dark-color);
        font-size: 1.2rem;
        transition: all 0.3s;
    }

    .social-share a:hover {
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .comment-section {
        margin-top: 3rem;
    }

    .comment-item {
        display: flex;
        margin-bottom: 1.5rem;
    }

    .comment-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .comment-content {
        flex: 1;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .comment-author {
        font-weight: 600;
    }

    .comment-date {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .comment-text {
        color: #495057;
        line-height: 1.6;
    }

    .comment-form {
        margin-top: 2rem;
    }

    .comment-form .form-group {
        margin-bottom: 1rem;
    }

    .btn-submit-comment {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-submit-comment:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
    }

    .alert-info {
        background-color: rgba(23, 162, 184, 0.1);
        border-left: 4px solid #17a2b8;
        color: #0c5460;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
    }
</style>

<div class="job-detail-container">
    <h1 class="job-title">{{ $job->judul }}</h1>
    
    <div class="job-meta">
        <div class="meta-left">
            <div class="meta-item">
                <i class="fa fa-calendar"></i> {{ $job->created_at->format('d M Y') }}
            </div>
            <div class="meta-item">
                <img src="{{ url('imageup/'.$job->pp) }}" class="client-avatar" alt="Client Profile">
                <a href="#">{{ $job->client_name }}</a>
            </div>
          
        </div>
        <div class="meta-right">
            <span class="meta-item">
                <i class="fa fa-comment"></i> 1 Comment
            </span>
        </div>
    </div>

    <div class="job-content">
        <div class="job-description">
            <h4>Deskripsi:</h4>
            {!! $job->deskripsi !!}
        </div>

        <div class="price-card">
            <div class="price-label">💰 Harga Job:</div>
            <div class="price-value">Rp {{ number_format($job->harga, 0, ',', '.') }},00</div>
        </div>
    </div>

    @if(Auth::user()->role != 'client')
    <div class="offer-section">
        @if($nawar->isNotEmpty())
            <div class="alert-info">
                Anda sudah mengirimkan penawaran.
            </div>
        @else
            <h4 class="offer-title">Tawarkan Diri Anda</h4>
            <form action="{{ url('freelancer/penawaran/masuk') }}" method="post" class="offer-form">
                @csrf
                <input type="hidden" name="id_job" value="{{ $job->id_job }}">
                <input type="hidden" name="status" value="3">
                <input type="hidden" name="id_client" value="{{ $job->id_client }}">

                <div class="form-group">
                    <textarea id="offer-description" name="des_tawaran" class="form-control" rows="5" placeholder="Tulis deskripsi penawaran..."></textarea>
                    <script>
                        const textarea = document.querySelector('textarea[name="des_tawaran"]');
                        textarea.setAttribute('tabindex', '0'); // Supaya bisa difokus saat validasi

                        ClassicEditor
                            .create(textarea)
                            .then(editor => {
                                // Validasi custom jika deskripsi kosong
                                editor.model.document.on('change:data', () => {
                                    const editorData = editor.getData();

                                    if (!editorData.trim()) {
                                        textarea.setCustomValidity('Deskripsi job tidak boleh kosong');
                                    } else {
                                        textarea.setCustomValidity('');
                                    }
                                });

                                // Tambahkan listener pada form submit (optional, biar lebih solid)
                                textarea.closest('form').addEventListener('submit', function (e) {
                                    if (!editor.getData().trim()) {
                                        textarea.setCustomValidity('Deskripsi job tidak boleh kosong');
                                        textarea.reportValidity();
                                        e.preventDefault(); // stop submit
                                    }
                                });
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    </script>



                <style>
                    /* Mengatur height CKEditor */
                    .ck-editor__editable {
                        height: 200px !important;  /* Menyesuaikan tinggi editor */
                    }
                </style>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-submit-offer">Kirim Penawaran</button>
                </div>
            </form>
        @endif
    </div>
    @endif

    <div class="offer-list">
        <h3>Penawaran Masuk</h3>
        @forelse($penawaran as $n)
            <div class="offer-item">
                <img src="{{ url('imageup/'.$n->pp) }}" class="offer-avatar" alt="Freelancer Profile">
                <div class="offer-content">
                    <h5 class="offer-username">
                        <a href="{{ url('profile/'.$n->id_free) }}" target="_blank">{{ $n->freelancer_username }}</a>
                    </h5>
                    <div class="offer-text">
                        {!! $n->des_tawaran !!}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada penawaran yang masuk.</p>
        @endforelse
    </div>

    <div class="">
                    <h3>Bagikan Postingan</h3>
                    <ul class="social-share list-inline">
                        @foreach(['facebook', 'twitter', 'linkedin', 'google-plus', 'youtube'] as $platform)
                            <li class="list-inline-item">
                                <a href="#"><i class="fa fa-{{ $platform }}"></i></a>
                            </li>
                        @endforeach
                    </ul>
    </div>
    <br>
    <br>
    <br>

    <div class="comment-section">
        <h3>Komentar (3)</h3>
        
        @foreach(range(1,3) as $i)
            <div class="comment-item">
                <img src="{{ url('assets/img/user.jpg') }}" class="comment-avatar" alt="User Avatar">
                <div class="comment-content">
                    <div class="comment-header">
                        <span class="comment-author">User {{ $i }}</span>
                        <span class="comment-date">April 27, 2025</span>
                    </div>
                    <div class="comment-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                    <a href="#" class="text-primary"><i class="fa fa-reply"></i> Balas</a>
                </div>
            </div>
        @endforeach

        <div class="comment-form">
            <h3>Tinggalkan Komentar</h3>
            <form>
                <div class="form-group">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Komentar</label>
                    <textarea class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-submit-comment">Kirim Komentar</button>
            </form>
        </div>
    </div>
</div>

@endsection