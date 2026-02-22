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

<div class="content">
    <h2>Kontrak</h2>

    <div class="tab-content" id="kontrakTabContent">
        <!-- Tab Kontrak -->
        <div class="tab-pane fade show active" id="kontrak" role="tabpanel">
            <div class="row mt-3">
                @if($kontrak->isEmpty())
                    <div class="col-12 text-center">
                        <p>Tidak ada kontrak yang tersedia.</p>
                    </div>
                @endif

                @foreach($kontrak as $k)
                    <div class="col-md-4 col-sm-6" onClick="window.location.href='kontrak/detail/{{$k->id_kontrak}}'">
                        <div class="profile-widget">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <img class="rounded-circle" src="{{ url('imageup/'.$k->pp) }}" width="50" height="50" alt="Profile Image" style="margin-right: 10px;">
                                <div>
                                    <h2 style="margin: 0; font-size: 24px; text-transform: capitalize; line-height: 1.3;">
                                        <a href="{{url('profile/'.$k->id_free)}}" style="color: #333; text-decoration: none;">
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
                                <a href="kontrak/detail/{{$k->id_kontrak}}">
                                    <p class="text-ellipsis">See For Details</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        
    </div>
</div>
@endsection
