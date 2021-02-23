<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Intervensi\PelatihanController;
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
    Route::get('/ukm', [UkmController::class, 'index']);
    Route::get('/ukm/create', [UkmController::class, 'create']);
    Route::post('/ukm/store', [UkmController::class, 'store']);
    Route::post('/ukm/delete', [UkmController::class, 'destroy']);
    Route::post('/ukm/edit', [UkmController::class, 'edit']);
    Route::post('/ukm/update', [UkmController::class, 'update']);

    Route::get('/intervensi', [IntervensiController::class, 'index']);
    Route::get('/intervensi/create', [IntervensiController::class, 'create']);
    Route::post('/intervensi/store', [IntervensiController::class, 'store']);
    Route::post('/intervensi/delete', [IntervensiController::class, 'destroy']);
    Route::post('/intervensi/edit', [IntervensiController::class, 'edit']);
    Route::post('/intervensi/view', [IntervensiController::class, 'view']);
    Route::post('/intervensi/update', [IntervensiController::class, 'update']);

    //PELATIHAN
    Route::get('/intervensi/pelatihan', [PelatihanController::class, 'index']);
    Route::get('/intervensi/pelatihan/create', [PelatihanController::class, 'create']);
    Route::get('/intervensi/pelatihan/edit/{id}', [PelatihanController::class, 'edit']);
    Route::post('/intervensi/pelatihan/store', [PelatihanController::class, 'store']);
    Route::post('/intervensi/pelatihan/update', [PelatihanController::class, 'update']);
    Route::get('/intervensi/pelatihan/view/{id}', [PelatihanController::class, 'view']);

    //PAMERAN
    Route::get('/intervensi/pameran', [PameranController::class, 'index']);
    Route::get('/intervensi/pameran/create', [PameranController::class, 'create']);
    Route::get('/intervensi/pameran/edit/{id}', [PameranController::class, 'edit']);
    Route::post('/intervensi/pameran/store', [PameranController::class, 'store']);
    Route::post('/intervensi/pameran/update', [PameranController::class, 'update']);
    Route::get('/intervensi/pameran/view/{id}', [PameranController::class, 'view']);

    //SERTIFIKAT HALAL
    Route::get('/intervensi/SertifikatHalal', [SertifikatHalalController::class, 'index']);
    Route::get('/intervensi/SertifikatHalal/create', [SertifikatHalalController::class, 'create']);
    Route::get('/intervensi/SertifikatHalal/edit/{id}', [SertifikatHalalController::class, 'edit']);
    Route::post('/intervensi/SertifikatHalal/store', [SertifikatHalalController::class, 'store']);
    Route::post('/intervensi/SertifikatHalal/update', [SertifikatHalalController::class, 'update']);
    Route::get('/intervensi/SertifikatHalal/view/{id}', [SertifikatHalalController::class, 'view']);

    //SERTIFIKAT MEREK
    Route::get('/intervensi/SertifikatMerek', [SertifikatMerekController::class, 'index']);
    Route::get('/intervensi/SertifikatMerek/create', [SertifikatMerekController::class, 'create']);
    Route::get('/intervensi/SertifikatMerek/edit/{id}', [SertifikatMerekController::class, 'edit']);
    Route::post('/intervensi/SertifikatMerek/store', [SertifikatMerekController::class, 'store']);
    Route::post('/intervensi/SertifikatMerek/update', [SertifikatMerekController::class, 'update']);
    Route::get('/intervensi/SertifikatMerek/view/{id}', [SertifikatMerekController::class, 'view']);


    //REFERENSI
    Route::get('/referensi', [ReferensiController::class, 'index']);
    Route::get('/referensi/create', [ReferensiController::class, 'create']);
    Route::post('/referensi/store', [ReferensiController::class, 'store']);
    Route::post('/referensi/delete', [ReferensiController::class, 'destroy']);
    Route::get('/referensi/edit/{id}', [ReferensiController::class, 'edit']);
    Route::get('/referensi/view/{id}', [ReferensiController::class, 'view']);
    Route::post('/referensi/update', [ReferensiController::class, 'update']);

    Route::get('/data_user', [UserController::class, 'index']);
    Route::post('/data_user/delete', [UserController::class, 'destroy']);

    Route::get('/logout', [AuthController::class, 'logout']);
// });


//API
Route::get('api/ukm', [UkmController::class, 'getAll']);
