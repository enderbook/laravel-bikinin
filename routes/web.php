<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobclientCt;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


*/

Route::get('/register', [LoginController::class, 'register']);
Route::post('/register/registeraction', [LoginController::class, 'registerAction']);
Route::get('/rekrut', [LoginController::class, 'rekrut']);
Route::get('/rekadmin', [LoginController::class, 'rekadmin']);

Route::post('/rekrut/rekrutaction', [LoginController::class, 'rekrutAction']);

Route::get('/', [LoginController::class, 'bikinin']);

Route::get('/login', [LoginController::class, 'login']);
Route::post('/loginaction', [LoginController::class, 'loginAction']);
Route::get('/logout', [LoginController::class, 'logOut']);

Route::get('/admin', [HomeController::class, 'homeAdmin'])->middleware(['auth', 'check.status']);
Route::get('/freelancer', [HomeController::class, 'homeFree'])->middleware(['auth', 'check.status']);
Route::get('/client', [HomeController::class, 'homeClient'])->middleware(['auth', 'check.status']);
Route::get('/blokir', [HomeController::class, 'blokirPage']);

Route::get('/admin/user', [AdminController::class, 'user']);
Route::get('/admin/ketua/{id}', [AdminController::class, 'adminKetua']);
Route::get('/admin/anggota/{id}', [AdminController::class, 'adminAnggota']);
Route::get('/admin/pecat/{id}', [AdminController::class, 'adminPecat']);
Route::get('/admin/user/hapus/{id}', [AdminController::class, 'hapusUser']);

Route::get('/admin/user/edit/{id}', [AdminController::class, 'editUser']);
Route::post('/admin/user/blok', [AdminController::class, 'blokUser']);
Route::post('/admin/user/editaction', [AdminController::class, 'editactionUser']);
Route::get('/admin/pay', [PayController::class, 'pay']);
Route::get('/admin/pay/batal/{id}', [PayController::class, 'payBatal']);
Route::get('/admin/pay/hapus/{id}', [PayController::class, 'payHapus']);
Route::get('/admin/bidang', [AdminController::class, 'bidangTampil']);
Route::get('/admin/bidang/input', [AdminController::class, 'bidangInput']);
Route::post('/admin/bidang/submit', [AdminController::class, 'bidangSubmit']);
Route::get('/admin/bidang/hapus', [AdminController::class, 'bidangHapus']);
Route::get('/admin/hispay/hapus/{id}', [PayController::class, 'hispayHapus']);


Route::get('/admin/pay/done/{id}', [PayController::class, 'payDone']);
Route::post('/admin/pay/doneaction', [PayController::class, 'paydoneAction']);
Route::get('/admin/news', [AdminController::class, 'newsTampil']);
Route::get('/admin/news/input', [AdminController::class, 'newsInput']);
Route::post('/admin/news/masuk', [AdminController::class, 'newsMasuk']);
Route::get('/admin/news/hapus/{id}', [AdminController::class, 'newsHapus']);
Route::get('/admin/news/edit/{id}', [AdminController::class, 'newsEdit']);
Route::post('/admin/news/update', [AdminController::class, 'newsUpdate']);


Route::get('/client/job', [JobclientCt::class, 'jobClient']);
Route::get('/client/penawaran', [PenawaranController::class, 'nawar']);
Route::get('/client/job/add', [JobclientCt::class, 'addJob']);
Route::post('/client/job/input', [JobclientCt::class, 'inputJob']);
Route::get('/client/job/edit/{id}', [JobclientCt::class, 'editJob']);
Route::post('/client/job/ubah', [JobclientCt::class, 'editjobAction']);
Route::get('/client/job/hapus/{id}', [JobclientCt::class, 'hapusJob']);
Route::get('/penawaran/detail/{id}', [PenawaranController::class, 'detailNawar']);
Route::post('/client/penawaran/status', [PenawaranController::class, 'statusNawar']);

Route::get('/profile/{id}', [ProfileController::class, 'profileTampil']);
Route::get('/profile/create', [ProfileController::class, 'bikinProfile']);
Route::post('/profile/input', [ProfileController::class, 'inputProfile']);
Route::get('/profile/edit/{id}', [ProfileController::class, 'editProfile']);
Route::post('/profile/ubah', [ProfileController::class, 'ubahProfile']);


Route::get('/kontrak', [kontrakController::class, 'kontrakClient']);
Route::get('/kontrak/detail/{id}', [kontrakController::class, 'detailKontrak']);
Route::post('/kontrak/edit/client', [kontrakController::class, 'clientKontrak']);
Route::post('/kontrak/edit/free', [kontrakController::class, 'freeKontrak']);
Route::get('/kontrak/download/{id}', [kontrakController::class, 'downloadFile'])->name('download.file');
Route::post('/kontrak/akhiri', [kontrakController::class, 'kontrakAkhiri']);

Route::post('/kontrak/inputFile', [kontrakController::class, 'kontrakFile']);
Route::get('/kontrak/hapusFile/{id}', [kontrakController::class, 'hapusFile']);
Route::post('/kontrak/deadline', [kontrakController::class, 'deadLine']);

Route::get('/chat', [ChatController::class, 'listChat']);
Route::get('/chat/pesan/{id}', [ChatController::class, 'pesanChat']);
Route::post('/chat/pesan/tambah', [ChatController::class, 'inputPesan']);
Route::post('/chat/tambah', [ChatController::class, 'tambahChat']);

Route::get('/history/{id}', [HistoryController::class, 'historyTampil']);
Route::get('/history/detail/{id}', [HistoryController::class, 'historyDetail']);
Route::get('/history/penawaran/hapus/{id}', [HistoryController::class, 'hapusNawar']);
Route::get('/history/kontrak/hapus/{id}', [HistoryController::class, 'hapusKontrak']);
Route::get('/history/job/hapus/{id}', [HistoryController::class, 'hapusJob']);

Route::get('/history/admin/{id}', [PayController::class, 'historiPay']);


Route::get('/freelancer/penawaran', [PenawaranController::class, 'nawar']);
Route::get('/freelancer/penawaran/input/{id}', [PenawaranController::class, 'inputTawaran']);
Route::post('/freelancer/penawaran/masuk', [PenawaranController::class, 'inputawaranAction']);
Route::get('/freelancer/penawaran/batal/{id}', [PenawaranController::class, 'batalNawar']);

Route::get('/notif', [NotificationController::class, 'tampilNotif']);
Route::get('/notif/read/{id}', [NotificationController::class, 'readNotif']);
Route::get('/notif/hapus/{id}', [NotificationController::class, 'hapusNotif']);




