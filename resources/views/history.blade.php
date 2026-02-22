@extends('template')

@section('konten')
<style>
    .profile-widget {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 150px;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease, z-index 0.3s ease;
    }

    .profile-widget:hover {
        transform: scale(1.2);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        z-index: 20;
    }
</style>

<div class="content container-fluid">
    <h2>History</h2>

    <br><br>
    
    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
    <li class="nav-item"><a class="nav-link active" href="#tab-kontrak" data-toggle="tab">Kontrak</a></li>
    <li class="nav-item"><a class="nav-link" onclick="setActiveTab('penawaranTab')" href="#tab-penawaran" data-toggle="tab">Penawaran</a></li>
    @if(Auth::user()->role == 'client')
    <li class="nav-item"><a class="nav-link" href="#tab-job" data-toggle="tab">Job</a></li>
    @endif
</ul>

<div class="tab-content w-100 mt-3">
    <!-- Tab Kontrak -->
    <div class="tab-pane fade show active" id="tab-kontrak">
        <div class="row">
                @if($kontrak->isEmpty())
                    <div class="col-12 text-center">
                        <p>Tidak ada kontrak yang tersedia.</p>
                    </div>
                @endif

                @foreach($kontrak as $k)
                <div class="col-md-4 col-sm-6" onClick="window.location.href='{{ url('kontrak/detail/' . $k->id_kontrak) }}'">
                <div class="profile-widget" >
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <img class="rounded-circle" src="{{ url('imageup/'.$k->pp) }}" width="50" height="50" alt="Profile Image" style="margin-right: 10px;">
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
                            <button onclick="confirmDelete(event, {{$k->id_kontrak}})" 
                                class="btn btn-danger"
                                style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; 
                                        position: absolute; right: 10px; top: 10px; cursor: pointer;">
                            <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>

    <!-- Tab Penawaran -->
    <div class="tab-pane fade"  id="tab-penawaran">
        <div class="row">
            @foreach($nawar as $n)
                @if($n->status == 8)
                <div class="col-md-4 col-sm-6" >
                    <div class="profile-widget"
                        style="display: flex; flex-direction: column; justify-content: space-between; height: 180px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative; transition: transform 0.2s, box-shadow 0.2s;"
                        onclick="showPenawaranDetail({{$n->id_penawaran}}, '{{$n->freelancer_username}}', '{{$n->des_tawaran}}', '{{ url('imageup/'.$n->pp) }}')">

                        <!-- Bagian Profil Freelancer -->
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img class="rounded-circle" 
                                src="{{ url('imageup/'.$n->pp) }}" 
                                width="50" height="50" 
                                alt="Profile Image" 
                                style="margin-right: 10px;">
                            <div>
                                <h2 style="margin: 0; font-size: 24px; text-transform: capitalize; line-height: 1.3;">
                                    <a href="#" style="color: #333; text-decoration: none;">
                                        {{$n->freelancer_username}}
                                    </a>
                                </h2>
                            </div>
                                    
                        </div>
                        

                        <div style="text-align: left; font-size: 13px; color: #333;">
                            <h2 class="doctor-name text-ellipsis"
                                style="margin-bottom: 10px; font-size: 17px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                <a href="penawaran/detail/{{$n->id_penawaran}}" style="color: #333; text-decoration: none;">
                                    {{$n->judul_job}}
                                </a>
                            </h2>
                            <a href="">
                                <p class="text-ellipsis" 
                                style="color: #333; margin-bottom: 10px; font-size: 10px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                    {!! $n->des_tawaran !!}
                                </p>
                            </a>
                        </div>

                        <!-- Kotak Hijau "Diterima" -->
                        <div style="background-color: #28a745; color: white; text-align: center; padding: 5px; border-radius: 5px; font-size: 14px; font-weight: bold; margin-top: auto;">
                            Diterima
                        </div>


                        @if(Auth::user()->role == 'freelancer')
                        <button onclick="confirmDelete(event, {{$n->id_penawaran}})" 
                                class="btn btn-danger"
                                style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; 
                                        position: absolute; right: 10px; top: 10px; cursor: pointer;">
                            <i class="fa fa-trash"></i>
                        </button>
                        @endif


                    </div>
                </div>
                @else
                <div class="col-md-4 col-sm-6" >
                    <div class="profile-widget"
                        style="display: flex; flex-direction: column; justify-content: space-between; height: 180px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative; transition: transform 0.2s, box-shadow 0.2s;"
                        onclick="showPenawaranDetail({{$n->id_penawaran}}, '{{$n->freelancer_username}}', '{{$n->des_tawaran}}', '{{ url('imageup/'.$n->pp) }}')">

                        <!-- Bagian Profil Freelancer -->
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img class="rounded-circle" 
                                src="{{ url('imageup/'.$n->pp) }}" 
                                width="50" height="50" 
                                alt="Profile Image" 
                                style="margin-right: 10px;">
                            <div>
                                <h2 style="margin: 0; font-size: 24px; text-transform: capitalize; line-height: 1.3;">
                                    <a href="#" style="color: #333; text-decoration: none;">
                                        {{$n->freelancer_username}}
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <div style="text-align: left; font-size: 13px; color: #333;">
                            <h2 class="doctor-name text-ellipsis"
                                style="margin-bottom: 10px; font-size: 17px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                <a href="penawaran/detail/{{$n->id_penawaran}}" style="color: #333; text-decoration: none;">
                                    {{$n->judul_job}}
                                </a>
                            </h2>
                            <a href="">
                                <p class="text-ellipsis" 
                                style="color: #333; margin-bottom: 10px; font-size: 10px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                    {!! $n->des_tawaran !!}
                                </p>
                            </a>
                        </div>

                        <!-- Kotak Hijau "Diterima" -->
                        <div style="background-color:rgb(167, 40, 40); color: white; text-align: center; padding: 5px; border-radius: 5px; font-size: 14px; font-weight: bold; margin-top: auto;">
                            Ditolak
                        </div>

                        @if(Auth::user()->role == 'freelancer')

                        <button onclick="confirmDelete(event, {{$n->id_penawaran}})" 
                                class="btn btn-danger"
                                style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; 
                                        position: absolute; right: 10px; top: 10px; cursor: pointer;">
                            <i class="fa fa-trash"></i>
                        </button>
                        @endif





                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    @if(Auth::user()->role == 'client')


    <!-- Tab Job -->
    <div class="tab-pane fade" id="tab-job">
        <div class="row">
                    @foreach($job as $j)
                        <div class="col-md-6 col-lg-4">
                            <div class="profile-widget" style="display: flex; flex-direction: column; justify-content: space-between; height: 180px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative;">
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
                                        <a href="job/edit/{{$j->id_job}}" style="color: #333; text-decoration: none;">{{$j->judul}}</a>
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
                                    onclick="confirmDelete(event, {{$j->id_job}})" 
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
        </div>
    </div>
    @endif
</div>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.8/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.8/dist/sweetalert2.all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(event, jobId) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Redirect to the delete route
                window.location.href = "{{ url('your-delete-route') }}/" + jobId;
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
        showCloseButton: true,  // Tombol close (X)
        confirmButtonText: 'Tutup'
    });
    }

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    let activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        document.getElementById(activeTab).click(); // Aktifkan kembali tab terakhir
    }
    });

    function setActiveTab(tabId) {
        localStorage.setItem("activeTab", tabId);
    }

</script>



@endsection
