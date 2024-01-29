<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'Controller@index')->name('index');

Route::post('/login', 'LoginController@login')->name('postlogin');
Route::get('/login', 'Controller@login22')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

// Route::get('pass', 'LoginController@bcrypt_gen');

Route::post('/kasir/get_produk', 'KasirController@get_produk')->name('kasir.get.produk');
Route::post('/kasir/cari_produk', 'KasirController@cari_produk')->name('kasir.cari.produk');
Route::post('/kasir/cari_kategori', 'KasirController@cari_kategori')->name('kasir.cari.kategori');
Route::post('/kasir/tambah_barang_barcode', 'KasirController@tambah_barang_barcode')->name('kasir.tambah.barang.barcode');
Route::post('/kasir/tambah_barang', 'KasirController@tambah_barang')->name('kasir.tambah.barang');
Route::get('/kasir/get_list', 'KasirController@get_list')->name('kasir.get.list');
Route::get('/kasir/del_list', 'KasirController@del_list')->name('kasir.del.list');
Route::post('/kasir/ubah_qty', 'KasirController@ubah_qty')->name('kasir.ubah.qty');
Route::post('/kasir/transaksi', 'TransaksiController@transaksi')->name('kasir.transaksi');
Route::post('/kasir/cetak-faktur', 'TransaksiController@cetak_faktur')->name('kasir.buat.faktur');
Route::post('/kasir/cetak-struk', 'TransaksiController@cetak_struk')->name('kasir.buat.struk');

Route::post('/kasir/cetak-ulang-struk', 'TransaksiController@cetak_ulang_struk')->name('kasir.ulang.struk');
Route::post('/kasir/cetak-ulang-faktur', 'TransaksiController@cetak_ulang_faktur')->name('kasir.ulang.faktur');
Route::post('/kasir/buat-faktur', 'TransaksiController@buat_faktur')->name('buat.faktur');
Route::get('/kasir/get_faktur_lama', 'KasirController@get_faktur_lama');
Route::get('/kasir/print_faktur_2', 'TransaksiController@cetak_ulang_faktur_2');

Route::get('/kasir/cetak-struk/{id}', 'TransaksiController@cetak_faktur');


Route::post('/kasir/kasbon_true', 'KasirController@kasbon_true')->name('kasir.kasbon_true');
// Admin
Route::group(['middleware' => ['auth', 'ceklevel:1']], function () {

    Route::get('/admin', 'AdminController@index')->name('admin.index');
});

// User
Route::group(['middleware' => ['auth', 'ceklevel:2']], function () {
});
