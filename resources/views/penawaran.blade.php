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
    <h2>Penawaran</h2>
    <div class="tab-content">
        <div class="tab-pane show active" id="top-justified-tab1">
            <div class="row">
                <!-- Jika tidak ada penawaran -->
                @if($nawar->isEmpty())
                <div class="col-12 text-center">
                    <p>Tidak ada penawaran yang tersedia.</p>
                </div>
                @endif

                <!-- Daftar Penawaran -->
                @foreach($nawar as $n)
                    <div class="col-md-4 col-sm-6" onclick="window.location.href='{{ url('penawaran/detail/' . $n->id_penawaran) }}'">
                        <div class="profile-widget"
                             style="display: flex; flex-direction: column; justify-content: space-between; height: 140px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; position: relative; transition: transform 0.2s, box-shadow 0.2s;">

                            

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

                            <div style="text-align: left; font-size: 13px; color: #333;" onclick="window.location.href='penawaran/detail/{{$n->id_penawaran}}'">
                                <!-- Judul job dengan elipsis -->
                                <h2 class="doctor-name" style="
                                    margin-bottom: 5px; 
                                    font-size: 17px; 
                                    line-height: 1.3; 
                                    max-width: 250px;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                ">
                                    <a href="{{ url('penawaran/detail/' . $n->id_penawaran) }}" 
                                    style="color: #000000; text-decoration: none; display: inline-block; max-width: 100%;">
                                        {{ $n->judul_job }}
                                    </a>
                                </h2>

                                <p><span>{{ $n->created_at->format('d M Y') }}</span></p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
