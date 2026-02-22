@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title d-flex justify-content-between">
                Tabel History Data Pembayaran
                {{-- Tombol Refresh --}}
                
            </h4>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari pembayaran...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kode kontrak</th>
                            <th>Tanggal</th>
                            <th>Client</th>
                            <th>Freelancer</th>
                            <th>Transfer Client</th>
                            <th>Transfer Admin</th>
                            <th colspan="2">Hapus</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hispay as $p)
                        <tr>
                            <td><b>{{ $p->kode_kontrak }}</b></td>  
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}</td>    
                            <td class="text-capitalize"><p> {{ $p->wa_free }} <a href="{{ url('https://wa.me/'.$p->no_free) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></p> 
                            </td>
                            <td class="text-capitalize"><p> {{ $p->wa_client }} <a href="{{ url('https://wa.me/'.$p->no_client) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></p> 
                            </td>
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

                            
                            
                            <td>
                                <a href="{{ url('admin/hispay/hapus/' . $p->id_hispay) }}">
                                    <button type="button" onclick="return confirm('Apakah Anda Yakin Akan Menghapus histori Ini?')" class="btn btn-danger">
                                        <i class="fa fa-trash text-light"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



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

        // 🔍 Search
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });

        document.querySelectorAll(".popup-image").forEach(img => {
            img.addEventListener("click", function () {
                Swal.fire({
                    html: `<img src="${this.src}" style="max-width: 100%; border-radius: 10px;">`,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: 600,
                    padding: '1rem',
                    background: '#fff',
                });
            });
        });
    });
</script>

@endsection
