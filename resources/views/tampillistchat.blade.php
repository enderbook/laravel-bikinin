@extends('template')

@section('konten')

    <div class="card-header bg-white">
        <h4 class="card-title mb-0">Chats</h4>
    </div>
        <ul class="contact-list">
            @foreach($chat as $c)
            @if($c->user_name == Auth::user()->username)

            <li>
                <a href="chat/pesan/{{$c->id_chat}}" class="contact-cont">
                    <div class="float-left user-img m-r-10">
                        <img src="{{ url('imageup/'.$profile->foto_profile) }}" alt="" class="w-40 rounded-circle">
                        <span class="status online"></span>
                    </div>
                    <div class="contact-info">
                        <span class="contact-name text-ellipsis">{{$c->user2_name}}</span>
                        <span class="contact-date">Woi!</span>
                    </div>
                </a>
            </li>
            @else
            <li>
                <a href="chat/pesan/{{$c->id_chat}}" class="contact-cont">
                    <div class="float-left user-img m-r-10">
                        <img src="{{ url('imageup/'.$profile->foto_profile) }}" alt="" class="w-40 rounded-circle">
                        <span class="status online"></span>
                    </div>
                    <div class="contact-info">
                        <span class="contact-name text-ellipsis">{{$c->user_name}}</span>
                        <span class="contact-date">Woi!</span>
                    </div>
                </a>
            </li>
            @endif
            @endforeach
            


            
            
        </ul>
    </div>
   

<style>
.contact-list li {
    list-style-type: none;
    margin-bottom: 10px;
}

.contact-list li a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
}

.contact-list li:hover {
    background-color: rgba(128, 128, 128, 0.3); /* Light gray on hover */
}
</style>

@endsection
