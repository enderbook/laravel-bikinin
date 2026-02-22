@extends('template')

@section('konten')
<link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/css/font-awesome.min.css')}}">

<style>
    .kontrak-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 30px;
    }
    .kontrak-header {
        border-bottom: 2px solid #f6f6f6;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }
    .kontrak-title {
        color: #333;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .user-profile {
        display: flex;
        align-items: center;
        margin: 15px 0;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 12px;
        object-fit: cover;
    }
    .user-name {
        font-weight: 600;
        color: #333;
        margin-right: 15px;
        text-decoration: none;
    }
    .user-name:hover {
        color: #FF8000;
    }
    .section-title {
        color: #FF8000;
        font-weight: 600;
        margin: 25px 0 15px;
        font-size: 1.1rem;
    }
    .info-card {
        background-color: #f6f6f6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .info-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }
    .info-value {
        color: #333;
    }
    .file-card {
        border: 1px dashed #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .file-card:hover {
        border-color: #FF8000;
        background-color: #f6f6f6;
    }
    .file-icon {
        font-size: 24px;
        color: #FF8000;
        margin-right: 10px;
    }
    .file-name {
        word-break: break-all;
    }
    .btn-orange {
        background-color: #FF8000;
        border-color: #FF8000;
        color: white;
    }
    .btn-orange:hover {
        background-color: #e67300;
        border-color: #e67300;
        color: white;
    }
    .btn-outline-orange {
        border-color: #FF8000;
        color: #FF8000;
    }
    .btn-outline-orange:hover {
        background-color: #FF8000;
        color: white;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-success {
        background-color: #d4edda;
        color: #155724;
    }
    .status-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .custom-file-label::after {
        background-color: #FF8000;
        color: white;
    }
    .star-rating .star {
        font-size: 24px;
        cursor: pointer;
        color: #ddd;
        transition: all 0.2s;
    }
    .star-rating .star.selected, .star-rating .star.hovered {
        color: #FF8000;
    }
</style>

<div class="kontrak-container">
    <div class="kontrak-header">
        <h4 class="kontrak-title">Detail Kontrak</h4>
        
        <a href="{{url('freelancer/penawaran/input/'.$kontrak->id_job)}}"><h2 class="mt-3" style="color: #333; font-weight: 600;">{{$kontrak->judul_job}}</h2></a>
        
        <div class="user-profile">
            @if(Auth::user()->role == 'client')
                <img class="user-avatar" src="{{ url('imageup/'.$kontrak->pp_free) }}" alt="Freelancer">
                <a href="{{ url('profile/'.$kontrak->id_free) }}" class="user-name">
                    {{ $kontrak->freelancer_username }}
                </a>
                <a href="{{ url('https://wa.me/'.$kontrak->wa_free) }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fab fa-whatsapp me-1"></i> Chat
                </a>
            @else
                <img class="user-avatar" src="{{ url('imageup/'.$kontrak->pp_client) }}" alt="Client">
                <a href="{{ url('profile/'.$kontrak->id_client) }}" class="user-name">
                    {{ $kontrak->client_name }}
                </a>
                <a href="{{ url('https://wa.me/'.$kontrak->wa_client) }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fab fa-whatsapp me-1"></i> Chat
                </a>
            @endif
        </div>
    </div>

    @if(Auth::user()->role == 'client')
        
        

        <!-- Deadline Section -->
        @if(is_null($kontrak->deadline))
        <div class="info-card">
            <h5 class="section-title">Deadline</h5>
            <p>Anda harus berdiskusi dengan freelancer untuk menetapkan waktu deadline</p>
            <form id="deadlineForm" action="{{url('kontrak/deadline')}}" method="post" class="form-inline mt-3">
                @csrf
                <input type="hidden" name="id_kontrak_deadline" value="{{ $kontrak->id_kontrak }}">
                <div class="form-group mr-2">
                    <input type="date" name="deadline" class="form-control" value="{{ $kontrak->deadline }}" required>
                </div>
                <button id="submit-deadline" class="btn btn-orange btn-sm">
                    <i class="fas fa-edit me-1"></i> Update
                </button>
            </form>
        </div>


        <div class="info-card">
            <h5 class="section-title">Kode Kontrak</h5>
            <div class="mb-2" style="display: flex; align-items: center;">
                <span class="info-value" id="kodeKontrak"><b>{{$kontrak->kd_kontrak}}  </b></span>
                <span class="info-value">
                    <button id="copyBtn" onclick="copyKode()" class="btn btn-light" title="Copy kode kontrak" style="min-width: 40px;">
                        <i class="fa fa-copy"></i>
                    </button>
                </span>
            </div>

            
        </div>


        <!-- Admin Info Section -->
        <div class="info-card">
            <h5 class="section-title">Info Admin</h5>
            <div class="mb-2">
                <span class="info-label">Email:</span>
                <span class="info-value">{{$pay->admin_email}}</span>
            </div>
            @if(!empty($pay->wa_admin))
            <div class="mb-2">
                <span class="info-label">No. WA:</span>
                <span class="info-value">{{$pay->wa_admin}}</span>
                <a href="{{ url('https://wa.me/'.$pay->wa_admin) }}" target="_blank" class="btn btn-success btn-sm ms-2">
                    <i class="fab fa-whatsapp me-1"></i> 
                </a>
            </div>
            <p class="text-muted small mt-2">*Hubungi admin jika ada kendala, pelanggaran, pembatalan kontrak, dll</p>
            @endif
        </div>
        @else
        <div class="info-card">
            <h5 class="section-title">Deadline</h5>
            <p>Waktu deadline bisa diubah sesuai kesepakatan</p>
            <form id="deadlineForm" action="{{url('kontrak/deadline')}}" method="post" class="form-inline mt-3">
                @csrf
                <input type="hidden" name="id_kontrak_deadline" value="{{ $kontrak->id_kontrak }}">
                <div class="form-group mr-2">
                    <input type="date" name="deadline" class="form-control" value="{{ $kontrak->deadline }}" required>
                </div>
                <button id="submit-deadline" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> Update
                </button>
            </form>
        </div>


        <div class="info-card">
            <h5 class="section-title">Kode Kontrak</h5>
            <div class="mb-2" style="display: flex; align-items: center;">
                <span class="info-value" id="kodeKontrak"><b>{{$kontrak->kd_kontrak}}  </b></span>
                <span class="info-value">
                    <button id="copyBtn" onclick="copyKode()" class="btn btn-light" title="Copy kode kontrak" style="min-width: 40px;">
                        <i class="fa fa-copy"></i>
                    </button>
                </span>
            </div>

            
        </div>


        <!-- Admin Info Section -->
        <div class="info-card">
            <h5 class="section-title">Info Admin</h5>
            <div class="mb-2">
                <span class="info-label">Email:</span>
                <span class="info-value">{{$pay->admin_email}}</span>
            </div>
            @if(!empty($pay->wa_admin))
            <div class="mb-2">
                <span class="info-label">No. WA:</span>
                <span class="info-value">{{$pay->wa_admin}}</span>
                <a href="{{ url('https://wa.me/'.$pay->wa_admin) }}" target="_blank" class="btn btn-success btn-sm ms-2">
                    <i class="fab fa-whatsapp me-1"></i> 
                </a>
            </div>
            <p class="text-muted small mt-2">*Hubungi admin jika ada kendala, pelanggaran, pembatalan kontrak, dll</p>
            @endif
        </div>

        <!-- Payment Status Section -->
        <div class="info-card">
            <h5 class="section-title">Status Pembayaran</h5>
            @if(!$pay->poto_client)
            <span class="status-badge status-pending">Belum Dibayar Oleh Client</span>
            @elseif($pay->poto)
            <span class="status-badge status-success">Uang Telah Dikirim Admin</span>
            <div class="mt-2">
                <img  class="popup-image" src="{{url('imageup/'.$pay->poto)}}" width="120" style="cursor: pointer;">
                <p class="small text-muted mt-2">*Potongan komisi sebesar 8%</p>
            </div>
            @elseif($pay->poto_client)
            <span class="status-badge status-danger">Telah Dibayar Client Namun Belum Dikirim Admin</span>
            @else
            <span class="status-badge status-danger">Error: segera hubungi admin</span>
            @endif
        </div>

        <!-- Payment Proof Section -->

        <form id="formClientEdit" enctype="multipart/form-data">

            @csrf
            <input type="hidden" value="{{$pay->id_pay}}" name="id_pay">
            <input type="hidden" value="{{$kontrak->id_kontrak}}" name="id_kontrak">
            <input type="hidden" name="status_pay" value="{{$kontrak->delivarable ? '1' : $pay->status}}">

            <div class="info-card">
                <h5 class="section-title">Foto Bukti Transfer</h5>
                @if($kontrak->status == 8)
                @else
                <p class="small">* Silahkan transfer uang ke admin jika harga telah ditetapkan</p>
                <p class="small">a/n <b>adminbikininindonesia</b> | no. rek <b>09876345678909876545678</b></p>
                @endif

                <div class="mt-3">
                    <label for="poto">Foto Bukti Transfer</label><br>

                    @if($pay->poto_client)
                        <!-- Tampilkan foto jika ada -->
                        <img id="previewbukti" class="popup-image" src="{{url('imageup/'.$pay->poto_client)}}" width="100px">
                        <input type="hidden" name="potoAda" value="{{$pay->poto_client}}">
                    @else
                        <!-- Placeholder untuk preview gambar baru -->
                        <img id="previewbukti" src="" class="popup-image" width="100px" style="display: none;">

                    @endif
                    
                </div>

                @if($kontrak->status != 8)
                <div class="custom-file mt-3">
                    <input type="file" class="custom-file-input" name="poto" id="exampleInputFile" {{ $kontrak->poto ? '' : 'required' }} onchange="previewTransfer(event)">
                    <label class="custom-file-label" for="exampleInputFile" id="fileLabel">
                        {{ $pay->poto_client ? substr($pay->poto_client,20) : 'Pilih Foto' }}
                    </label>
                </div>
                @endif
            </div>

            @if($kontrak->status != 8)
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-success">Submit Pembayaran</button>
            </div>
            @endif
        </form>
        <br>

        <div class="info-card">
            <h5 class="section-title">History Pembayaran</h5>
            <div class="table-responsive">
                @if($hispay->isEmpty())
                    <div class="text-center col-md-12">
                        <p>Belum ada pembayaran yang tuntas.</p>
                    </div>
                @else
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Transfer Client</th>
                            <th>Transfer Admin</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hispay as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}</td>    

                      
                            <td>
                                @if($p->poto_client)
                                <img src="{{ url('imageup/'.$p->poto_client) }}" alt="client" class="popup-image" style="height: 50px; cursor: pointer; border-radius: 5px;">
                                @else
                                <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($p->poto_admin)
                                <img src="{{ url('imageup/'.$p->poto_admin) }}" alt="admin" class="popup-image" style="height: 50px; cursor: pointer; border-radius: 5px;">
                                @else
                                <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                
            </div>
        </div>

        <!-- Supporting Files Section -->
        <div class="mt-4">
            <h5 class="section-title">File Pendukung</h5>
            <form id="uploadForm" action="{{ url('/kontrak/inputFile') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if($kontrak->status != 8)
                <input type="hidden" name="id_kontrak" value="{{$kontrak->id_kontrak}}">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file_kontrak" id="fileInput" multiple>
                    <label class="custom-file-label" for="fileInput">Upload File (Jika dibutuhkan)</label>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
                @endif
            </form>

            @if($file->isNotEmpty())
            <div class="mt-3">
                <h6 class="info-label">File yang sudah ada:</h6>
                <div class="list-group">
                    @foreach($file as $f)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-paperclip mr-2"></i>
                                <a href="{{ url('imageup/'.$f->file) }}" target="_blank" class="text-decoration-none">
                                     {{ substr($f->file,20) }} 
                                </a>
                            </div>
                            <div>
                                <a href="{{ url('imageup/'.$f->file) }}" download class="btn btn-sm btn-outline-orange">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteFile('{{ $f->id_file }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="text-muted small mt-2">Belum ada file pendukung.</p>
            @endif
        </div>

        <!-- Deliverable Section -->
        <div class="mt-4">
            <h5 class="section-title">Deliverable</h5>
            <div class="file-card">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt file-icon"></i>
                    <span id="file-name" class="file-name">
                        {{ $kontrak->delivarable ? substr(basename($kontrak->delivarable),20) : 'Belum ada file' }}
                    </span>
                </div>
                <div class="mt-3">
                    @if($pay->poto_client)
                    <a href="{{ route('download.file', $kontrak->id_kontrak) }}" class="btn btn-outline-orange btn-sm">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                    @else
                    <button class="btn btn-outline-orange btn-sm" onclick="tdkBisadownload()">
                        <i class="fas fa-download mr-1"></i> Download
                    </button>
                    @endif
                </div>
            </div>

            @if($kontrak->status != 8)
                @if($pay->status == 4)
                <form id="akhiriKontrakForm" action="{{ url('kontrak/akhiri') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_kontrak" value="{{ $kontrak->id_kontrak }}">
                    <input type="hidden" name="id_free" value="{{ $kontrak->id_free }}">
                    <input type="hidden" name="status_kontrak" value="8">
                    <input type="hidden" name="status_pay" value="8">

                    <div class="text-right mt-3">
                        <button type="button" onclick="konfirmasiAkhiri()" class="btn btn-danger">
                            <i class="fas fa-check-circle mr-1"></i> Akhiri Kontrak
                        </button>
                    </div>
                </form>
                @else
                <div class="text-right mt-3">
                    <button class="btn btn-danger" onclick="janganAkhiri()">
                        <i class="fas fa-check-circle mr-1"></i> Akhiri Kontrak
                    </button>
                </div>
                @endif
            @endif
        </div>
        @endif
    </form>
    @else




    
    <!-- Freelancer View -->
    <form id="formFreeEdit" method="post" action="{{url('kontrak/edit/free')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$kontrak->id_kontrak}}" name="id_kontrak">
        <input type="hidden" value="{{$kontrak->delivarable}}" name="delivarable">
        <input type="hidden" value="{{$pay->id_pay}}" name="id_pay">
        <input type="hidden" name="status_pay" value="{{$pay->poto_client ? '1' : $pay->status}}">
        <input type="hidden" name="status_kontrak" value="{{$kontrak->status}}">

        <div class="info-card">
            <h5 class="section-title">Deadline</h5>
            <p>*Waktu deadline bisa diubah sesuai kesepakatan</p>
            <div class="form-group mr-2">
                    <input type="date" name="deadline" readonly class="form-control" value="{{ $kontrak->deadline }}">
                </div>
        </div>


        <div class="info-card">
            <h5 class="section-title">Kode Kontrak</h5>
            <div class="mb-2" style="display: flex; align-items: center;">
                <span class="info-value" id="kodeKontrak"><b>{{$kontrak->kd_kontrak}}  </b></span>
                <span class="info-value">
                    <button id="copyBtn" onclick="copyKode()" class="btn btn-light" title="Copy kode kontrak" style="min-width: 40px;">
                        <i class="fa fa-copy"></i>
                    </button>
                </span>
            </div>

            
        </div>

        

        <!-- Admin Info Section -->
        <div class="info-card">
            <h5 class="section-title">Info Admin</h5>
            <div class="mb-2">
                <span class="info-label">Email:</span>
                <span class="info-value">{{$pay->admin_email}}</span>
            </div>
            @if(!empty($pay->wa_admin))
            <div class="mb-2">
                <span class="info-label">No. WA:</span>
                <span class="info-value">{{$pay->wa_admin}}</span>
                <a href="{{ url('https://wa.me/'.$pay->wa_admin) }}" target="_blank" class="btn btn-success btn-sm ms-2">
                    <i class="fab fa-whatsapp me-1"></i> 
                </a>
            </div>
            <p class="text-muted small mt-2">*Hubungi admin jika ada kendala, pelanggaran, pembatalan kontrak, dll</p>
            @endif
        </div>

        

        <!-- Payment Status Section -->
        <div class="info-card">
            <h5 class="section-title">Status Pembayaran</h5>
            @if(!$pay->poto_client)
            <span class="status-badge status-pending">Belum Dibayar Oleh Client</span>
            @elseif($pay->poto)
            <span class="status-badge status-success">Uang Telah Dikirim Admin</span>
            <div class="mt-2">
                <img id="preview" class="popup-image" src="{{url('imageup/'.$pay->poto)}}" width="120" style="cursor: pointer;">
                <p class="small text-muted mt-2">*Potongan komisi sebesar 8%</p>
            </div>
            @elseif($pay->poto_client)
            <span class="status-badge status-danger">Telah Dibayar Client Namun Belum Dikirim Admin</span>
            @else
            <span class="status-badge status-danger">Error: segera hubungi admin</span>
            @endif
        </div>

        <!-- Deliverable Upload Section -->
        <div class="info-card">
            <h5 class="section-title">Upload Deliverable</h5>

            {{-- Tampilkan file yang udah ada --}}
            <div class="mt-2">
                <div class="d-flex align-items-center mt-2">
                    <i class="fas fa-file-alt file-icon"></i>
                    <span id="file-name">
                        @if($kontrak->delivarable)
                            {{ substr(basename($kontrak->delivarable), 20) }}
                        @else
                            Belum ada file
                        @endif
                    </span>
                </div>
                @if($kontrak->delivarable)
                <input type="hidden" name="potoAda" value="{{$kontrak->delivarable}}">
                @endif
            </div>

            {{-- Input file cuma muncul kalau status bukan 8 --}}
            @if($kontrak->status != 8)
            <div class="custom-file mt-3">
                <input type="file"
                    class="custom-file-input"
                    name="poto"
                    id="exampleInputFile"
                    {{ $kontrak->delivarable ? '' : 'required' }}
                    onchange="previewDeliverable(event)">
                <label class="custom-file-label" id="fileLabel" for="exampleInputFile">
                    {{ $kontrak->delivarable ? substr(basename($kontrak->delivarable), 20) : 'Pilih File' }}
                </label>
            </div>
            @endif
        </div>

        {{-- Tombol submit juga cuma muncul kalau status bukan 8 --}}
        @if($kontrak->status != 8)
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-success">Submit Deliverable</button>
        </div>
        @endif


        <!-- Supporting Files Section -->
        @if($file->isNotEmpty())
        <div class="mt-4">
            <h5 class="section-title">File Bantuan dari Client</h5>
            <div class="list-group">
                @foreach($file as $f)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-paperclip mr-2"></i>
                            <a href="{{ url('imageup/'.$f->file) }}" target="_blank" class="text-decoration-none">
                                {{ substr($f->file,20) }}
                            </a>
                        </div>
                        <div>
                            <a href="{{ url('imageup/'.$f->file) }}" download class="btn btn-sm btn-outline-orange">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <p class="text-muted small mt-4">Belum ada file bantuan dari client.</p>
        @endif
    </form>
    @endif
</div>

<!-- JavaScript remains the same as in your original code -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- xc -->
<!-- buktitransfer -->
<script>
   window.previewTransfer = function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewbukti');
        const fileLabel = document.getElementById('fileLabel');

        if (!file) {
            preview.style.display = 'none';
            fileLabel.textContent = 'Pilih Foto';
            return;
        }

        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        const fileExt = file.name.split('.').pop().toLowerCase();

        fileLabel.textContent = file.name;

        if (imageExtensions.includes(fileExt)) {
            const reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }


     



    $('#formClientEdit').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ url("kontrak/edit/client") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Upload berhasil!',
                    timer: 2000,
                    showConfirmButton: true
                });
                console.log(res);
            },
            error: function (xhr) {
                let errMsg = xhr.responseJSON?.message || 'Upload gagal, cek file atau koneksi.';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errMsg
                });
                console.error(xhr);
            }

        });
    });


