@extends('template')

@section('konten')
<div class="chat-main-row" style="margin-top: 20px;">
    <div class="chat-main-wrapper" style="height: 450px;">
        <div class="col-lg-9 message-view chat-view">
            <div class="chat-window">
                <div class="fixed-header">
                    <div class="navbar">
                        <div class="user-details mr-auto">
                            <div class="float-left user-img m-r-10">
                                <a href="profile.html" title="User">
                                    <img src="{{ url('imageup/'.$profile->foto_profile) }}" style="height: 7; width: 7;" alt="" class="w-40 rounded-circle">
                                    <span class="status online"></span> 
                                </a>
                            </div>
                            <div class="user-info float-left">
                                @if($chat->user_name == Auth::user()->username)
                                    <a href="profile.html"><span class="font-bold">{{$chat->user2_name}}</span></a>
                                @else
                                    <a href="profile.html"><span class="font-bold">{{$chat->user_name}}</span></a>
                                @endif
                                <span class="last-seen">Last seen today at 7:50 AM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-contents" id="chat-contents" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column-reverse;">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="chats" id="chats">
                                    @foreach($pesan as $p)
                                        @if($p->id_user == Auth::user()->id_user)
                                            <div class="chat chat-right">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <p>{{ $p->pesan }}</p>
                                                        <span class="chat-time">{{ $p->created_at->format('h:i A')  }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat chat-left">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <p>{{ $p->pesan }}</p>
                                                        <span class="chat-time">{{ $p->created_at->format('h:i A')  }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-footer">
                    <form id="chat-form" class="flex-grow-1">
                        @csrf
                        <div class="message-bar">
                            <div class="message-inner d-flex align-items-center">
                                <div class="input-group">
                                    <input type="hidden" name="id_chat" id="id_chat" value="{{ $chat->id_chat }}">
                                    <input type="text" name="pesan" id="pesan" class="form-control" placeholder="Type message...">
                                    <span class="input-group-append">
                                        <button id="send-btn" class="btn btn-primary" type="button" onclick="sendMessage()">
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="{{url('assets/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{url('assets/js/popper.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/js/app.js')}}"></script>


<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    import Echo from '/assets/js/Echo.js';

        window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'websocketsPyk',
        wsHost: 'websockets.payakumbuhkota.go.id',
        wssPort: 6001,
        });

    document.addEventListener('DOMContentLoaded', () => {
        const pesanInput = document.getElementById('pesan');
        const id_chat = document.getElementById('id_chat').value;

        if (pesanInput) {
            pesanInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        if (id_chat) {
            console.log('id_chat:', id_chat); // Cek id_chat di console

            window.Echo.private(`chat.${id_chat}`).listen('PesanBaru', (event) => {
                console.log('Event received:', event); // Cek isi event di console

                const newChat = $(`
                    <div class="chat chat-left" style="opacity: 0; transform: translateY(20px); transition: all 0.3s ease-out;">
                        <div class="chat-bubble">
                            <div class="chat-content">
                                <p>${event.pesan}</p>
                                <span class="chat-time">${event.time}</span>
                            </div>
                        </div>
                    </div>
                `);
                $('#chats').append(newChat);
                setTimeout(() => {
                    newChat.css({ opacity: 1, transform: 'translateY(0)' });
                }, 50);

                smoothScrollToBottom();
            });
        }


        scrollToBottom();
    });

    function sendMessage() {
        const id_chat = document.getElementById('id_chat').value;
        const pesan = document.getElementById('pesan').value;

        if (pesan.trim() === '') return;

        $.ajax({
            url: "{{ url('/chat/pesan/tambah') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_chat: id_chat,
                pesan: pesan
            },
            success: function(response) {
                const newChat = $(
                    `<div class="chat chat-right" style="opacity: 0; transform: translateY(20px); transition: all 0.3s ease-out;">
                        <div class="chat-bubble">
                            <div class="chat-content">
                                <p>${response.pesan}</p>
                                <span class="chat-time">${response.time}</span>
                            </div>
                        </div>
                    </div>`
                );
                $('#chats').append(newChat);
                setTimeout(() => {
                    newChat.css({ opacity: 1, transform: 'translateY(0)' });
                }, 50);

                document.getElementById('pesan').value = '';
                setTimeout(() => {
                    smoothScrollToBottom();
                }, 100);
            },
            error: function() {
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            }
        });
    }

    function scrollToBottom() {
        const chatContents = document.getElementById('chat-contents');
        if (chatContents) {
            chatContents.scrollTop = chatContents.scrollHeight;

            document.querySelectorAll('.chat').forEach(chat => {
                chat.style.opacity = 0;
                chat.style.transform = 'translateY(20px)';
                chat.style.transition = 'all 0.3s ease-out';

                setTimeout(() => {
                    chat.style.opacity = 1;
                    chat.style.transform = 'translateY(0)';
                }, 100);

                smoothScrollToBottom();
            });
        }
    }

    function smoothScrollToBottom() {
        const chatContents = document.getElementById('chat-contents');
        if (chatContents) {
            chatContents.scrollTo({
                top: chatContents.scrollHeight,
                behavior: 'smooth'
            });
        }
    }
</script>




@endsection
