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

    .ad-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
        text-align: center;
        border: 1px solid #e0e6ed;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .ad-title {
        font-size: 18px;
        font-weight: 600;
        color: #3a3a3a;
        margin-bottom: 10px;
    }

    .ad-content {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .ad-button {
        background-color: #4a90e2;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .ad-button:hover {
        background-color: #3a7bc8;
    }

    .ellipsis-6-lines {
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%; /* atau atur sesuai kebutuhan */
        text-align: justify;

        font-size: 13px;
        line-height: 1.5;
        max-height: calc(1.5em * 6); /
    }


    
</style>



<h1>
    Welcome Here {{ Auth::user()->username }} !
</h1>
<p class="font-18 max-width-600">
    Anda login sebagai <b class="text-capitalize">{{ Auth::user()->role }}</b>
</p>
    

<br>

@if(Auth::user()->role == 'client')

    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
            <div class="dash-widget">
				<span class="dash-widget-bg1"><i class="fa fa-folder" aria-hidden="true"></i></span>
				<div class="dash-widget-info text-right">
					<h3>{{$job}}</h3>
					<span class="widget-title1">Job Aktif<i class="fa fa-check" aria-hidden="true"></i></span>
				</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
            <div class="dash-widget">
                <span class="dash-widget-bg2"><i class="fa fa-comments"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$kontrak}}</h3>
                    <span class="widget-title2">Kontrak Aktif<i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
            <div class="dash-widget">
                <span class="dash-widget-bg4"><i class="fa fa-address-book" aria-hidden="true"></i></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$penawaran}}</h3>
                    <span class="widget-title4">Penawaran<i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>

   

    <div style="position: relative; width: 100%; margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Cari freelancer..." style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #ddd; border-radius: 5px;">
        <i class="fa fa-search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #888;"></i>
    </div>
    <p id="noResults" style="text-align: center; color: #888; display: none;">Pencarian tidak ditemukan</p>

    <br>
    <div class="content">
    <div class="row doctor-grid">
        @foreach($free as $f)
        <div class="col-md-6 col-lg-4 search-item" onClick="window.location.href='profile/{{$f->id_user}}'"> 
            <div class="profile-widget" style="display: flex; flex-direction: column; justify-content: space-between; height: 180px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative;">
                
                <!-- Status Badge -->
                <div class="status-badge" style="position: absolute; top: 20px; right: 20px; background-color: #4a90e2; color: #fff; font-size: 8px; padding: 3px 5px; border-radius: 5px; text-align: center;">
                    {{$f->bidang_name}}
                </div>

                <!-- Logo Profil dan Nama Freelancer -->
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <!-- Logo Profil -->
                    <img class="rounded-circle" src="{{url('imageup/'.$f->foto_profile)}}" width="30" height="30" alt="Profile Image" style="margin-right: 10px;">
                    
                    <!-- Nama Freelancer -->
                    <div style="text-align: ; ">
                        <h2 class="nama-freelancer" class=" " style="margin: 0; font-size: 13px; text-transform: capitalize; line-height: 1.3;">
                            <a href="profile/{{$f->id_user}}" style="color: #333; text-decoration: none;">{{$f->nm_depan}} {{$f->nm_belakang}}</a>
                        </h2>
                    </div>
                    
                </div>

                <div style="text-align: left;" class="review-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star{{ $i <= $f->average_rating ? ' text-warning' : ' text-secondary' }}"></i>
                    @endfor
                </div>

                <!-- Bio Freelancer -->
                <div style="text-align: left;">
                    <h2 class="bio-freelancer" style="margin: 0; font-size: 24px; line-height: 1.3;">
                        <a href="profile/{{$f->id_user}}" class="ellipsis-6-lines" style="color: #333; text-decoration: none;">
                            {{ $f->des_singkat }}
                        </a>

                    </h2>
                </div>
            
                <!-- Link ke Portofolio -->
                <div style="text-align: left;">
                    <div class="doc-prof" style="font-size: 12px; color: #000; margin-bottom: 10px; padding: 5px 0px; border-radius: 5px; display: inline-block;">
                        <a href="profile/{{$f->id_user}}">See Profile</a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
    </div>
@elseif(Auth::user()->role == 'admin')
    <h3>Siap Kerja Hari Ini?!</h3>
    
    <!-- Ad Section for Admin -->
    <div class="ad-container">
        <div class="ad-title">Alat Administrasi Khusus</div>
        <div class="ad-content">Kelola sistem dengan lebih efisien menggunakan alat admin terbaru kami.</div>
    </div>

@elseif(Auth::user()->role == 'freelancer')
    <div class="row">
        
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
            <div class="dash-widget">
                <span class="dash-widget-bg2"><i class="fa fa-comments"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$kontrak}}</h3>
                    <span class="widget-title2">Kontrak Aktif<i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
            <div class="dash-widget">
                <span class="dash-widget-bg4"><i class="fa fa-address-book" aria-hidden="true"></i></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$penawaran}}</h3>
                    <span class="widget-title4">Penawaran<i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
    


    <h3>Mana Yang Akan Dikerjakan Hari Ini?!</h3>
    <div style="position: relative; width: 100%; margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Cari pekerjaan..." style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #ddd; border-radius: 5px;">
        <i class="fa fa-search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #888;"></i>
    </div>
    <p id="noResults" style="text-align: center; color: #888; display: none;">Pencarian tidak ditemukan</p>

    <div class="row doctor-grid">
        @foreach($job as $j)
            <div class="col-md-6 col-lg-4 search-item" onClick="window.location.href='freelancer/penawaran/input/{{$j->id_job}}'">
                <div class="profile-widget" style="display: flex; flex-direction: column; justify-content: space-between; height: 250px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative;">
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
                        <h2 class="judul-job" class="doctor-name text-ellipsis" style="text-align: left; margin-bottom: 10px; font-size: 24px; line-height: 1.3;">
                            <a href="freelancer/penawaran/input/{{$j->id_job}}" style="color: #333; text-decoration: none;">{{$j->judul}}</a>
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
                       
                    </div>
                    <div class="user-country" style="text-align: left; font-size: 13px; color: #333;">
                        <div style="background: #f6f6f6; padding: 2px 15px; border-left: 4px solid #ff8000; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: bold; color: #ff8000;">
                                💰 Rp {{ number_format($j->harga, 0, ',', '.') }},00
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
        e.preventDefault(); // Mencegah scroll ke atas
        
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.search-item');
        let found = false;

        items.forEach(item => {
            let nama = item.querySelector('.nama-freelancer')?.innerText.toLowerCase() || '';
            let bio = item.querySelector('.bio-freelancer')?.innerText.toLowerCase() || '';
            let judul = item.querySelector('.judul-job')?.innerText.toLowerCase() || '';

            if (nama.includes(filter) || bio.includes(filter) || judul.includes(filter)) {
                item.style.display = "";
                found = true;
            } else {
                item.style.display = "none";
            }
        });

        document.getElementById('noResults').style.display = found ? "none" : "block";
    });
</script>

@endsection