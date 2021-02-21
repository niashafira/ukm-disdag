<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('/data_ukm', [UkmController::class, 'index']);
    Route::get('/data_ukm/create', [UkmController::class, 'create']);
    Route::post('/data_ukm/store', [UkmController::class, 'store']);
    Route::post('/data_ukm/delete', [UkmController::class, 'destroy']);
    Route::post('/data_ukm/edit', [UkmController::class, 'edit']);
    Route::post('/data_ukm/update', [UkmController::class, 'update']);

    Route::get('/intervensi', [IntervensiController::class, 'index']);
    Route::get('/intervensi/create', [IntervensiController::class, 'create']);
    Route::post('/intervensi/store', [IntervensiController::class, 'store']);
    Route::post('/intervensi/delete', [IntervensiController::class, 'destroy']);
    Route::post('/intervensi/edit', [IntervensiController::class, 'edit']);
    Route::post('/intervensi/view', [IntervensiController::class, 'view']);
    Route::post('/intervensi/update', [IntervensiController::class, 'update']);

    //PELATIHAN
    Route::get('/intervensi/pelatihan', [IntervensiController::class, 'indexPelatihan']);
    Route::get('/intervensi/pelatihan/create', [IntervensiController::class, 'createPelatihan']);
    Route::get('/intervensi/pelatihan/edit/{id}', [IntervensiController::class, 'editPelatihan']);
    Route::post('/intervensi/pelatihan/storePelatihan', [IntervensiController::class, 'storePelatihan']);



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
