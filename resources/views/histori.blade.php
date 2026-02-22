@extends('template')

@section('konten')
<style>
    .profile-widget {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 180px;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease, z-index 0.3s ease;
        margin-bottom: 20px; /* Tambahin jarak antar card */
    }

    .profile-widget:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        z-index: 5;
    }

    .tab-content {
        min-height: 400px;
        transition: min-height 0.3s ease;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="card-title">History</h4>

            <ul class="nav nav-tabs nav-tabs-top nav-justified">
                @if(Auth::user()->role == 'client')
                <li class="nav-item">
                    <a class="nav-link active" href="#top-justified-tab1" data-toggle="tab">Job</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="#top-justified-tab2" data-toggle="tab">Penawaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#top-justified-tab3" data-toggle="tab">Kontrak</a>
                </li>
            </ul>

            <div class="tab-content">
                @if(Auth::user()->role == 'client')
                <div class="tab-pane show active" id="top-justified-tab1">
                    @foreach($job as $j)
                        <div class="col-md-6 col-lg-4" style="float: left;" onclick="window.location.href='{{ url('freelancer/penawaran/input/' . $j->id_job) }}'">
                            <div class="profile-widget"  style="display: flex; flex-direction: column; justify-content: space-between; height: 180px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;">
                                <!-- Status Badge -->
                                @if($j->status_name == 'Posted')
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #4a90e2; color: #fff; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    Posted
                                </div>
                                @elseif($j->status_name == 'hampir')
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #FF0000; color: #fff; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    Warning
                                </div>
                                @else
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #FFD700; color: #000; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    End
                                </div>
                                @endif

                                <div style="flex: 1;">
                                    <h2 class="doctor-name text-ellipsis" style="text-align: left; margin-bottom: 10px; font-size: 24px; line-height: 1.3;">
                                        <a href="/freelancer/penawaran/input/{{$j->id_kontrak}}" style="color: #333; text-decoration: none;">{{$j->judul}}</a>
                                    </h2>
                                    <div style="text-align: left;">
                                        <div class="doc-prof" style="background-color: #4a90e2; font-size: 12px; color: #fff; margin-bottom: 10px; padding: 3px 5px; border-radius: 5px; display: inline-block;">
                                            {{$j->bidang_name}}
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                    <div class="user-country" style="text-align: left; font-size: 13px; color: #333;">
                                        <b><p style="font-size: 15px; color: #555; margin-bottom: 2px;">Batas Akhir:</p></b>
                                        {{$j->tgl_akhir}}
                                    </div>
                                    <div style="text-align: right;">
                                    <a href="javascript:void(0);" 
                                    onclick="confirmDeletejob(event, {{$j->id_job}})" 
                                    class="btn btn-danger" 
                                    style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; 
                                            position: absolute; right: 10px; cursor: pointer; z-index: 10;">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    

                    <div style="clear: both;"></div> 
                </div>
                @endif

                <div class="tab-pane {{ Auth::user()->role != 'client' ? 'show active' : '' }}" id="top-justified-tab2">
                @foreach($nawar as $n)
                    
                    <div class="col-md-4 col-sm-6" style="float: left; margin-bottom: 20px;">
                            <div class="profile-widget"
                                style="display: flex; flex-direction: column; justify-content: space-between; height: 170px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;"
                                onclick="showPenawaranDetail({{$n->id_penawaran}}, '{{$n->freelancer_username}}', '{{$n->des_tawaran}}', '{{ url('imageup/'.$n->pp) }}')">
                                
                                <!-- Bagian Profil Freelancer -->
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <img class="rounded-circle" 
                                        src="{{ url('imageup/'.$n->pp) }}" 
                                        width="50" height="50" 
                                        alt="Profile Image" 
                                        style="margin-right: 10px; object-fit: cover;">
                                    <div>
                                        <h2 style="margin: 0; font-size: 18px; text-transform: capitalize; line-height: 1.2;">
                                            <a href="#" style="color: #333; text-decoration: none;">
                                                {{$n->freelancer_username}}
                                            </a>
                                        </h2>
                                    </div>
                                </div>

                                <!-- Judul Job & Deskripsi -->
                                <div style="text-align: left; font-size: 13px; color: #333;">
                                    <h2 class="doctor-name text-ellipsis"
                                        style="margin-bottom: 5px; font-size: 16px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <a href="penawaran/detail/{{$n->id_penawaran}}" style="color: #333; text-decoration: none;">
                                            {{$n->judul_job}}
                                        </a>
                                    </h2>
                                  
                                </div>

                                <!-- Status Box -->
                                @if(in_array($n->status,[8,10,12]))
                                <div style="background-color: #28a745; color: white; text-align: center; padding: 5px; border-radius: 5px; font-size: 13px; font-weight: bold; margin-top: auto;">
                                    Diterima
                                </div>
                                @else
                                <div style="background-color:rgb(192, 7, 7); color: white; text-align: center; padding: 5px; border-radius: 5px; font-size: 13px; font-weight: bold; margin-top: auto;">
                                    Ditolak
                                </div>
                                @endif

                                <!-- Tombol Hapus -->
                                <button onclick="confirmDeletenawar(event, {{$n->id_penawaran}})" 
                                        class="btn btn-danger"
                                        style="padding: 5px 8px; background-color: #d9534f; border: none; border-radius: 4px; 
                                                position: absolute; right: 10px; top: 10px; cursor: pointer;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

                  
                    @endforeach

                    <div style="clear: both;"></div> 
                </div>

                <div class="tab-pane" id="top-justified-tab3">
                    @foreach($kontrak as $k)
                        <div class="col-md-4 col-sm-6" style="float: left;">
                            <div class="profile-widget" onclick="window.location.href='{{ url('kontrak/detail/'.$k->id_kontrak) }}'">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <img class="rounded-circle" 
                                        src="{{ url('imageup/'.$k->pp) }}" 
                                        width="50" height="50" 
                                        alt="Profile Image" 
                                        style="margin-right: 10px; object-fit: cover;">
                                    <div>
                                        <h2 style="margin: 0; font-size: 24px; text-transform: capitalize; line-height: 1.3;">
                                        <a href="{{ url('kontrak/detail/' . $k->id_kontrak) }}"
                                        style="color: #333; text-decoration: none;">
                                                {{$k->freelancer_username}}
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                                <div style="text-align: left; font-size: 13px; color: #333;">
                                    <h2 class="doctor-name text-ellipsis">
                                        <a href="kontrak/detail/{{$k->id_kontrak}}" style="color: #333; text-decoration: none;">
                                            {{$k->judul_job}}
                                        </a>
                                    </h2>
                                    <a href="{{ url('kontrak/detail/' . $k->id_kontrak) }}">
                                        <p class="text-ellipsis">See For Details</p>
                                    </a>
                                </div>
                                <button onclick="confirmDeletekontrak(event, {{$k->id_kontrak}})" 
                                    class="btn btn-danger"
                                    style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; 
                                            position: absolute; right: 10px; top: 10px; cursor: pointer;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div style="clear: both;"></div> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDeletenawar(event, id) {
        event.stopPropagation();

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus nggak bisa balik lagi bro!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, hapus aja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/history/penawaran/hapus/' + id;
            }
        });
    }

    function confirmDeletekontrak(event, id) {
        event.stopPropagation();

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus nggak bisa balik lagi bro!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, hapus aja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/history/kontrak/hapus/' + id;
            }
        });
    }

    function confirmDeletejob(event, id) {
        event.stopPropagation();

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus nggak bisa balik lagi bro!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, hapus aja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/history/job/hapus/' + id;
            }
        });
    }

</script>

<script>
    function showPenawaranDetail(id, username, deskripsi, foto) {
    Swal.fire({
        title: 'Detail Penawaran',
        width: 500, 
        html: `
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                <img src="${foto}" width="60" height="60" style="border-radius: 50%;" alt="Foto Freelancer">
                <h3 style="margin: 0; font-size: 18px;">${username}</h3>
            </div>
            <div style="max-height: 300px; overflow-y: auto; padding-right: 10px; text-align: justify;">
                <p style="font-size: 14px;">${deskripsi}</p>
            </div>
        `,
        confirmButtonText: 'close'
    });
    }

</script>
@endsection
