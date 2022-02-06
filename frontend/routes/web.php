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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\AdminController'], function () {
    Route::get('/', 'AdminDashboardController@index')->name('admin.dashboard.index')->middleware('admin');

    // Siswa
    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', 'SiswaController@index')->name('admin.siswa.index')->middleware('admin');
        Route::get('/{id_siswa}', 'SiswaController@show')->name('admin.siswa.show')->middleware('admin');
        Route::post('/add', 'SiswaController@create')->name('admin.siswa.create')->middleware('admin');
        Route::post('/edit', 'SiswaController@edit')->name('admin.siswa.edit')->middleware('admin');
        Route::post('/delete', 'SiswaController@delete')->name('admin.siswa.delete')->middleware('admin');
    });

    // Pendaftaran Siswa
    Route::group(['prefix' => 'pendaftaran'], function () {
        Route::get('/', 'PendaftaranSiswaController@index')->name('admin.pendaftaran.index')->middleware('admin');
        Route::get('/{id_pendaftaransiswa}', 'PendaftaranSiswaController@show')->name('admin.pendaftaran.show')->middleware('admin');
        Route::post('/add', 'PendaftaranSiswaController@create')->name('admin.pendaftaran.create')->middleware('admin');
        Route::post('/edit', 'PendaftaranSiswaController@edit')->name('admin.pendaftaran.edit')->middleware('admin');
        Route::post('/delete', 'PendaftaranSiswaController@delete')->name('admin.pendaftaran.delete')->middleware('admin');
    });

    // Guru
    Route::group(['prefix' => 'guru'], function () {
        Route::get('/', 'GuruController@index')->name('admin.guru.index')->middleware('admin');
        Route::get('/{id_guru}', 'GuruController@show')->name('admin.guru.show')->middleware('admin');
        Route::post('/add', 'GuruController@create')->name('admin.guru.create')->middleware('admin');
        Route::post('/edit', 'GuruController@edit')->name('admin.guru.edit')->middleware('admin');
        Route::post('/delete', 'GuruController@delete')->name('admin.guru.delete')->middleware('admin');
    });

    // Kepegawaian
    Route::group(['prefix' => 'kepegawaian'], function () {
        Route::get('/', 'KepegawaianController@index')->name('admin.kepegawaian.index')->middleware('admin');
        Route::get('/{id_kepegawaian}', 'KepegawaianController@show')->name('admin.kepegawaian.show')->middleware('admin');
        Route::post('/add', 'KepegawaianController@create')->name('admin.kepegawaian.create')->middleware('admin');
        Route::post('/edit', 'KepegawaianController@edit')->name('admin.kepegawaian.edit')->middleware('admin');
        Route::post('/delete', 'KepegawaianController@delete')->name('admin.kepegawaian.delete')->middleware('admin');
    });

    // Jabatan
    Route::group(['prefix' => 'jabatan'], function () {
        Route::get('/', 'JabatanController@index')->name('admin.jabatan.index')->middleware('admin');
        Route::get('/{id_jabatan}', 'JabatanController@show')->name('admin.jabatan.show')->middleware('admin');
        Route::post('/add', 'JabatanController@create')->name('admin.jabatan.create')->middleware('admin');
        Route::post('/edit', 'JabatanController@edit')->name('admin.jabatan.edit')->middleware('admin');
        Route::post('/delete', 'JabatanController@delete')->name('admin.jabatan.delete')->middleware('admin');
    });

    // Wali Siswa
    Route::group(['prefix' => 'wali'], function () {
        Route::get('/', 'WaliSiswaController@index')->name('admin.wali.index')->middleware('admin');
        Route::get('/{id_walisiswa}', 'WaliSiswaController@show')->name('admin.wali.show')->middleware('admin');
        Route::post('/add', 'WaliSiswaController@create')->name('admin.wali.create')->middleware('admin');
        Route::post('/edit', 'WaliSiswaController@edit')->name('admin.wali.edit')->middleware('admin');
        Route::post('/delete', 'WaliSiswaController@delete')->name('admin.wali.delete')->middleware('admin');
    });

    // Jenis Wali
    Route::group(['prefix' => 'jeniswali'], function () {
        Route::get('/', 'JenisWali@index')->name('admin.jeniswali.index')->middleware('admin');
        Route::get('/{id_jeniswali}', 'JenisWali@show')->name('admin.jeniswali.show')->middleware('admin');
        Route::post('/add', 'JenisWali@create')->name('admin.jeniswali.create')->middleware('admin');
        Route::post('/edit', 'JenisWali@edit')->name('admin.jeniswali.edit')->middleware('admin');
        Route::post('/delete', 'JenisWali@delete')->name('admin.jeniswali.delete')->middleware('admin');
    });

    // Laporan Pembayaran
    Route::group(['prefix' => 'laporan-pembayaran'], function () {
        Route::get('/', 'LaporanPembayaranController@index')->name('admin.laporan_pembayaran.index')->middleware('admin');
        Route::get('/{id_laporanpembayaran}', 'LaporanPembayaranController@show')->name('admin.laporan_pembayaran.show')->middleware('admin');
        Route::post('/add', 'LaporanPembayaranController@create')->name('admin.laporan_pembayaran.create')->middleware('admin');
        Route::post('/edit', 'LaporanPembayaranController@edit')->name('admin.laporan_pembayaran.edit')->middleware('admin');
        Route::post('/delete', 'LaporanPembayaranController@delete')->name('admin.laporan_pembayaran.delete')->middleware('admin');
    });

    // Kelas
    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', 'KelasController@index')->name('admin.kelas.index')->middleware('admin');
        Route::get('/{id_kelas}', 'KelasController@show')->name('admin.kelas.show')->middleware('admin');
        Route::post('/add', 'KelasController@create')->name('admin.kelas.create')->middleware('admin');
        Route::post('/edit', 'KelasController@edit')->name('admin.kelas.edit')->middleware('admin');
        Route::post('/delete', 'KelasController@delete')->name('admin.kelas.delete')->middleware('admin');
    });

    // Lembaga
    Route::group(['prefix' => 'lembaga'], function () {
        Route::get('/', 'LembagaController@index')->name('admin.lembaga.index')->middleware('admin');
        Route::get('/{id_lembaga}', 'LembagaController@show')->name('admin.lembaga.show')->middleware('admin');
        Route::post('/add', 'LembagaController@create')->name('admin.lembaga.create')->middleware('admin');
        Route::post('/edit', 'LembagaController@edit')->name('admin.lembaga.edit')->middleware('admin');
        Route::post('/delete', 'LembagaController@delete')->name('admin.lembaga.delete')->middleware('admin');
    });

    // Sarana Prasarana
    Route::group(['prefix' => 'sarpras'], function () {
        Route::get('/', 'SarprasController@index')->name('admin.sarpras.index')->middleware('admin');
        Route::get('/{id_sarpras}', 'SarprasController@show')->name('admin.sarpras.show')->middleware('admin');
        Route::post('/add', 'SarprasController@create')->name('admin.sarpras.create')->middleware('admin');
        Route::post('/edit', 'SarprasController@edit')->name('admin.sarpras.edit')->middleware('admin');
        Route::post('/delete', 'SarprasController@delete')->name('admin.sarpras.delete')->middleware('admin');
    });

    // Surat Keterangan
    Route::group(['prefix' => 'surat-keterangan'], function () {
        Route::get('/', 'SuratKeteranganController@index')->name('admin.surat_keterangan.index')->middleware('admin');
        Route::get('/{id_suratketerangan}', 'SuratKeteranganController@show')->name('admin.surat_keterangan.show')->middleware('admin');
        Route::post('/add', 'SuratKeteranganController@create')->name('admin.surat_keterangan.create')->middleware('admin');
        Route::post('/edit', 'SuratKeteranganController@edit')->name('admin.surat_keterangan.edit')->middleware('admin');
        Route::post('/delete', 'SuratKeteranganController@delete')->name('admin.surat_keterangan.delete')->middleware('admin');
    });

    // Inventory
    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', 'InventoryController@index')->name('admin.inventory.index')->middleware('admin');
        Route::get('/{id_inventory}', 'InventoryController@show')->name('admin.inventory.show')->middleware('admin');
        Route::post('/add', 'InventoryController@create')->name('admin.inventory.create')->middleware('admin');
        Route::post('/edit', 'InventoryController@edit')->name('admin.inventory.edit')->middleware('admin');
        Route::post('/delete', 'InventoryController@delete')->name('admin.inventory.delete')->middleware('admin');
    });

    // Kategori Barang
    Route::group(['prefix' => 'kategori-barang'], function () {
        Route::get('/', 'KategoriBarangController@index')->name('admin.kategori_barang.index')->middleware('admin');
        Route::get('/{id_kategoribarang}', 'KategoriBarangController@show')->name('admin.kategori_barang.show')->middleware('admin');
        Route::post('/add', 'KategoriBarangController@create')->name('admin.kategori_barang.create')->middleware('admin');
        Route::post('/edit', 'KategoriBarangController@edit')->name('admin.kategori_barang.edit')->middleware('admin');
        Route::post('/delete', 'KategoriBarangController@delete')->name('admin.kategori_barang.delete')->middleware('admin');
    });

    // Jenis Inventaris
    Route::group(['prefix' => 'jenis-inventaris'], function () {
        Route::get('/', 'JenisInventarisController@index')->name('admin.jenis_inventaris.index')->middleware('admin');
        Route::get('/{id_jenisinventaris}', 'JenisInventarisController@show')->name('admin.jenis_inventaris.show')->middleware('admin');
        Route::post('/add', 'JenisInventarisController@create')->name('admin.jenis_inventaris.create')->middleware('admin');
        Route::post('/edit', 'JenisInventarisController@edit')->name('admin.jenis_inventaris.edit')->middleware('admin');
        Route::post('/delete', 'JenisInventarisController@delete')->name('admin.jenis_inventaris.delete')->middleware('admin');
    });

    // Dana Masuk
    Route::group(['prefix' => 'dana-masuk'], function () {
        Route::get('/', 'DanaMasukController@index')->name('admin.dana_masuk.index')->middleware('admin');
        Route::get('/{id_danamasuk}', 'DanaMasukController@show')->name('admin.dana_masuk.show')->middleware('admin');
        Route::post('/add', 'DanaMasukController@create')->name('admin.dana_masuk.create')->middleware('admin');
        Route::post('/edit', 'DanaMasukController@edit')->name('admin.dana_masuk.edit')->middleware('admin');
        Route::post('/delete', 'DanaMasukController@delete')->name('admin.dana_masuk.delete')->middleware('admin');
    });

    // Dana Keluar
    Route::group(['prefix' => 'dana-keluar'], function () {
        Route::get('/', 'DanaKeluarController@index')->name('admin.dana_keluar.index')->middleware('admin');
        Route::get('/{id_danakeluar}', 'DanaKeluarController@show')->name('admin.dana_keluar.show')->middleware('admin');
        Route::post('/add', 'DanaKeluarController@create')->name('admin.dana_keluar.create')->middleware('admin');
        Route::post('/edit', 'DanaKeluarController@edit')->name('admin.dana_keluar.edit')->middleware('admin');
        Route::post('/delete', 'DanaKeluarController@delete')->name('admin.dana_keluar.delete')->middleware('admin');
    });

    // Sumber Dana
    Route::group(['prefix' => 'sumber-dana'], function () {
        Route::get('/', 'SumberDanaController@index')->name('admin.sumber_dana.index')->middleware('admin');
        Route::get('/{id_sumberdana}', 'SumberDanaController@show')->name('admin.sumber_dana.show')->middleware('admin');
        Route::post('/add', 'SumberDanaController@create')->name('admin.sumber_dana.create')->middleware('admin');
        Route::post('/edit', 'SumberDanaController@edit')->name('admin.sumber_dana.edit')->middleware('admin');
        Route::post('/delete', 'SumberDanaController@delete')->name('admin.sumber_dana.delete')->middleware('admin');
    });

    // Jenis Pengeluaran
    Route::group(['prefix' => 'jenis-pengeluaran'], function () {
        Route::get('/', 'JenisPengeluaran@index')->name('admin.jenis_pengeluaran.index')->middleware('admin');
        Route::get('/{id_jenispengeluaran}', 'JenisPengeluaran@show')->name('admin.jenis_pengeluaran.show')->middleware('admin');
        Route::post('/add', 'JenisPengeluaran@create')->name('admin.jenis_pengeluaran.create')->middleware('admin');
        Route::post('/edit', 'JenisPengeluaran@edit')->name('admin.jenis_pengeluaran.edit')->middleware('admin');
        Route::post('/delete', 'JenisPengeluaran@delete')->name('admin.jenis_pengeluaran.delete')->middleware('admin');
    });

    // Arsip Surat
    Route::group(['prefix' => 'arsip-surat'], function () {
        Route::get('/', 'ArsipSuratController@index')->name('admin.arsip_surat.index')->middleware('admin');
        Route::get('/{id_arsipsurat}', 'ArsipSuratController@show')->name('admin.arsip_surat.show')->middleware('admin');
        Route::post('/add', 'ArsipSuratController@create')->name('admin.arsip_surat.create')->middleware('admin');
        Route::post('/edit', 'ArsipSuratController@edit')->name('admin.arsip_surat.edit')->middleware('admin');
        Route::post('/delete', 'ArsipSuratController@delete')->name('admin.arsip_surat.delete')->middleware('admin');
    });

    // User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('admin.user.index')->middleware('admin');
        Route::get('/{id_user}', 'UserController@show')->name('admin.user.show')->middleware('admin');
        Route::post('/add', 'UserController@create')->name('admin.user.create')->middleware('admin');
        Route::post('/edit', 'UserController@edit')->name('admin.user.edit')->middleware('admin');
        Route::post('/delete', 'UserController@delete')->name('admin.user.delete')->middleware('admin');
    });
});

Route::group(['prefix' => 'kepsek', 'namespace' => 'App\Http\Controllers\KepsekController'], function () {
    Route::get('/', 'KepsekDashboardController@index')->name('kepsek.dashboard.index')->middleware('kepsek');
});

Route::group(['prefix' => 'bendahara', 'namespace' => 'App\Http\Controllers\BendaharaController'], function () {
    Route::get('/', 'BendaharaDashboardController@index')->name('bendahara.dashboard.index')->middleware('bendahara');
});
