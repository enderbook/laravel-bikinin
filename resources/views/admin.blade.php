@extends('template')

@section('konten')

<div class="">
    <div class="card-box">
        <div class="card-block">
            <h4 class="card-title d-flex justify-content-between">Tabel List Admin
                <a href="/rekadmin" class="btn btn-primary">
                    <i class="fa fa-sync-alt"></i> + Rekrut Admin
                </a>
            </h4>

            {{-- Search Input --}}
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari pengguna...">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Id User</th>
                            <th>Email</th>
                            <th>No. WA</th>
                            <th>Pangkat</th>
                            <th>Pecat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $u)
                        <tr class="text-capitalize">
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->id_user }}</td>
                            <td>{{ $u->email }}</td>
                            
                            <td class="text-capitalize">
                                @if($u->wa_user)
                                <p> {{ $u->wa_user }} <a href="{{ url('https://wa.me/'.$u->wa_user) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></p> 
                                @else
                                    <p>*admin belum bikin profile.</p>
                                @endif
                            </td>
                            
                            <td>
                                @if($u->status == 0)
                                    @if(Auth::user()->id_user == $u->id_user)
                                    <a href="">
                                        <button type="button" class="btn btn-primary" onclick="return confirm('Kamu gak bisa nurunin kamu sendiri?')"><i class="fa fa-user"></i></button>
                                    </a>
                                    @else
                                    <a href="/admin/anggota/{{ $u->id_user }}">
                                        <button type="button" class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin? nurunin dia')"><i class="fa fa-user"></i></button>
                                    </a>
                                    @endif
                                @else
                                    <a href="/admin/ketua/{{ $u->id_user }}">
                                        <button type="button" class="btn btn-warning" onclick="return confirm('Apakah Anda Yakin naikin dia?')"><i class="fa fa-user"></i></button>
                                    </a>
                                @endif
                            </td>

                            <td>
                                @if($u->status == 0)
                                    <a href="">
                                        <button type="button" class="btn btn-danger" onclick="return confirm('Ketua tak bisa dipecat!')"><i class="fa fa-user"></i></button>
                                    </a>
                                @else
                                    <a href="/admin/pecat/{{ $u->id_user }}">
                                        <button type="button" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Akan Memecat Akun ini?')"><i class="fa fa-user"></i></button>
                                    </a>
                                @endif
                            </td>
                                
                            
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