</script>

<!-- session -->
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
</script>

<!-- akhiri kontrak -->
<script>
    function janganAkhiri() {
        Swal.fire({
            title: 'Mengakhiri Kontrak?',
            text: "Maaf, kontrak belum terselesaikan!",
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }

    function tdkBisadownload() {
        Swal.fire({
            title: 'Selesaikan Transaksi!',
            text: "Maaf, anda harus menyelesaikan Transaksi sebelum mengambilnya!",
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }

    function konfirmasiAkhiri() {
        Swal.fire({
            title: 'Mengakhiri Kontrak?',
            html: `
                <div class="text-left">
                    <div class="user-profile mb-3">
                        <img class="user-avatar" src="{{url('imageup/'.$kontrak->pp_free)}}" alt="Freelancer">
                        <a href="{{url('profile/'.$kontrak->id_free)}}" class="user-name">
                            {{$kontrak->freelancer_username}}
                        </a>
                    </div>
                    <div class="form-group">
                        <label>Ulasan Untuk Freelancer</label>
                        <textarea id='ulasan' class='form-control' placeholder='Bagaimana pengalaman bekerja dengan freelancer ini?' rows='3'></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <div id='rating-stars' class="star-rating">
                            ${[1, 2, 3, 4, 5].map(num => `<span class='star' data-value='${num}' onclick='selectStar(${num})' onmouseover='hoverStar(${num})' onmouseout='resetStars()'>★</span>`).join('')}
                        </div>
                        <input type='hidden' id='rating' value=''>
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF8000',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Akhiri!',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                const ulasan = document.getElementById('ulasan').value;
                const rating = document.getElementById('rating').value;

                if (!ulasan || !rating) {
                    Swal.showValidationMessage('Semua field harus diisi!');
                }
                return { ulasan, rating };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { ulasan, rating } = result.value;
                $.ajax({
                    url: '{{ url('kontrak/akhiri') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_kontrak: '{{ $kontrak->id_kontrak }}',
                        status_kontrak: '8',
                        status_pay: '8',
                        ulasan: ulasan,
                        rating: rating
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Kontrak telah diakhiri.`,
                            icon: 'success'
                        }).then(() => {
                            window.location.href = '/kontrak';
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: `Terjadi kesalahan`,
                            icon: 'error'
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Kontrak tidak jadi diakhiri!',
                    icon: 'info'
                });
            }
        });
    }

    function selectStar(rating) {
        document.getElementById('rating').value = rating;
        document.querySelectorAll('#rating-stars .star').forEach(star => {
            star.classList.remove('selected', 'hovered');
        });
        for (let i = 1; i <= rating; i++) {
            document.querySelector(`#rating-stars .star[data-value='${i}']`).classList.add('selected');
        }
    }

    function hoverStar(rating) {
        document.querySelectorAll('#rating-stars .star').forEach(star => {
            star.classList.remove('hovered');
        });
        for (let i = 1; i <= rating; i++) {
            document.querySelector(`#rating-stars .star[data-value='${i}']`).classList.add('hovered');
        }
    }

    function resetStars() {
        const rating = document.getElementById('rating').value;
        document.querySelectorAll('#rating-stars .star').forEach(star => {
            star.classList.remove('hovered');
        });
        if (rating) {
            for (let i = 1; i <= rating; i++) {
                document.querySelector(`#rating-stars .star[data-value='${i}']`).classList.add('selected');
            }
        }
    }
</script>

<!-- preview -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".popup-image").forEach(img => {
            img.addEventListener("click", function () {
                Swal.fire({
                    html: `<img src="${this.src}" style="max-width: 90%; max-height: 80vh; border-radius: 10px;">`,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: "auto",
                    padding: "1rem"
                });
            });
        });
    });
