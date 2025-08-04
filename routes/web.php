<?php

use Illuminate\Support\Facades\Route;

// Route awal
Route::get('/', function () {
    return view('welcome');
});

// Login & Logout
Route::get('/login', 'Auth\PegawaiLoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\PegawaiLoginController@login');
Route::post('/logout', 'Auth\PegawaiLoginController@logout')->name('logout');

// Middleware auth:pegawai
Route::group(['middleware' => ['auth:pegawai']], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('izin_keluar', 'IzinKeluarController');
    Route::resource('tugas_tambahan', 'TugasTambahanController');

    Route::prefix('penilaian')->group(function () {
        Route::get('{jenis}', 'PenilaianController@index')->name('penilaian.index');
        Route::get('{jenis}/create', 'PenilaianController@create')->name('penilaian.create');
        Route::post('{jenis}', 'PenilaianController@store')->name('penilaian.store');
        Route::get('{jenis}/{id}/edit', 'PenilaianController@edit')->name('penilaian.edit');
        Route::put('{jenis}/{id}', 'PenilaianController@update')->name('penilaian.update');
        Route::delete('{jenis}/{id}', 'PenilaianController@destroy')->name('penilaian.destroy');
    });

    Route::get('penampilan', 'PenampilanHarianController@index')->name('penampilan.index');
    Route::get('penampilan/create', 'PenampilanHarianController@create')->name('penampilan.create');
    Route::post('penampilan', 'PenampilanHarianController@store')->name('penampilan.store');

    Route::resource('layanan', 'LayananController');
    Route::resource('keluhan', 'KeluhanController');
});
