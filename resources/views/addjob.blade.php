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

    .job-form-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .form-title {
        color: var(--dark-color);
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
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

    .btn-submit {
        background-color: var(--success-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2rem;
        font-weight: 500;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .btn-submit:hover {
        background-color: #17a673;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28, 200, 138, 0.3);
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

<div class="job-form-container">
    <h4 class="form-title">Posting Job</h4>

    <form method="post" action="{{ url('client/job/input') }}">
        @csrf
                                 
        <input type="hidden" name="id_job">
        <input type="hidden" name="id_client" value="{{ Auth::user()->id_user }}">
        <input type="hidden" name="status" value="5">

        <div class="form-group">
            <label>Judul Job</label>
            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul job" required>
        </div>

        <div class="form-group">
            <label>Deskripsi Job</label>
            <textarea id="job-description" name="deskripsi" class="form-control" rows="5" placeholder="Masukkan deskripsi job secara detail..."></textarea>
            <script>
                const textarea = document.querySelector('textarea[name="deskripsi"]');
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


        


        <div class="date-fields">
            <div class="form-group">
                <label>Batas Awal</label>
                <input type="date" name="tgl_mulai" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Batas Akhir</label>
                <input type="date" name="tgl_akhir" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label>Bidang</label>
            <select name="bidang" class="form-control" required style="height: 50px;">
                <option value="" selected disabled>- Pilih Bidang -</option>
                @foreach($bidang as $b)
                <option value="{{ $b->id_bidang }}">{{ $b->bidang }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>💰 Harga Job</label>
            <div class="input-harga-wrapper">
                <input type="text" id="harga_display" class="form-control" placeholder="Masukkan harga..." required>
                <input type="hidden" id="harga" name="harga">
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn-submit">Posting Job</button>
        </div>
    </form>
</div>

<script>
    const displayInput = document.getElementById('harga_display');
    const hiddenInput = document.getElementById('harga');

    displayInput.addEventListener('input', function() {
        // Remove all non-digit characters
        let raw = this.value.replace(/\D/g, '');
        
        // Format the number with thousand separators
        this.value = new Intl.NumberFormat('id-ID').format(raw);
        
        // Store the raw number in the hidden input
        hiddenInput.value = raw;
    });

    // Initialize the display if there's any existing value
    if (hiddenInput.value) {
        displayInput.value = new Intl.NumberFormat('id-ID').format(hiddenInput.value);
    }
</script>

@endsection