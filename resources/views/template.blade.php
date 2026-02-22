<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('logoweb.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bikinin - Platform Freelance</title>
    <link href="{{url('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.css">



    <style>
        .head {
            background-color: #ff8000;
        }
        .notifications .notification-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .notifications .notification-item:hover {
            background-color: #f5f5f5;
        }

        .notifications .notification-icon {
            font-size: 18px;
            margin-right: 10px;
            color: #007bff;
        }

        .notifications .notification-content {
            flex-grow: 1;
        }

        .notifications .notification-time {
            font-size: 12px;
            color: #999;
        }

        .dropdown-menu.notifications {
            min-width: 400px; /* default lebar */
            max-width: 400px; /* maksimal lebar */
            width: 100%;       /* biar fleksibel */
        }

        .notification-close {
            margin-left: auto;
            font-size: 16px;
            color: #dc3545;
        }
        .notification-close:hover {
            color: #bd2130;
        }
        .sidebar {
            background-color: #f6f6f6;
            border-right: none;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .sidebar:hover {
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-inner {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            padding: 0 10px;
        }
        
        .sidebar-menu li a {
            color: #333;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: #ff8000;
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar-menu li a i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-menu li.menu-title {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 5px;
            font-weight: 600;
        }
        
        /* Hover effect for menu items */
        .sidebar-menu li a:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background-color: #ff8000;
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }
        
        .sidebar-menu li a:hover:before,
        .sidebar-menu li a.active:before {
            transform: scaleY(1);
        }
        
        /* Logo area styling */
        .header .logo {
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }
        
        .header .logo img {
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .header .logo span {
            font-weight: 600;
            color: white;
            font-size: 18px;
        }
        
        /* Mobile responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar-menu li a {
                padding: 10px 15px;
            }
        }


    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- Header Section -->
        <div class="header head">
            <div class="header-left">
                <a href="index-2.html" class="logo">
                    <img src="{{url('Bin.jpg')}}" width="37" height="37" alt="">
                    <span>Bikinin</span>
                </a>
            </div>
            
            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>

            <!-- Navigation Menu -->
            <ul class="nav user-menu float-right">
                <!-- Notification Dropdown -->
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-pill bg-danger" id="notif-count">0</span>
                    </a>
                    <div class="dropdown-menu notifications" style="width: 300px; max-height: 400px; overflow-y: auto;">
                        <div class="topnav-dropdown-header">
                            <span>Notifikasi</span>
                        </div>
                        <div class="drop-scroll" id="notif-list">
                            <!-- Notifikasi masuk sini dari JS -->
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </li>

                

                <!-- User Profile -->
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                       
                        <span>| {{Auth::user()->username}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
              
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Sidebar Section -->
        <div class="sidebar" id="sidebar" style="z-index: 1;">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">Menu</li>
                    @if(Auth::user()->role == 'admin')
                        <li>
                            <a href="{{url('admin')}}"><i class="fa fa-home"></i> <span>Home</span></a>
                        </li>
                        <li>
                            <a href="{{url('admin/user')}}"><i class="fa fa-users"></i> <span>User</span></a>
                        </li>
                        <li>
                            <a href="{{url('admin/pay')}}"><i class="fa fa-dollar"></i> <span>Payment</span></a>
                        </li>
                        <li>
                            <a href="{{url('history/admin/' . Auth::user()->id_user) }}"><i class="fa fa-history"></i> <span>History</span></a>
                        </li>
                        @if(Auth::user()->status == 0)
                         <li>
                                <a href="{{url('admin/bidang')}}"><i class="fa fa-file"></i> <span>Bidang</span></a>
                            </li>
                            <li>
                                <a href="{{url('rekrut')}}"><i class="fa fa-user-plus"></i> <span>Rekrut</span></a>
                            </li>
                        @endif
                        <li>
                            <a href="{{url('admin/news')}}"><i class="fa fa-newspaper-o"></i> <span>News</span></a>
                        </li>
                    
                        <li>
                            <a href="{{ url('profile/' . Auth::user()->id_user) }}"><i class="fa fa-user-circle"></i> <span>Profile</span></a>
                        </li>
                    @elseif(Auth::user()->role == 'client')
                        <li>
                            <a href="{{url('client')}}"><i class="fa fa-home"></i> <span>Home</span></a>
                        </li>
                        <li>
                            <a href="{{url('client/job')}}"><i class="fa fa-briefcase"></i> <span>Job</span></a>
                        </li>
                        <li>
                            <a href="{{url('client/penawaran')}}"><i class="fa fa-handshake-o"></i> <span>Penawaran</span></a>
                        </li>
                        <li>
                            <a href="{{url('kontrak')}}"><i class="fa fa-file-text-o"></i> <span>Kontrak</span></a>
                        </li>
                        <li>
                            <a href="{{url('history/' . Auth::user()->id_user) }}"><i class="fa fa-history"></i> <span>History</span></a>
                        </li>
                        <li>
                            <a href="{{ url('profile/' . Auth::user()->id_user) }}"><i class="fa fa-user-circle"></i> <span>Profile</span></a>
                        </li>
                    @elseif(Auth::user()->role == 'freelancer')
                        <li>
                            <a href="{{url('freelancer')}}"><i class="fa fa-home"></i> <span>Home</span></a>
                        </li>
                        <li>
                            <a href="{{url('freelancer/penawaran')}}"><i class="fa fa-handshake-o"></i> <span>Penawaran</span></a>
                        </li>
                        <li>
                            <a href="{{url('kontrak')}}"><i class="fa fa-file-text-o"></i> <span>Kontrak</span></a>
                        </li>
                        <li>
                            <a href="{{url('history/' . Auth::user()->id_user) }}"><i class="fa fa-history"></i> <span>History</span></a>
                        </li>
                        <li>
                            <a href="{{ url('profile/' . Auth::user()->id_user) }}"><i class="fa fa-user-circle"></i> <span>Profile</span></a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="content">
                @yield('konten')
            </div>
        </div>
    </div>

   <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{url('assets/js/popper.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{url('assets/js/select2.min.js')}}"></script>
    <script src="{{url('assets/js/moment.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{url('assets/js/app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{url('assets/js/chart.js')}}"></script>

    <script>
        $(document).ready(function () {
            function showToast(notif) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: notif.judul_notif,
                    text: notif.des_notif || '',
                    showCloseButton: true, 
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            }

            function updateDropdown(notifs) {
                let notifList = $('#notif-list');
                notifList.empty();

                notifs.forEach(notif => {
                    const notifHTML = `
                        <div class="notification-item" data-id="${notif.id_notif}">
                            <div class="notification-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="notification-content" style="white-space: normal; overflow-wrap: break-word;">
                                <strong>${notif.judul_notif}</strong><br>
                                <span>${notif.des_notif || ''}</span><br>
                                <span class="notification-time">${notif.waktu || ''}</span>
                            </div>
                            <div class="notification-close" style="margin-left: auto; cursor: pointer; color: #888;">
                                <i class="fa fa-times"></i>
                            </div>
                        </div>`;

                    notifList.append(notifHTML);
                });

                $('#notif-count').text(notifs.length);
            }

            // Tombol close
            $(document).on('click', '.notification-close', function (e) {
                e.stopPropagation();
                const item = $(this).closest('.notification-item');
                const id = item.data('id');

                $.ajax({
                    url: `/notif/hapus/${id}`,
                    method: 'GET',
                    success: function () {
                        item.remove();
                        const newCount = $('#notif-list .notification-item').length;
                        $('#notif-count').text(newCount);
                    },
                    error: function (xhr) {
                        console.error('Gagal hapus notifikasi:', xhr.responseText);
                    }
                });
            });

            // Klik ikon notifikasi → tandai semua sebagai dibaca
            $('#notif-icon').on('click', function () {
                $('.notification-item').each(function () {
                    const id = $(this).data('id');

                    $.ajax({
                        url: `/notif/read/${id}`,
                        method: 'GET',
                        error: function (xhr) {
                            console.error(`Gagal tandai notif ${id} sebagai dibaca`, xhr.responseText);
                        }
                    });
                });
            });

            function fetchNotifs() {
                $.ajax({
                    url: '/notif', // harus kirim semua notif (status 0 dan 1)
                    method: 'GET',
                    success: function (res) {
                        const notifs = res.notifications || [];

                        updateDropdown(notifs);

                        // Tampilkan toast HANYA untuk notif status = 0, lalu ubah ke 1
                        notifs.forEach(n => {
                            if (n.status == 0) {
                                showToast(n);

                                // Langsung tandai dibaca
                                $.ajax({
                                    url: `/notif/read/${n.id_notif}`,
                                    method: 'GET',
                                    error: function (xhr) {
                                        console.error(`Gagal update status notif ${n.id_notif}`, xhr.responseText);
                                    }
                                });
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error("Gagal ambil notifikasi:", xhr.responseText);
                    }
                });
            }

            fetchNotifs();
            setInterval(fetchNotifs, 5000);
        });
    </script>



    @yield('chat')
</body>
</html>