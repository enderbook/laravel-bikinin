@extends('template')

@section('konten')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<style>
    :root {
        --primary-color: #ff8000;
        --secondary-color: #ff9933;
        --accent-color: #e67300;
        --dark-color: #2f3640;
        --light-color: #f5f6fa;
        --success-color: #1cc88a;
        --warning-color: #FFD700;
        --danger-color: #FF0000;
    }

    .job-edit-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
    }

    .form-title {
        color: var(--dark-color);
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background-color: var(--warning-color);
        color: var(--dark-color);
    }

    .status-ended {
        background-color: var(--danger-color);
        color: white;
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

    .date-fields {
        display: flex;
        gap: 1rem;
    }

    .date-fields .form-group {
        flex: 1;
    }

    .btn-edit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2rem;
        font-weight: 500;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .btn-edit:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 51, 0.3);
    }

    .text-right {
        text-align: right;
        margin-top: 2rem;
    }

    .input-harga-wrapper {
        position: relative;
    }

    .input-harga-wrapper::before {
        content: 'Rp';
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
        font-weight: 500;
    }

    #harga_display {
        padding-left: 2.5rem;
    }

    @media (max-width: 768px) {
        .date-fields {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="job-edit-container">
    @if($job->status == 5)
        <h4 class="form-title">Edit Job</h4>

        <form method="post" action="{{ url('client/job/ubah') }}">
            @csrf
            <input type="hidden" name="id_client" value="{{ $job->id_client }}">
            <input type="hidden" name="id_job" value="{{ $job->id_job }}">
            <input type="hidden" name="status" value="{{ $job->status }}">

            <div class="form-group">
                <label>Judul Job</label>
                <input type="text" name="judul" value="{{ $job->judul }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Job</label>
                <textarea id="job-description" name="deskripsi" class="form-control" rows="5" required>{{ $job->deskripsi }}</textarea>
                <script>
                    CKEDITOR.replace('job-description');
                </script>
            </div>

            <div class="date-fields">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ $job->tgl_mulai }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Berakhir</label>
                    <input type="date" name="tgl_akhir" value="{{ $job->tgl_akhir }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Bidang</label>
                <select name="bidang" class="form-control" required style="height: 50px;">
                    <option value="" disabled>- Pilih Bidang -</option>
                    @foreach($bidang as $b)
                        <option value="{{ $b->id_bidang }}" {{ $job->bidang == $b->id_bidang ? 'selected' : '' }}>
                            {{ $b->bidang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>💰 Harga Job</label>
                <div class="input-harga-wrapper">
                    <input type="text" id="harga_display" class="form-control" 
                           value="{{ number_format($job->harga, 0, ',', '.') }}" required>
                    <input type="hidden" id="harga" name="harga" value="{{ $job->harga }}">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn-edit">Simpan Perubahan</button>
            </div>
        </form>
    @else
        <div class="status-badge {{ $job->status_name == 'End' ? 'status-ended' : 'status-active' }}">
            {{ $job->status_name }}
        </div>
        
        <div class="job-details">
            <h4 class="form-title">{{ $job->judul }}</h4>
            <div class="form-group">
                <label>Status</label>
                <p>{{ $job->status_name }}</p>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <div class="job-description">{!! $job->deskripsi !!}</div>
            </div>
            <div class="date-fields">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <p>{{ date('d M Y', strtotime($job->tgl_mulai)) }}</p>
                </div>
                <div class="form-group">
                    <label>Tanggal Berakhir</label>
                    <p>{{ date('d M Y', strtotime($job->tgl_akhir)) }}</p>
                </div>
            </div>
            <div class="form-group">
                <label>Bidang</label>
                <p>
                    @foreach($bidang as $b)
                        @if($job->bidang == $b->id_bidang)
                            {{ $b->bidang }}
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <p>Rp {{ number_format($job->harga, 0, ',', '.') }}</p>
            </div>
        </div>
    @endif
</div>

<script>
    const displayInput = document.getElementById('harga_display');
    const hiddenInput = document.getElementById('harga');

    if (displayInput) {
        displayInput.addEventListener('input', function() {
            // Remove all non-digit characters
            let raw = this.value.replace(/\D/g, '');
            
            // Format the number with thousand separators
            this.value = new Intl.NumberFormat('id-ID').format(raw);
            
            // Store the raw number in the hidden input
            hiddenInput.value = raw;
        });
    }
</script>

@endsection