</script>

<!-- deletfilekontrak -->
<script>
    function deleteFile(fileId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "File akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('/kontrak/hapusFile') }}/" + fileId, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Terhapus!', 'File berhasil dihapus.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', 'File tidak dapat dihapus.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    console.error('Error:', error);
                });
            }
        });
    }
</script>

<!-- deadline -->
<script>
    $(document).ready(function() {
        $('#submit-deadline').click(function(e) {
            e.preventDefault();

            let idKontrak = $('input[name="id_kontrak_deadline"]').val().trim();
            let deadline = $('input[name="deadline"]').val().trim();

            if (!idKontrak || !deadline) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Harap isi semua field!'
                });
                return;
            }

            $.ajax({
                url: '/kontrak/deadline',
                type: 'POST',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: {
                    id_kontrak_deadline: idKontrak,
                    deadline: deadline
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message 
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                }
            });
        });
    });
</script>

<!-- delivareble -->
<script>
    $(document).ready(function () {
        // Fungsi buat ganti teks nama file saat user pilih file
        window.previewDeliverable = function (event) {
            const file = event.target.files[0];
            if (file) {
                $('#file-name').text(file.name);
                $('#fileLabel').text(file.name);
            }
        };

        // Ajax submit form (kalau lo make form id-nya formFreeEdit)
        $('#formFreeEdit').on('submit', function (e) {
            e.preventDefault();

            const form = $(this)[0];
            const formData = new FormData(form);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Deliverable berhasil diupload!',
                        timer: 2000,
                        showConfirmButton: true
                    });
                },
                error: function (xhr) {
                    const errMsg = xhr.responseJSON?.message || 'Upload gagal, cek file atau koneksi.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errMsg
                    });
                }
            });
        });
    });
