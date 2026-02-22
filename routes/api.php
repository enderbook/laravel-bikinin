<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);


Route::get('/free', [ApiController::class, 'tampilFree']);
Route::get('/bidang', [ApiController::class, 'tampilBidang']);

Route::get('/job', [ApiController::class, 'tampilJob']);
Route::get('client/job', [ApiController::class, 'tampilJobclient']);
Route::get('client/job/hapus', [ApiController::class, 'hapusJob']);
Route::post('client/job/edit', [ApiController::class, 'editJob']);
Route::get('client/job/cek', [ApiController::class, 'cekJobKontrak']);
Route::get('client/home/data', [ApiController::class, 'dataHomeclient']);

Route::get('free/home/data', [ApiController::class, 'dataHomefree']);

Route::get('/news', [ApiController::class, 'newsTampil']);

Route::post('client/inputjob', [ApiController::class, 'inputJob']);

Route::get('tampil/kontrak', [ApiController::class, 'tampilKontrak']);
Route::get('job/kontrak', [ApiController::class, 'jobKontrak']);
Route::get('job/detail', [ApiController::class, 'detJob']);

Route::get('kontrak/detail', [ApiController::class, 'detKontrak']);

Route::post('client/kontrak/fotobukti', [ApiController::class, 'potoClient']);
Route::get('kontrak/file', [ApiController::class, 'fileKontrak']);
Route::post('kontrak/inputfile', [ApiController::class, 'inputFileKontrak']);
Route::get('kontrak/hapusfile', [ApiController::class, 'hapusFileKontrak']);
Route::post('kontrak/deadline', [ApiController::class, 'deadLine']);
Route::get('kontrak/delivarable/download', [ApiController::class, 'downloadDeliv']);
Route::post('kontrak/delivarable/input', [ApiController::class, 'inputDeliv']);
Route::get('kontrak/file/download', [ApiController::class, 'downloadFile']);
Route::post('kontrak/ulasan', [ApiController::class, 'ulasan']);


Route::post('penawaran/diterima', [ApiController::class, 'inputKonpay']);
Route::post('konpay/hapus', [ApiController::class, 'akhiriKonpay']);

Route::get('job/penawaran', [ApiController::class, 'jobPenawaran']);
Route::get('tampil/penawaran', [ApiController::class, 'tampilPenawaran']);
Route::post('penawaran/inputpenawaran', [ApiController::class, 'inputPenawaran']);
Route::post('penawaran/ditolak', [ApiController::class, 'tolakPenawaran']);
Route::get('penawaran/batal', [ApiController::class, 'batalNawar']);


Route::get('profile/tampil', [ApiController::class, 'tampilProfile']);
Route::post('profile/input', [ApiController::class, 'inputProfile']);
Route::post('profile/edit', [ApiController::class, 'editProfile']);
Route::get('profile/ulasan', [ApiController::class, 'ulasanTampil']);

Route::get('history/job', [ApiController::class, 'hisjobTampil']);
Route::get('history/penawaran', [ApiController::class, 'hispenTampil']);
Route::get('history/kontrak', [ApiController::class, 'hiskonTampil']);
Route::get('history/job/hapus', [ApiController::class, 'hapusJobhis']);
Route::get('history/penawaran/hapus', [ApiController::class, 'hapusNawarhis']);
Route::get('history/kontrak/hapus', [ApiController::class, 'hapusKontrakhis']);


Route::get('free/search/job', [ApiController::class, 'searchJob']);
Route::get('client/search/job', [ApiController::class, 'searchJobclient']);
Route::get('search/penawaran', [ApiController::class, 'searchPenawaran']);
Route::get('search/kontrak', [ApiController::class, 'searchKontrak']);
Route::get('kontrak/refres', [ApiController::class, 'refresKontrak']);


Route::get('/notif', [ApiController::class, 'tampilNotif']);
Route::get('/notif/read', [ApiController::class, 'readNotif']);
Route::get('/notif/hapus', [ApiController::class, 'hapusNotif']);





