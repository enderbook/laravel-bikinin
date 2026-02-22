@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title d-flex justify-content-between">
                Tabel Data News
                
                <a href="/admin/news/input">
                    <button type="button" class="btn btn-success" ><i class="fa fa-plus"></i>Tambah</button>
                </a>
            </h4>

            {{-- 🔍 Input Pencarian --}}
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari news...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Poster (2 : 1)</th>
                            <th>link</th>
                            <th>Admin</th>
                            <th colspan="2">Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $n)
                        <tr>
                            <td class="text-capitalize">{{ $n->judul_news }}</td>
                            <td>
                                @if($n->img_news)
                                <img class="popup-image" src="{{ url('imageup/'.$n->img_news) }}" width="100px" alt="Poster News">
                                @else
                                <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>
                            <td><a href="{{ $n->link }}">{{ $n->link }}</a></td>
                            <td>{{ $n->admin_name }}</td>
                            <td>
                                <a href="/admin/news/hapus/{{ $n->id_news }}">
                                    <button type="button" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin ngehapus news ini?')"><i class="fa fa-trash"></i></button>
                                </a>
                            </td>
                            <td>
                                <a href="/admin/news/edit/{{ $n->id_news }}">
                                    <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
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
    const tableBody = document.querySelector('tbody');

    tableBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('popup-image')) {
            Swal.fire({
                html: `<img src="${e.target.src}" style="max-width: 90%; max-height: 80vh; border-radius: 10px;">`,
                showCloseButton: true,
                showConfirmButton: false,
                width: "auto",
                padding: "1rem"
            });
        }
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
