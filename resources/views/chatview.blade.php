@extends('template')

@section('chat')
<style>
    body {
  overflow: hidden;
}

chat-contents {
    max-height: 400px; /* Sesuai kebutuhan */
    overflow-y: auto;
}

</style>
<body >
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="index-2.html" class="logo">
                    <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Preclinic</span>
                </a>
            </div>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown d-none d-sm-block">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right">3</span></a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span>Notifications</span>
                        </div>
                        <div class="drop-scroll">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">
												<img alt="John Doe" src="assets/img/user.jpg" class="img-fluid rounded-circle">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">V</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">L</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">G</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">V</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
												<p class="noti-time"><span class="notification-time">2 days ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown d-none d-sm-block">
                    <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
                </li>
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
							<span class="status online"></span></span>
                        <span>Admin</span>
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="profile.html">My Profile</a>
						<a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
						<a class="dropdown-item" href="settings.html">Settings</a>
						<a class="dropdown-item" href="login.html">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="settings.html">Settings</a>
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="index-2.html"><i class="fa fa-home back-icon"></i> <span>Back to Home</span></a>
                        </li>
                        
                        
                        <li class="menu-title">Direct Chats <a href="#" class="add-user-icon" data-toggle="modal" data-target="#add_chat_user"><i class="fa fa-plus"></i></a></li>
                        <li>
                            <a href="chat.html"><span class="chat-avatar-sm user-img"><img src="assets/img/user.jpg" alt="" class="rounded-circle"><span class="status online"></span></span> John Doe <span class="badge badge-pill bg-danger float-right">1</span></a>
                        </li>
                        <li>
                            <a href="chat.html"><span class="chat-avatar-sm user-img"><img src="assets/img/user.jpg" alt="" class="rounded-circle"><span class="status offline"></span></span> Richard Miles <span class="badge badge-pill bg-danger float-right">18</span></a>
                        </li>
                        <li>
                            <a href="chat.html"><span class="chat-avatar-sm user-img"><img src="assets/img/user.jpg" alt="" class="rounded-circle"><span class="status away"></span></span> John Smith</a>
                        </li>
                        <li class="active">
                            <a href="chat.html"><span class="chat-avatar-sm user-img"><img src="assets/img/user.jpg" alt="" class="rounded-circle"><span class="status online"></span></span> Jennifer <span class="badge badge-pill bg-danger float-right">108</span></a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="chat-main-row">
                <div class="chat-main-wrapper">
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
                                    <div class="search-box">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <span class="input-group-append">
													<button class="btn" type="button"><i class="fa fa-search"></i></button>
												</span>
                                        </div>
                                    </div>
                                    <ul class="nav custom-menu">
                                        <li class="nav-item">
                                            <a href="#chat_sidebar" class="nav-link task-chat profile-rightbar float-right" id="task_chat"><i class="fa fa-user"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="voice-call.html"><i class="fa fa-phone"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="video-call.html"><i class="fa fa-video-camera"></i></a>
                                        </li>
                                        <li class="nav-item dropdown dropdown-action">
                                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)">Delete Conversations</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chat-contents"  >
                                <div class="chat-content-wrap">
                                    <div class="chat-wrap-inner" id="chat-contents">
                                        <div class="chat-box" >
                                            <div class="chats" id="chats">
                                                
                                                <div class="chat-line">
                                                    <span class="chat-date">October 8th, 2015</span>
                                                </div>
                                                @foreach($pesan as $p)
                                                @if($p->id_user != Auth::user()->id_user)
                                                <div class="chat chat-left">
                                                    <div class="chat-body">
                                                        <div class="chat-bubble">
                                                            <div class="chat-content">
                                                                <p>{{ $p->pesan }}</p>
                                                                <span class="chat-time">{{ $p->created_at->format('h:i A')  }}</span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                @else
                                                <div class="chat chat-right">
                                                    <div class="chat-body">
                                                        <div class="chat-bubble">
                                                            <div class="chat-content">
                                                            <p>{{ $p->pesan }}</p>
                                                                <span class="chat-time">{{ $p->created_at->format('h:i A')  }}</span>
                                                            </div>
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
                                <div class="message-bar">
                                    <div class="message-inner">
                                        <a class="link attach-icon" href="#" data-toggle="modal" data-target="#drag_files"><img src="assets/img/attachment.png" alt=""></a>
                                        <div class="message-area">
                                            <div class="input-group">
                                            <input type="hidden" name="id_chat" id="id_chat" value="{{ $chat->id_chat }}">

                                                <textarea class="form-control" name="pesan" id="pesan" placeholder="Type message..."></textarea>
                                                <span class="input-group-append">
													<button class="btn btn-primary" type="button" onclick="sendMessage()"><i class="fa fa-send"></i></button>
												</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div id="drag_files" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Drag and drop files upload</h3>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="js-upload-form">
                                <div class="upload-drop-zone" id="drop-zone">
                                    <i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
                                </div>
                                <h4>Uploading</h4>
                                <ul class="upload-list">
                                    <li class="file-list">
                                        <div class="upload-wrap">
                                            <div class="file-name">
                                                <i class="fa fa-photo"></i> photo.png
                                            </div>
                                            <div class="file-size">1.07 gb</div>
                                            <button type="button" class="file-close">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </div>
                                        <div class="progress progress-xs progress-striped">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                        </div>
                                        <div class="upload-process">37% done</div>
                                    </li>
                                    <li class="file-list">
                                        <div class="upload-wrap">
                                            <div class="file-name">
                                                <i class="fa fa-file"></i> task.doc
                                            </div>
                                            <div class="file-size">5.8 kb</div>
                                            <button type="button" class="file-close">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </div>
                                        <div class="progress progress-xs progress-striped">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                        </div>
                                        <div class="upload-process">37% done</div>
                                    </li>
                                    <li class="file-list">
                                        <div class="upload-wrap">
                                            <div class="file-name">
                                                <i class="fa fa-photo"></i> dashboard.png
                                            </div>
                                            <div class="file-size">2.1 mb</div>
                                            <button type="button" class="file-close">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </div>
                                        <div class="progress progress-xs progress-striped">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                        </div>
                                        <div class="upload-process">Completed</div>
                                    </li>
                                </ul>
                            </form>
                            <div class="m-t-30 text-center">
                                <button class="btn btn-primary submit-btn">Add to upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
          
			
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>


    <script>

        document.getElementById('pesan').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
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
                    const newMessage = $(`
                        <div class="chat chat-right new-message">
                            <div class="chat-body">
                                <div class="chat-bubble">
                                    <div class="chat-content">
                                        <p>${response.pesan}</p>
                                        <span class="chat-time">${response.time}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    $('#chats').append(newMessage);

                    // Mainkan suara saat pesan terkirim
                    const sound = new Audio("{{ asset('sounds/pop.mp3') }}");
                    sound.play();

                    // Animasi bounce
                    newMessage.hide().slideDown(300).animate({ marginTop: '0' }, {
                        duration: 500,
                        easing: 'easeOutBounce'
                    });

                    document.getElementById('pesan').value = '';

                    // PAKSA auto-scroll ke bawah dengan memastikan elemen benar-benar ada
                    setTimeout(() => {
                        const chatContents = document.getElementById('chat-contents');
                        if (chatContents) {
                            chatContents.scrollTop = chatContents.scrollHeight;
                        }
                    }, 100); // Delay sedikit biar elemen baru ter-render dulu
                },
                error: function() {
                    alert('Failed to send message. Please try again.');
                }
            });
        }




        document.addEventListener('DOMContentLoaded', scrollToBottom);


    </script>

</body>

@endsection