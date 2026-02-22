@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title">Tabel Data Pengguna
                
            </h4>

            {{-- Search Input --}}
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari pengguna...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Id User</th>
                            <th>Role</th>
                            <th>Email</th>
                            <!-- <th>Hapus</th>
                            <th>Edit</th> -->
                            <th>Blokir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $u)
                        <tr class="text-capitalize">
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->id_user }}</td>
                            <td>{{ $u->role }}</td>
                            <td>{{ $u->email }}</td>
                            <!-- <td>
                                <a href="user/hapus/{{ $u->id_user }}" onclick="return confirm('Apakah Anda Yakin Akan Menghaus Data?')">
                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </a>
                            </td>
                            <td>
                                <a href="user/edit/{{ $u->id_user }}">
                                    <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                                </a>
                            </td> -->
                            @if($u->status != 2)
                            <form action="{{ url('admin/user/blok') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $u->id_user }}">
                                <input type="hidden" name="username" value="{{ $u->username }}">
                                <input type="hidden" name="role" value="{{ $u->role }}">
                                <input type="hidden" name="email" value="{{ $u->email }}">
                                <input type="hidden" name="status" value="2">
                                <td>
                                    <button type="submit" onclick="return confirm('Apakah Anda Yakin Akan Memblokir Akun Ini?')" class="btn btn-primary"><i class="fa fa-user"></i></button>
                                </td>
                            </form>
                            @else
                            <form action="{{ url('admin/user/blok') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $u->id_user }}">
                                <input type="hidden" name="username" value="{{ $u->username }}">
                                <input type="hidden" name="role" value="{{ $u->role }}">
                                <input type="hidden" name="email" value="{{ $u->email }}">
                                <input type="hidden" name="status" value="1">
                                <td>
                                    <button type="submit" onclick="return confirm('Apakah Anda Yakin Akan Meng-unblok Akun Ini?')" class="btn btn-success"><i class="fa fa-user"></i></button>
                                </td>
                            </form>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Search Script --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
});
</script>

@endsection
