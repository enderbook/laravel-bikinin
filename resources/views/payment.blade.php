@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title d-flex justify-content-between">
                Tabel Data Pembayaran
                {{-- Tombol Refresh --}}
                <button class="btn btn-primary" onclick="window.location.reload();">
                    <i class="fa fa-sync-alt"></i> Refresh
                </button>
            </h4>

            {{-- 🔍 Input Pencarian --}}
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari pembayaran...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kode Kontrak</th>
                            <th>Judul Job</th>
                            <th>Client</th>
                            <th>Freelancer</th>
                            <th>Bukti Client</th>
                            <th>Delivarable</th>
                            <th colspan="2">Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pay as $p)
                        
                        <tr>
                            @if($p->status == 2 || $p->status == 1)
                            <td><p>{{ $p->kd_kon }}</p></td>
                            <td><p>{{ $p->judul_name }}</p></td>                            
                            
                            <td class="text-capitalize"><p> {{ $p->client_name }}  <a href="{{ url('https://wa.me/'.$p->wa_client) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></p> 
                            </td>
                            <td class="text-capitalize"><p> {{ $p->freelancer_name }} <a href="{{ url('https://wa.me/'.$p->wa_free) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></p> 
                            </td>
                            <td>
                                @if($p->poto_client)
                                <i class="fa fa-check text-success"></i>
                                @else
                                <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($p->del_kontrak)
                                <i class="fa fa-check text-success"></i>
                                @else
                                <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <a href="pay/done/{{ $p->id_pay }}">
                                    <button type="button" class="btn {{ $p->status == 2 ? 'btn-light' : 'btn-danger' }}">
                                        {{ $p->status == 2 ? 'Tertunda' : 'Transfer' }}
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="pay/batal/{{ $p->id_pay }}">
                                    <button type="button" onclick="return confirm('Apakah Anda Yakin Akan Mebatalkan Transaksi Ini?')" class="btn btn-danger">
                                        <i class="fa fa-trash text-light"></i>
                                    </button>
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- 🖼️ Popup Image --}}
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
    });
</script>

@endsection
