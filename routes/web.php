<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Intervensi\PelatihanController;
use App\Http\Controllers\Intervensi\PameranController;
use App\Http\Controllers\Intervensi\SertifikatHalalController;
use App\Http\Controllers\Intervensi\SertifikatMerekController;
use App\Http\Controllers\Intervensi\PemasaranController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\IntervensiController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Route::group(['middleware' => 'auth'], function () {

    //LOGIN
    Route::get('/logout', [AuthController::class, 'logout']);

    //DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ukm', [UkmController::class, 'index'])->name('ukm');
    Route::get('/ukm/create', [UkmController::class, 'create'])->name('ukm');
    Route::post('/ukm/store', [UkmController::class, 'store'])->name('ukm');
    Route::post('/ukm/delete', [UkmController::class, 'destroy'])->name('ukm');
    Route::post('/ukm/edit', [UkmController::class, 'edit'])->name('ukm');
    Route::post('/ukm/update', [UkmController::class, 'update'])->name('ukm');
    Route::get('/ukm/importExcel', [UkmController::class, 'importExcel'])->name('ukm');

    //PELATIHAN
    Route::get('/intervensi/pelatihan', [PelatihanController::class, 'index'])->name('intervensi');
    Route::get('/intervensi/pelatihan/create', [PelatihanController::class, 'create'])->name('intervensi');
    Route::get('/intervensi/pelatihan/edit/{id}', [PelatihanController::class, 'edit'])->name('intervensi');
    Route::post('/intervensi/pelatihan/store', [PelatihanController::class, 'store'])->name('intervensi');
    Route::post('/intervensi/pelatihan/update', [PelatihanController::class, 'update'])->name('intervensi');
    Route::get('/intervensi/pelatihan/view/{id}', [PelatihanController::class, 'view'])->name('intervensi');

    //PAMERAN
    Route::get('/intervensi/pameran', [PameranController::class, 'index'])->name('intervensi');
    Route::get('/intervensi/pameran/create', [PameranController::class, 'create'])->name('intervensi');
    Route::get('/intervensi/pameran/edit/{id}', [PameranController::class, 'edit'])->name('intervensi');
    Route::post('/intervensi/pameran/store', [PameranController::class, 'store'])->name('intervensi');
    Route::post('/intervensi/pameran/update', [PameranController::class, 'update'])->name('intervensi');
    Route::get('/intervensi/pameran/view/{id}', [PameranController::class, 'view'])->name('intervensi');

    //SERTIFIKAT HALAL
    Route::get('/intervensi/SertifikatHalal', [SertifikatHalalController::class, 'index'])->name('intervensi');
    Route::get('/intervensi/SertifikatHalal/create', [SertifikatHalalController::class, 'create'])->name('intervensi');
    Route::get('/intervensi/SertifikatHalal/edit/{id}', [SertifikatHalalController::class, 'edit'])->name('intervensi');
    Route::post('/intervensi/SertifikatHalal/store', [SertifikatHalalController::class, 'store'])->name('intervensi');
    Route::post('/intervensi/SertifikatHalal/update', [SertifikatHalalController::class, 'update'])->name('intervensi');
    Route::get('/intervensi/SertifikatHalal/view/{id}', [SertifikatHalalController::class, 'view'])->name('intervensi');

    //SERTIFIKAT MEREK
    Route::get('/intervensi/SertifikatMerek', [SertifikatMerekController::class, 'index'])->name('intervensi');
    Route::get('/intervensi/SertifikatMerek/create', [SertifikatMerekController::class, 'create'])->name('intervensi');
    Route::get('/intervensi/SertifikatMerek/edit/{id}', [SertifikatMerekController::class, 'edit'])->name('intervensi');
    Route::post('/intervensi/SertifikatMerek/store', [SertifikatMerekController::class, 'store'])->name('intervensi');
    Route::post('/intervensi/SertifikatMerek/update', [SertifikatMerekController::class, 'update'])->name('intervensi');
    Route::get('/intervensi/SertifikatMerek/view/{id}', [SertifikatMerekController::class, 'view'])->name('intervensi');

    //Pemasaran
    Route::get('/intervensi/pemasaran', [PemasaranController::class, 'index'])->name('intervensi');
    Route::get('/intervensi/pemasaran/create', [PemasaranController::class, 'create'])->name('intervensi');
    Route::get('/intervensi/pemasaran/edit/{id}', [PemasaranController::class, 'edit'])->name('intervensi');
    Route::post('/intervensi/pemasaran/store', [PemasaranController::class, 'store'])->name('intervensi');
    Route::post('/intervensi/pemasaran/update', [PemasaranController::class, 'update'])->name('intervensi');
    Route::get('/intervensi/pemasaran/view/{id}', [PemasaranController::class, 'view'])->name('intervensi');

    //REFERENSI
    Route::get('/referensi', [ReferensiController::class, 'index']);
    Route::get('/referensi/create', [ReferensiController::class, 'create']);
    Route::post('/referensi/store', [ReferensiController::class, 'store']);
    Route::post('/referensi/delete', [ReferensiController::class, 'destroy']);
    Route::get('/referensi/edit/{id}', [ReferensiController::class, 'edit']);
    Route::get('/referensi/view/{id}', [ReferensiController::class, 'view']);
    Route::post('/referensi/update', [ReferensiController::class, 'update']);

    //USER
    Route::get('/data_user', [UserController::class, 'index']);
    Route::post('/data_user/delete', [UserController::class, 'destroy']);


// });


//API
Route::get('api/ukm', [UkmController::class, 'getAll']);
