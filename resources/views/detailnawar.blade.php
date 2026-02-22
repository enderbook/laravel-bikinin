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
    }

    .offer-detail-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .offer-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .offer-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
        border: 2px solid var(--primary-color);
    }

    .offer-user-info h2 {
        margin: 0;
        font-size: 1.5rem;
        color: var(--dark-color);
        font-weight: 600;
    }

    .offer-user-info h2 a {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .offer-user-info h2 a:hover {
        color: var(--primary-color);
    }

    .offer-meta {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .offer-meta i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }

    .offer-content {
        padding: 1rem 0;
    }

    .offer-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
        color: #495057;
    }

    .offer-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .btn-accept {
        background-color: var(--success-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        flex: 1;
        margin-right: 0.5rem;
        text-align: center;
    }

    .btn-accept:hover {
        background-color: #17a673;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28, 200, 138, 0.3);
    }

    .btn-reject {
        background-color: var(--error-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        flex: 1;
        margin-left: 0.5rem;
        text-align: center;
    }

    .btn-reject:hover {
        background-color: #d62c1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 74, 59, 0.3);
    }

    .btn-cancel {
        background-color: var(--error-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        text-align: center;
        display: inline-block;
    }

    .btn-cancel:hover {
        background-color: #d62c1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 74, 59, 0.3);
    }

    @media (max-width: 576px) {
        .offer-actions {
            flex-direction: column;
        }
        
        .btn-accept,
        .btn-reject {
            width: 100%;
            margin: 0.5rem 0;
        }
    }
</style>

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Detail Penawaran</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="offer-detail-container">
                <article class="blog-single-post">
                    <div class="offer-header">
                        <img class="offer-avatar" src="{{ url('imageup/'.$nawar->pp) }}" alt="Profile Image">
                        <div class="offer-user-info">
                            <h2>
                                <a href="{{ url('profile/' . $nawar->id_free) }}">{{ $nawar->freelancer_username }}</a>
                            </h2>
                            <div class="offer-meta">
                                <i class="fa fa-calendar"></i>
                                <span>{{ $nawar->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="offer-content">
                        <p><strong>Deskripsi Tawaran:</strong></p>
                        <p>{!! $nawar->des_tawaran !!}</p>
                    </div>
                    
                    @if(auth()->user()->role == 'client')
                    <form action="{{ url('client/penawaran/status') }}" method="post">
                        @csrf
                        <div class="offer-actions">
                            <input type="hidden" name="id_kontrak">
                            <input type="hidden" name="id_free" value="{{ $nawar->id_free }}">
                            <input type="hidden" name="id_client" value="{{ $nawar->id_client }}">                                     
                            <input type="hidden" name="id_job" value="{{ $nawar->id_job }}">
                            <input type="hidden" name="bukti_transfer">
                            <input type="hidden" name="deadline">
                            <input type="hidden" name="status_kontrak" value="2">
                            <input type="hidden" name="des_tawaran" value="{{ $nawar->des_tawaran }}">
                            <input type="hidden" name="id_penawaran" value="{{ $nawar->id_penawaran }}">
                            <input type="hidden" name="nm_rek" value="organeh">
                            <input type="hidden" name="no_rek" value="090909090909">
                            <input type="hidden" name="status_pay" value="2">

                            <button type="submit" value="8" class="btn-accept" name="status_nawar"
                                onclick="return confirm('Apakah Anda Yakin Akan Menerima?')">
                                <i class="fa fa-check"></i> Terima
                            </button>
                            <button type="submit" value="9" name="status_nawar"
                                onclick="return confirm('Apakah Anda Yakin Akan Menolak?')"
                                class="btn-reject">
                                <i class="fa fa-times"></i> Tolak
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="offer-actions">
                        <a href="{{ url('freelancer/penawaran/batal/' . $nawar->id_penawaran) }}"
                            onclick="return confirm('Apakah Anda Yakin Akan Membatalkan?')"
                            class="btn-cancel">
                            <i class="fa fa-ban"></i> Batalkan Penawaran
                        </a>
                    </div>
                    @endif
                </article>
            </div>
        </div>
    </div>
</div>

@endsection