</script>


<!-- inputfilekontrak -->
<script>
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        // Cek apakah .list-group ada
        var listGroup = $('.list-group')[0];
        var scrollPosition = listGroup ? listGroup.scrollTop : 0;

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'File berhasil diupload!',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    location.reload(); // refresh halaman
                });

                

                if (listGroup) {
                    listGroup.scrollTop = scrollPosition;
                }
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'File Gagal diupload!',
                    timer: 2000,
                    showConfirmButton: true
                });
            }
        });
    });


    document.getElementById('fileInput').addEventListener('change', function(event) {
        let fileLabel = event.target.nextElementSibling;
        let fileNames = Array.from(event.target.files).map(file => file.name).join(', ');
        fileLabel.textContent = fileNames || "Upload File (Jika dibutuhkan):";
    });

</script>

<!-- copycode -->
<script>
                function copyKode() {
                    const kode = document.getElementById('kodeKontrak').innerText.trim();
                    const btn = document.getElementById('copyBtn');

                    navigator.clipboard.writeText(kode).then(() => {
                        // Ubah tombol sementara kasih feedback
                        btn.innerHTML = '✓';  // ganti icon ke centang
                        btn.classList.remove('btn-light');
                        btn.classList.add('btn-light');

                        setTimeout(() => {
                            btn.innerHTML = '<i class="fa fa-copy"></i>';  // balikin icon copy
                            btn.classList.remove('btn-light');
                            btn.classList.add('btn-light');
                        }, 3000); // 2 detik feedback muncul
                    }).catch(err => {
                        alert('Gagal menyalin kode kontrak.');
                        console.error(err);
                    });
                }
</script>

@endsection