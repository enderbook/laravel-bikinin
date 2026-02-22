@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title d-flex justify-content-between">
                Tabel Data Bidang
                <a href="bidang/input" class="btn btn-success">
                    Tambah <i class="fa fa-plus"></i>
                </a>
            </h4>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari bidang...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bidang</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bidang as $p)
                        
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td><p>{{ $p->bidang }}</p></td>
                            
                            
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
    });
</script>

@endsection
