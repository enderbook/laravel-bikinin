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
        transform: scale(1.2); /* Perbesaran */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); /* Bayangan lebih tegas */
        z-index: 20; /* Membawa elemen ke depan */
    }
</style>


<div class="content">
<h2>Job</h2>
    <div class="tab-content">
        <div class="tab-pane show active" id="top-justified-tab1">
            <div class="row">
                <div class="text-left col-md-2">
                    <a href="job/add" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Jobs
                    </a>
                </div>

                @if($job->isEmpty())
                    <div class="text-center col-md-12">
                        <p>Tidak ada job yang tersedia.</p>
                    </div>
                @endif
                </div>
                <br>
                    
                <div class="row doctor-grid">
                    @foreach($job as $j)
                        <div class="col-md-6 col-lg-4" onclick="window.location.href='{{ url('freelancer/penawaran/input/' . $j->id_job) }}'">
                            <div class="profile-widget" style="display: flex; flex-direction: column; justify-content: space-between; height: 200px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative;">
                                <!-- Status Badge -->
                                @if($j->status_name == 'Posted')
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #4a90e2; color: #fff; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    {{$j->status_name}}
                                </div>
                                @elseif($j->status_name == 'End')
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #FF0000; color: #fff; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    {{$j->status_name}}
                                </div>
                                @else
                                <div class="status-badge" style="position: absolute; top: 10px; right: 10px; background-color: #FFD700; color: #000; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                                    {{$j->status_name}}
                                </div>
                                @endif

                                <div style="flex: 1;">
                                    <h2 class="doctor-name text-ellipsis" style="text-align: left; margin-bottom: 10px; font-size: 24px; line-height: 1.3;">
                                        <a href="" style="color: #333; text-decoration: none;">{{$j->judul}}</a>
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
                                     
                                        @if(in_array($j->id_job, $kontrak))
                                        <a href="" class="btn btn-warning" style="padding: 5px 10px; margin-right: 5px; background-color: #f0ad4e; border: none; border-radius: 4px; pointer-events: none; opacity: 0.6;">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Data?')" class="btn btn-danger " style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; pointer-events: none; opacity: 0.6;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @else
                                        <a href="job/edit/{{$j->id_job}}" class="btn btn-warning" style="padding: 5px 10px; margin-right: 5px; background-color: #f0ad4e; border: none; border-radius: 4px;">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button onclick="deleteJob(event, {{$j->id_job}})"  class="btn btn-danger " style="padding: 5px 10px; background-color: #d9534f; border: none; border-radius: 4px; ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="user-country" style="text-align: left; font-size: 13px; color: #333;">
                                    <div style="background: #f6f6f6; padding: 2px 15px; border-left: 4px solid #ff8000; border-radius: 8px;">
                                        <span style="font-size: 12px; font-weight: bold; color: #ff8000;">
                                            💰 Rp {{ number_format($j->harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
        </div>
</div>   

<script>

    function deleteJob(event, id) {
        event.stopPropagation(); // Mencegah klik pada parent div

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let statusValue = 9; // Jika value tidak ditemukan, pakai default 9
                window.location.href = `/client/job/hapus/${id}`;
            }
        });
    }

</script>
      



@endsection
