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
        --error-color: #e74a3b;
        --success-color: #1cc88a;
    }

    .profile-edit-container {
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
        color: #495057;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 128, 0, 0.2);
        outline: none;
    }

    .name-fields {
        display: flex;
        gap: 1rem;
    }

    .name-fields .form-group {
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

    .file-upload {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: block;
        padding: 0.8rem 1.2rem;
        border: 1px dashed #e0e0e0;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .file-upload-label:hover {
        border-color: var(--primary-color);
        background-color: rgba(255, 128, 0, 0.05);
    }

    .image-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #eee;
        margin-bottom: 1rem;
    }

    .text-right {
        text-align: right;
        margin-top: 2rem;
    }

    .text-danger {
        color: var(--error-color);
    }

    @media (max-width: 768px) {
        .name-fields {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="profile-edit-container">
    <h4 class="form-title">Edit Profile</h4>

    <form method="post" action="{{ url('profile/ubah') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id_profile" value="{{ $profile->id_profile }}">
        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
        <input type="hidden" name="status" value="5">

        
        <div class="name-fields">
            <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" name="nm_depan" value="{{ $profile->nm_depan }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" name="nm_belakang" value="{{ $profile->nm_belakang }}" class="form-control" required>
            </div>
        </div>

        @if(Auth::user()->role == "client")
        <input type="hidden" name="jns_kelamin" value="n">
        @else
        <div class="form-group">
            <label>Jenis Kelamin</label>
            @if(isset($profile) && $profile->jns_kelamin)
                <select class="form-control" name="jns_kelamin" required style="height: 50px;"> 
                    <option value="" disabled>Pilih Jenis Kelamin</option>
                    <option value="LK" {{ $profile->jns_kelamin == 'LK' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="PR" {{ $profile->jns_kelamin == 'PR' ? 'selected' : '' }}>Perempuan</option>
                </select>
            @else
                <p class="text-danger">Data tidak tersedia</p>
            @endif
        </div>
        @endif

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ $profile->alamat }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>No. WhatsApp</label>
            <input type="text" name="no_wa" value="{{ $profile->no_wa }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>
                Tanggal Lahir / Berdirinya Perusahaan
              
            </label>
            <input type="date" name="tgl_lahir" value="{{ $profile->tgl_lahir }}" class="form-control" required>
        </div>

        @if(Auth::user()->role != "admin")
        <div class="form-group">
            <label>Nama Rekening</label>
            <input type="text" name="nm_rek" value="{{ $profile->nm_rek }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nomor Rekening</label>
            <input type="text" name="no_rek" value="{{ $profile->no_rek }}" class="form-control" required>
        </div>

        @if(Auth::user()->role === 'freelancer')

        <div class="form-group">
            <label>Deskripsi Singkat</label>
            <input type="text" name="des_singkat" value="{{ $profile->des_singkat }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Bio</label>
            <textarea id="bio-editor" name="bio" class="form-control" rows="5">{{ $profile->bio }}</textarea>
            <script>
                const textarea = document.querySelector('textarea[name="bio"]');
                textarea.setAttribute('tabindex', '0'); 

                ClassicEditor
                    .create(textarea)
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            const editorData = editor.getData();

                            if (!editorData.trim()) {
                                textarea.setCustomValidity('Biodata tidak boleh kosong');
                            } else {
                                textarea.setCustomValidity('');
                            }
                        });

                        textarea.closest('form').addEventListener('submit', function (e) {
                            if (!editor.getData().trim()) {
                                textarea.setCustomValidity('Biodata tidak boleh kosong');
                                textarea.reportValidity();
                                e.preventDefault();
                            }
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>
            <style>
                .ck-editor__editable {
                    height: 200px !important; 
                }
            </style>
        </div>
        @else
            <input type="hidden" name="des_singkat" value="{{ $profile->des_singkat }}" class="form-control">
            <input type="hidden" name="bio" value="{{ $profile->bio }}" class="form-control">

        @endif

        @if(Auth::user()->role === 'freelancer')
        <div class="form-group">
            <label>Bidang</label>
            <select name="bidang" class="form-control" required style="height: 50px;">
                <option value="" disabled>- Pilih Bidang -</option>
                @foreach($bidang as $b)
                    <option value="{{ $b->id_bidang }}" {{ $profile->bidang == $b->id_bidang ? 'selected' : '' }}>
                        {{ $b->bidang }}
                    </option>
                @endforeach
            </select>
        </div>
        @else
        <input type="hidden" name="bidang" value="4">
        @endif
        @else
        <input type="hidden" name="nm_rek" value="Tidak Ada">
        <input type="hidden" name="no_rek" value="00000">
        <input type="hidden" name="des_singkat" value="Tidak Ada">
        <input type="hidden" name="bio" value="Tidak Ada">
        <input type="hidden" name="bidang" value="4">
        @endif

        <div class="form-group">
            <label>Foto Profile</label>
            <div class="image-preview">
                <img id="preview" class="preview-image" 
                     src="{{ url('imageup/'.$profile->foto_profile) }}" 
                     alt="Current Profile Photo"
                     style="display: {{ $profile->foto_profile ? 'block' : 'none' }};">
            </div>
            <div class="file-upload">
                <input type="file" class="file-upload-input" name="foto_profile" id="potoInput" onchange="previewImage(event)">
                <label for="potoInput" class="file-upload-label" id="fileLabel">
                    <i class="fa fa-cloud-upload-alt"></i> 
                    {{ $profile->foto_profile ? 'Ganti Foto Profile' : 'Pilih Foto Profile' }}
                </label>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
            
            // Update file label
            var fileName = event.target.files[0].name;
            document.getElementById('fileLabel').innerHTML = 
                `<i class="fa fa-check-circle"></i> ${fileName}`;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection