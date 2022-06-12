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
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\AdminController'], function () {
    Route::get('/', 'AdminDashboardController@index')->name('admin.dashboard.index')->middleware('admin');

    // Siswa
    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', 'SiswaController@index')->name('admin.siswa.index')->middleware('admin');
        Route::get('/alumni', 'SiswaController@index_alumni')->name('admin.siswa.index_alumni')->middleware('admin');
        Route::get('/naik-kelas', 'SiswaController@naikkelas')->name('admin.siswa.naikkelas')->middleware('admin');
        Route::get('/siswa-naik/{id_kelas}', 'SiswaController@siswanaik')->name('admin.siswa.siswanaik')->middleware('admin');
        Route::post('/siswa-naik/naik/', 'SiswaController@naik')->name('admin.siswa.naik')->middleware('admin');
        Route::post('/siswa-naik/lulus/', 'SiswaController@lulus')->name('admin.siswa.lulus')->middleware('admin');
        Route::get('/{id_siswa}', 'SiswaController@show')->name('admin.siswa.show')->middleware('admin');
        Route::post('/add', 'SiswaController@create')->name('admin.siswa.create')->middleware('admin');
        Route::get('/edit/{id_siswa}', 'SiswaController@edit')->name('admin.siswa.edit')->middleware('admin');
        Route::post('/', 'SiswaController@store')->name('admin.siswa.store')->middleware('admin');
        Route::get('/change-status/{id_siswa}/{status}', 'SiswaController@change_status')->name('admin.siswa.change_status')->middleware('admin');
        Route::get('/update/{id_siswa}', 'SiswaController@update')->name('admin.siswa.update')->middleware('admin');
        Route::get('/hapus/{id_siswa}', 'SiswaController@destroy')->name('admin.siswa.destroy')->middleware('admin');
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
        Route::get('/edit/{id_guru}', 'GuruController@edit')->name('admin.guru.edit')->middleware('admin');
        Route::post('/delete', 'GuruController@delete')->name('admin.guru.delete')->middleware('admin');
        Route::post('/', 'GuruController@store')->name('admin.guru.store')->middleware('admin');
        Route::get('/update/{id_guru}', 'GuruController@update')->name('admin.guru.update')->middleware('admin');
        Route::get('/hapus/{id_guru}', 'GuruController@destroy')->name('admin.guru.destroy')->middleware('admin');
    });

    // Kepegawaian
    Route::group(['prefix' => 'kepegawaian'], function () {
        Route::get('/', 'KepegawaianController@index')->name('admin.kepegawaian.index')->middleware('admin');
        Route::get('/{id_guru}', 'KepegawaianController@show')->name('admin.kepegawaian.show')->middleware('admin');
        Route::post('/add', 'KepegawaianController@create')->name('admin.kepegawaian.create')->middleware('admin');
        Route::get('/edit/{id_kepegawaian}', 'KepegawaianController@edit')->name('admin.kepegawaian.edit')->middleware('admin');
        Route::post('/delete', 'KepegawaianController@delete')->name('admin.kepegawaian.delete')->middleware('admin');
        Route::post('/', 'KepegawaianController@store')->name('admin.kepegawaian.store')->middleware('admin');
        Route::get('/update/{id_kepegawaian}', 'KepegawaianController@update')->name('admin.kepegawaian.update')->middleware('admin');
        Route::get('/hapus/{id_kepegawaian}', 'KepegawaianController@destroy')->name('admin.kepegawaian.destroy')->middleware('admin');
    });

    // Jabatan
    Route::group(['prefix' => 'jabatan'], function () {
        Route::get('/', 'JabatanController@index')->name('admin.jabatan.index')->middleware('admin');
        Route::get('/{id_jabatan}', 'JabatanController@show')->name('admin.jabatan.show')->middleware('admin');
        Route::post('/add', 'JabatanController@create')->name('admin.jabatan.create')->middleware('admin');
        Route::get('/edit/{id_jabatan}', 'JabatanController@edit')->name('admin.jabatan.edit')->middleware('admin');
        Route::post('/delete', 'JabatanController@delete')->name('admin.jabatan.delete')->middleware('admin');
        Route::post('/', 'JabatanController@store')->name('admin.jabatan.store')->middleware('admin');
        Route::get('/update/{id_siswa}', 'JabatanController@update')->name('admin.jabatan.update')->middleware('admin');
        Route::get('/hapus/{id_siswa}', 'JabatanController@destroy')->name('admin.jabatan.destroy')->middleware('admin');
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
        Route::get('/', 'JenisWaliController@index')->name('admin.jeniswali.index')->middleware('admin');
        Route::get('/{id_jeniswali}', 'JenisWaliController@show')->name('admin.jeniswali.show')->middleware('admin');
        Route::post('/add', 'JenisWaliController@create')->name('admin.jeniswali.create')->middleware('admin');
        Route::get('/edit/{id_jeniswali}', 'JenisWaliController@edit')->name('admin.jeniswali.edit')->middleware('admin');
        Route::post('/delete', 'JenisWaliController@delete')->name('admin.jeniswali.delete')->middleware('admin');
        Route::post('/', 'JenisWaliController@store')->name('admin.jeniswali.store')->middleware('admin');
        Route::get('/update/{id_siswa}', 'JenisWaliController@update')->name('admin.jeniswali.update')->middleware('admin');
        Route::get('/hapus/{id_siswa}', 'JenisWaliController@destroy')->name('admin.jeniswali.destroy')->middleware('admin');
    });

    // Laporan Pembayaran
    Route::group(['prefix' => 'laporan-pembayaran'], function () {
        Route::get('/', 'LaporanPembayaranController@index')->name('admin.laporan_pembayaran.index')->middleware('admin');
        Route::get('/{id_laporanpembayaran}', 'LaporanPembayaranController@show')->name('admin.laporan_pembayaran.show')->middleware('admin');
        Route::post('/add', 'LaporanPembayaranController@create')->name('admin.laporan_pembayaran.create')->middleware('admin');
        Route::get('/edit/{id_laporanpembayaran}', 'LaporanPembayaranController@edit')->name('admin.laporan_pembayaran.edit')->middleware('admin');
        Route::post('/delete', 'LaporanPembayaranController@delete')->name('admin.laporan_pembayaran.delete')->middleware('admin');
        Route::post('/', 'LaporanPembayaranController@store')->name('admin.laporan_pembayaran.store')->middleware('admin');
        Route::get('/update/{id_laporanpembayaran}', 'LaporanPembayaranController@update')->name('admin.laporan_pembayaran.update')->middleware('admin');
        Route::get('/hapus/{id_laporanpembayaran}', 'LaporanPembayaranController@destroy')->name('admin.laporan_pembayaran.destroy')->middleware('admin');
    });

    // Jenis Pembayaran
    Route::group(['prefix' => 'jenis-pembayaran'], function () {
        Route::get('/', 'JenisPembayaranController@index')->name('admin.jenispembayaran.index')->middleware('admin');
        Route::get('/{id_jenispembayaran}', 'JenisPembayaranController@show')->name('admin.jenispembayaran.show')->middleware('admin');
        Route::post('/add', 'JenisPembayaranController@create')->name('admin.jenispembayaran.create')->middleware('admin');
        Route::get('/edit/{id_jenispembayaran}', 'JenisPembayaranController@edit')->name('admin.jenispembayaran.edit')->middleware('admin');
        Route::post('/delete', 'JenisPembayaranController@delete')->name('admin.jenispembayaran.delete')->middleware('admin');
        Route::post('/', 'JenisPembayaranController@store')->name('admin.jenispembayaran.store')->middleware('admin');
        Route::get('/update/{id_jenispembayaran}', 'JenisPembayaranController@update')->name('admin.jenispembayaran.update')->middleware('admin');
        Route::get('/hapus/{id_jenispembayaran}', 'JenisPembayaranController@destroy')->name('admin.jenispembayaran.destroy')->middleware('admin');
    });

    // Kelas
    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', 'KelasController@index')->name('admin.kelas.index')->middleware('admin');
        Route::get('/{id_kelas}', 'KelasController@show')->name('admin.kelas.show')->middleware('admin');
        Route::post('/add', 'KelasController@create')->name('admin.kelas.create')->middleware('admin');
        Route::get('/edit/{id_kelas}', 'KelasController@edit')->name('admin.kelas.edit')->middleware('admin');
        Route::post('/delete', 'KelasController@delete')->name('admin.kelas.delete')->middleware('admin');
        Route::post('/', 'KelasController@store')->name('admin.kelas.store')->middleware('admin');
        Route::get('/update/{id_kelas}', 'KelasController@update')->name('admin.kelas.update')->middleware('admin');
        Route::get('/hapus/{id_kelas}', 'KelasController@destroy')->name('admin.kelas.destroy')->middleware('admin');
    });

    // Lembaga
    Route::group(['prefix' => 'lembaga'], function () {
        Route::get('/', 'LembagaController@index')->name('admin.lembaga.index')->middleware('admin');
        Route::get('/{id_lembaga}', 'LembagaController@show')->name('admin.lembaga.show')->middleware('admin');
        Route::post('/add', 'LembagaController@create')->name('admin.lembaga.create')->middleware('admin');
        Route::get('/edit/{id_lembaga}', 'LembagaController@edit')->name('admin.lembaga.edit')->middleware('admin');
        Route::post('/delete', 'LembagaController@delete')->name('admin.lembaga.delete')->middleware('admin');
        Route::post('/', 'LembagaController@store')->name('admin.lembaga.store')->middleware('admin');
        Route::get('/update/{id_lembaga}', 'LembagaController@update')->name('admin.lembaga.update')->middleware('admin');
        Route::get('/hapus/{id_lembaga}', 'LembagaController@destroy')->name('admin.lembaga.destroy')->middleware('admin');
    });

    // Sarana Prasarana
    Route::group(['prefix' => 'sarpras'], function () {
        Route::get('/', 'SarprasController@index')->name('admin.sarpras.index')->middleware('admin');
        Route::get('/{id_sarpras}', 'SarprasController@show')->name('admin.sarpras.show')->middleware('admin');
        Route::post('/add', 'SarprasController@create')->name('admin.sarpras.create')->middleware('admin');
        Route::get('/edit/{id_sarpras}', 'SarprasController@edit')->name('admin.sarpras.edit')->middleware('admin');
        Route::post('/delete', 'SarprasController@delete')->name('admin.sarpras.delete')->middleware('admin');
        Route::post('/', 'SarprasController@store')->name('admin.sarpras.store')->middleware('admin');
        Route::get('/update/{id_sarpras}', 'SarprasController@update')->name('admin.sarpras.update')->middleware('admin');
        Route::get('/hapus/{id_sarpras}', 'SarprasController@destroy')->name('admin.sarpras.destroy')->middleware('admin');
    });

    // Aset
    Route::group(['prefix' => 'aset'], function () {
        Route::post('/add', 'AsetController@create')->name('admin.aset.create')->middleware('admin');
        Route::get('/edit/{id_aset}', 'AsetController@edit')->name('admin.aset.edit')->middleware('admin');
        Route::post('/delete', 'AsetController@delete')->name('admin.aset.delete')->middleware('admin');
        Route::post('/', 'AsetController@store')->name('admin.aset.store')->middleware('admin');
        Route::get('/update/{id_aset}', 'AsetController@update')->name('admin.aset.update')->middleware('admin');
        Route::get('/hapus/{id_aset}', 'AsetController@destroy')->name('admin.aset.destroy')->middleware('admin');
    });

    // Surat Keterangan
    Route::group(['prefix' => 'surat-keterangan'], function () {
        Route::get('/', 'SuratKeteranganController@index')->name('admin.surat_keterangan.index')->middleware('admin');
        Route::get('/{id_suratketerangan}', 'SuratKeteranganController@show')->name('admin.surat_keterangan.show')->middleware('admin');
        Route::post('/add', 'SuratKeteranganController@create')->name('admin.surat_keterangan.create')->middleware('admin');
        Route::get('/edit/{id_suratketerangan}', 'SuratKeteranganController@edit')->name('admin.surat_keterangan.edit')->middleware('admin');
        Route::post('/delete', 'SuratKeteranganController@delete')->name('admin.surat_keterangan.delete')->middleware('admin');
        Route::post('/', 'SuratKeteranganController@store')->name('admin.surat_keterangan.store')->middleware('admin');
        Route::get('/update/{id_suratketerangan}', 'SuratKeteranganController@update')->name('admin.surat_keterangan.update')->middleware('admin');
        Route::get('/hapus/{id_suratketerangan}', 'SuratKeteranganController@destroy')->name('admin.surat_keterangan.destroy')->middleware('admin');
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

    // Alokasi Dana
    Route::group(['prefix' => 'alokasi-dana'], function () {
        Route::get('/', 'AlokasiDanaController@index')->name('admin.alokasi_dana.index')->middleware('admin');

        // Route::get('/dana-masuk/{id_danamasuk}', 'AlokasiDanaController@show_masuk')->name('admin.alokasi_dana.show_masuk')->middleware('admin');
        Route::post('/dana-masuk/add', 'AlokasiDanaController@create_masuk')->name('admin.alokasi_dana.create_masuk')->middleware('admin');
        Route::get('/dana-masuk/edit/{id_danamasuk}', 'AlokasiDanaController@edit_masuk')->name('admin.alokasi_dana.edit_masuk')->middleware('admin');
        Route::post('/dana-masuk/delete', 'AlokasiDanaController@delete_masuk')->name('admin.alokasi_dana.delete_masuk')->middleware('admin');
        Route::post('/dana-masuk/', 'AlokasiDanaController@store_masuk')->name('admin.alokasi_dana.store_masuk')->middleware('admin');
        Route::get('/dana-masuk/update/{id_danamasuk}', 'AlokasiDanaController@update_masuk')->name('admin.alokasi_dana.update_masuk')->middleware('admin');
        Route::get('/dana-masuk/hapus/{id_danamasuk}', 'AlokasiDanaController@destroy_masuk')->name('admin.alokasi_dana.destroy_masuk')->middleware('admin');

        // Route::get('/dana-keluar/{id_danakeluar}', 'AlokasiDanaController@show_keluar')->name('admin.alokasi_dana.show_keluar')->middleware('admin');
        Route::post('/dana-keluar/add', 'AlokasiDanaController@create_keluar')->name('admin.alokasi_dana.create_keluar')->middleware('admin');
        Route::get('/dana-keluar/edit/{id_danakeluar}', 'AlokasiDanaController@edit_keluar')->name('admin.alokasi_dana.edit_keluar')->middleware('admin');
        Route::post('/dana-keluar/delete', 'AlokasiDanaController@delete_keluar')->name('admin.alokasi_dana.delete_keluar')->middleware('admin');
        Route::post('/dana-keluar/', 'AlokasiDanaController@store_keluar')->name('admin.alokasi_dana.store_keluar')->middleware('admin');
        Route::get('/dana-keluar/update/{id_danakeluar}', 'AlokasiDanaController@update_keluar')->name('admin.alokasi_dana.update_keluar')->middleware('admin');
        Route::get('/dana-keluar/hapus/{id_danakeluar}', 'AlokasiDanaController@destroy_keluar')->name('admin.alokasi_dana.destroy_keluar')->middleware('admin');
    });

    // Sumber Dana
    Route::group(['prefix' => 'sumber-alokasidana'], function () {
        Route::get('/', 'SumberDanaController@index')->name('admin.sumber_dana.index')->middleware('admin');
        Route::get('/{id_sumberdana}', 'SumberDanaController@show')->name('admin.sumber_dana.show')->middleware('admin');
        Route::post('/add', 'SumberDanaController@create')->name('admin.sumber_dana.create')->middleware('admin');
        Route::get('/edit/{id_sumberdana}', 'SumberDanaController@edit')->name('admin.sumber_dana.edit')->middleware('admin');
        Route::post('/delete', 'SumberDanaController@delete')->name('admin.sumber_dana.delete')->middleware('admin');
        Route::post('/', 'SumberDanaController@store')->name('admin.sumber_dana.store')->middleware('admin');
        Route::get('/update/{id_sumberdana}', 'SumberDanaController@update')->name('admin.sumber_dana.update')->middleware('admin');
        Route::get('/hapus/{id_sumberdana}', 'SumberDanaController@destroy')->name('admin.sumber_dana.destroy')->middleware('admin');
    });

    // Jenis Pengeluaran
    Route::group(['prefix' => 'jenis-pengeluaran'], function () {
        Route::get('/', 'JenisPengeluaranController@index')->name('admin.jenis_pengeluaran.index')->middleware('admin');
        Route::get('/{id_jenispengeluaran}', 'JenisPengeluaranController@show')->name('admin.jenis_pengeluaran.show')->middleware('admin');
        Route::post('/add', 'JenisPengeluaranController@create')->name('admin.jenis_pengeluaran.create')->middleware('admin');
        Route::get('/edit/{id_jenispengeluaran}', 'JenisPengeluaranController@edit')->name('admin.jenis_pengeluaran.edit')->middleware('admin');
        Route::post('/delete', 'JenisPengeluaranController@delete')->name('admin.jenis_pengeluaran.delete')->middleware('admin');
        Route::post('/', 'JenisPengeluaranController@store')->name('admin.jenis_pengeluaran.store')->middleware('admin');
        Route::get('/update/{id_jenispengeluaran}', 'JenisPengeluaranController@update')->name('admin.jenis_pengeluaran.update')->middleware('admin');
        Route::get('/hapus/{id_jenispengeluaran}', 'JenisPengeluaranController@destroy')->name('admin.jenis_pengeluaran.destroy')->middleware('admin');
    });

    // Arsip Surat
    Route::group(['prefix' => 'arsip-surat'], function () {
        Route::get('/', 'ArsipSuratController@index')->name('admin.arsip_surat.index')->middleware('admin');
        Route::get('/{id_arsipsurat}', 'ArsipSuratController@show')->name('admin.arsip_surat.show')->middleware('admin');
        Route::post('/add', 'ArsipSuratController@create')->name('admin.arsip_surat.create')->middleware('admin');
        Route::get('/edit/{id_arsipsurat}', 'ArsipSuratController@edit')->name('admin.arsip_surat.edit')->middleware('admin');
        Route::post('/delete', 'ArsipSuratController@delete')->name('admin.arsip_surat.delete')->middleware('admin');
        Route::post('/', 'ArsipSuratController@store')->name('admin.arsip_surat.store')->middleware('admin');
        Route::get('/update/{id_arsipsurat}', 'ArsipSuratController@update')->name('admin.arsip_surat.update')->middleware('admin');
        Route::get('/hapus/{id_arsipsurat}', 'ArsipSuratController@destroy')->name('admin.arsip_surat.destroy')->middleware('admin');
    });

    // User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('admin.users.index')->middleware('admin');
        Route::get('/{id_user}', 'UserController@show')->name('admin.users.show')->middleware('admin');
        Route::post('/add', 'UserController@create')->name('admin.users.create')->middleware('admin');
        Route::get('/edit/{id_user}', 'UserController@edit')->name('admin.users.edit')->middleware('admin');
        Route::post('/delete', 'UserController@delete')->name('admin.users.delete')->middleware('admin');
        Route::post('/', 'UserController@store')->name('admin.users.store')->middleware('admin');
        Route::get('/update/{id_user}', 'UserController@update')->name('admin.users.update')->middleware('admin');
        Route::get('/hapus/{id_user}', 'UserController@destroy')->name('admin.users.destroy')->middleware('admin');
    });
});

Route::group(['prefix' => 'kepsek', 'namespace' => 'App\Http\Controllers\KepsekController'], function () {
    Route::get('/', 'KepsekDashboardController@index')->name('kepsek.dashboard.index')->middleware('kepsek');
    // Siswa
    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', 'SiswaController@index')->name('kepsek.siswa.index')->middleware('kepsek');
        Route::get('/alumni', 'SiswaController@index_alumni')->name('kepsek.siswa.index_alumni')->middleware('kepsek');
        Route::get('/{id_siswa}', 'SiswaController@show')->name('kepsek.siswa.show')->middleware('kepsek');
    });

    // Guru
    Route::group(['prefix' => 'guru'], function () {
        Route::get('/', 'GuruController@index')->name('kepsek.guru.index')->middleware('kepsek');
        Route::get('/{id_guru}', 'GuruController@show')->name('kepsek.guru.show')->middleware('kepsek');
    });

    // Kepegawaian
    Route::group(['prefix' => 'kepegawaian'], function () {
        Route::get('/', 'KepegawaianController@index')->name('kepsek.kepegawaian.index')->middleware('kepsek');
        Route::get('/{id_guru}', 'KepegawaianController@show')->name('kepsek.kepegawaian.show')->middleware('kepsek');
    });

    // Jabatan
    Route::group(['prefix' => 'jabatan'], function () {
        Route::get('/', 'JabatanController@index')->name('kepsek.jabatan.index')->middleware('kepsek');
        Route::get('/{id_jabatan}', 'JabatanController@show')->name('kepsek.jabatan.show')->middleware('kepsek');

    });

    // Wali Siswa
    Route::group(['prefix' => 'wali'], function () {
        Route::get('/', 'WaliSiswaController@index')->name('kepsek.wali.index')->middleware('kepsek');
        Route::get('/{id_walisiswa}', 'WaliSiswaController@show')->name('kepsek.wali.show')->middleware('kepsek');
        Route::post('/add', 'WaliSiswaController@create')->name('kepsek.wali.create')->middleware('kepsek');
        Route::post('/edit', 'WaliSiswaController@edit')->name('kepsek.wali.edit')->middleware('kepsek');
        Route::post('/delete', 'WaliSiswaController@delete')->name('kepsek.wali.delete')->middleware('kepsek');
    });

    // Jenis Wali
    Route::group(['prefix' => 'jeniswali'], function () {
        Route::get('/', 'JenisWaliController@index')->name('kepsek.jeniswali.index')->middleware('kepsek');
        Route::get('/{id_jeniswali}', 'JenisWaliController@show')->name('kepsek.jeniswali.show')->middleware('kepsek');
    });

    // Laporan Pembayaran
    Route::group(['prefix' => 'laporan-pembayaran'], function () {
        Route::get('/', 'LaporanPembayaranController@index')->name('kepsek.laporan_pembayaran.index')->middleware('kepsek');
        Route::get('/{id_laporanpembayaran}', 'LaporanPembayaranController@show')->name('kepsek.laporan_pembayaran.show')->middleware('kepsek');
    });

    // Jenis Pembayaran
    Route::group(['prefix' => 'jenis-pembayaran'], function () {
        Route::get('/', 'JenisPembayaranController@index')->name('kepsek.jenispembayaran.index')->middleware('kepsek');
        Route::get('/{id_jenispembayaran}', 'JenisPembayaranController@show')->name('kepsek.jenispembayaran.show')->middleware('kepsek');
    });

    // Kelas
    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', 'KelasController@index')->name('kepsek.kelas.index')->middleware('kepsek');
        Route::get('/{id_kelas}', 'KelasController@show')->name('kepsek.kelas.show')->middleware('kepsek');
    });

    // Lembaga
    Route::group(['prefix' => 'lembaga'], function () {
        Route::get('/', 'LembagaController@index')->name('kepsek.lembaga.index')->middleware('kepsek');
        Route::get('/{id_lembaga}', 'LembagaController@show')->name('kepsek.lembaga.show')->middleware('kepsek');
    });

    // Sarana Prasarana
    Route::group(['prefix' => 'sarpras'], function () {
        Route::get('/', 'SarprasController@index')->name('kepsek.sarpras.index')->middleware('kepsek');
        Route::get('/{id_sarpras}', 'SarprasController@show')->name('kepsek.sarpras.show')->middleware('kepsek');
    });

    // Surat Keterangan
    Route::group(['prefix' => 'surat-keterangan'], function () {
        Route::get('/', 'SuratKeteranganController@index')->name('kepsek.surat_keterangan.index')->middleware('kepsek');
        Route::get('/{id_suratketerangan}', 'SuratKeteranganController@show')->name('kepsek.surat_keterangan.show')->middleware('kepsek');
    });


    // Alokasi Dana
    Route::group(['prefix' => 'alokasi-dana'], function () {
        Route::get('/', 'AlokasiDanaController@index')->name('kepsek.alokasi_dana.index')->middleware('kepsek');
        Route::get('/show/{id_dana}/{type}', 'AlokasiDanaController@show')->name('kepsek.alokasi_dana.show')->middleware('kepsek');
    });

    // Sumber Dana
    Route::group(['prefix' => 'sumber-alokasidana'], function () {
        Route::get('/', 'SumberDanaController@index')->name('kepsek.sumber_dana.index')->middleware('kepsek');
        Route::get('/{id_sumberdana}', 'SumberDanaController@show')->name('kepsek.sumber_dana.show')->middleware('kepsek');
    });

    // Jenis Pengeluaran
    Route::group(['prefix' => 'jenis-pengeluaran'], function () {
        Route::get('/', 'JenisPengeluaranController@index')->name('kepsek.jenis_pengeluaran.index')->middleware('kepsek');
        Route::get('/{id_jenispengeluaran}', 'JenisPengeluaranController@show')->name('kepsek.jenis_pengeluaran.show')->middleware('kepsek');
    });

    // Arsip Surat
    Route::group(['prefix' => 'arsip-surat'], function () {
        Route::get('/', 'ArsipSuratController@index')->name('kepsek.arsip_surat.index')->middleware('kepsek');
        Route::get('/{id_arsipsurat}', 'ArsipSuratController@show')->name('kepsek.arsip_surat.show')->middleware('kepsek');
    });

    // User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('kepsek.users.index')->middleware('kepsek');
        Route::get('/{id_user}', 'UserController@show')->name('kepsek.users.show')->middleware('kepsek');
    });
});

Route::group(['prefix' => 'bendahara', 'namespace' => 'App\Http\Controllers\BendaharaController'], function () {
    Route::get('/', 'BendaharaDashboardController@index')->name('bendahara.dashboard.index')->middleware('bendahara');
    // Dana Masuk
    // Alokasi Dana
    Route::group(['prefix' => 'alokasi-dana'], function () {
        Route::get('/', 'AlokasiDanaController@index')->name('bendahara.alokasi_dana.index')->middleware('bendahara');
        Route::get('/edit/{id_dana}/{type}', 'AlokasiDanaController@edit')->name('bendahara.alokasi_dana.edit')->middleware('bendahara');
        Route::get('/hapus/{id_dana}/{type}', 'AlokasiDanaController@destroy')->name('bendahara.alokasi_dana.destroy')->middleware('bendahara');
        Route::get('/show/{id_dana}/{type}', 'AlokasiDanaController@show')->name('bendahara.alokasi_dana.show')->middleware('bendahara');


        // Route::get('/dana-masuk/{id_danamasuk}', 'AlokasiDanaController@show_masuk')->name('admin.alokasi_dana.show_masuk')->middleware('admin');
        Route::post('/dana-masuk/add', 'AlokasiDanaController@create_masuk')->name('bendahara.alokasi_dana.create_masuk')->middleware('bendahara');
        Route::post('/dana-masuk/', 'AlokasiDanaController@store_masuk')->name('bendahara.alokasi_dana.store_masuk')->middleware('bendahara');
        Route::get('/dana-masuk/update/{id_danamasuk}', 'AlokasiDanaController@update_masuk')->name('bendahara.alokasi_dana.update_masuk')->middleware('bendahara');

        // Route::get('/dana-keluar/{id_danakeluar}', 'AlokasiDanaController@show_keluar')->name('bendahara.alokasi_dana.show_keluar')->middleware('bendahara');
        Route::post('/dana-keluar/add', 'AlokasiDanaController@create_keluar')->name('bendahara.alokasi_dana.create_keluar')->middleware('bendahara');
        Route::post('/dana-keluar/', 'AlokasiDanaController@store_keluar')->name('bendahara.alokasi_dana.store_keluar')->middleware('bendahara');
        Route::get('/dana-keluar/update/{id_danakeluar}', 'AlokasiDanaController@update_keluar')->name('bendahara.alokasi_dana.update_keluar')->middleware('bendahara');
    });

    // Sumber Dana
    Route::group(['prefix' => 'sumber-alokasidana'], function () {
        Route::get('/', 'SumberDanaController@index')->name('bendahara.sumber_dana.index')->middleware('bendahara');
        Route::get('/{id_sumberdana}', 'SumberDanaController@show')->name('bendahara.sumber_dana.show')->middleware('bendahara');
        Route::post('/add', 'SumberDanaController@create')->name('bendahara.sumber_dana.create')->middleware('bendahara');
        Route::get('/edit/{id_sumberdana}', 'SumberDanaController@edit')->name('bendahara.sumber_dana.edit')->middleware('bendahara');
        Route::post('/delete', 'SumberDanaController@delete')->name('bendahara.sumber_dana.delete')->middleware('bendahara');
        Route::post('/', 'SumberDanaController@store')->name('bendahara.sumber_dana.store')->middleware('bendahara');
        Route::get('/update/{id_sumberdana}', 'SumberDanaController@update')->name('bendahara.sumber_dana.update')->middleware('bendahara');
        Route::get('/hapus/{id_sumberdana}', 'SumberDanaController@destroy')->name('bendahara.sumber_dana.destroy')->middleware('bendahara');
    });

    // Jenis Pengeluaran
    Route::group(['prefix' => 'jenis-pengeluaran'], function () {
        Route::get('/', 'JenisPengeluaranController@index')->name('bendahara.jenis_pengeluaran.index')->middleware('bendahara');
        Route::get('/{id_jenispengeluaran}', 'JenisPengeluaranController@show')->name('bendahara.jenis_pengeluaran.show')->middleware('bendahara');
        Route::post('/add', 'JenisPengeluaranController@create')->name('bendahara.jenis_pengeluaran.create')->middleware('bendahara');
        Route::get('/edit/{id_jenispengeluaran}', 'JenisPengeluaranController@edit')->name('bendahara.jenis_pengeluaran.edit')->middleware('bendahara');
        Route::post('/delete', 'JenisPengeluaranController@delete')->name('bendahara.jenis_pengeluaran.delete')->middleware('bendahara');
        Route::post('/', 'JenisPengeluaranController@store')->name('bendahara.jenis_pengeluaran.store')->middleware('bendahara');
        Route::get('/update/{id_jenispengeluaran}', 'JenisPengeluaranController@update')->name('bendahara.jenis_pengeluaran.update')->middleware('bendahara');
        Route::get('/hapus/{id_jenispengeluaran}', 'JenisPengeluaranController@destroy')->name('bendahara.jenis_pengeluaran.destroy')->middleware('bendahara');
    });

    // Jenis Pembayaran
    Route::group(['prefix' => 'jenis-pembayaran'], function () {
        Route::get('/', 'JenisPembayaranController@index')->name('bendahara.jenispembayaran.index')->middleware('bendahara');
        Route::get('/{id_jenispembayaran}', 'JenisPembayaranController@show')->name('bendahara.jenispembayaran.show')->middleware('bendahara');
        Route::post('/add', 'JenisPembayaranController@create')->name('bendahara.jenispembayaran.create')->middleware('bendahara');
        Route::get('/edit/{id_jenispembayaran}', 'JenisPembayaranController@edit')->name('bendahara.jenispembayaran.edit')->middleware('bendahara');
        Route::post('/delete', 'JenisPembayaranController@delete')->name('bendahara.jenispembayaran.delete')->middleware('bendahara');
        Route::post('/', 'JenisPembayaranController@store')->name('bendahara.jenispembayaran.store')->middleware('bendahara');
        Route::get('/update/{id_jenispembayaran}', 'JenisPembayaranController@update')->name('bendahara.jenispembayaran.update')->middleware('bendahara');
        Route::get('/hapus/{id_jenispembayaran}', 'JenisPembayaranController@destroy')->name('bendahara.jenispembayaran.destroy')->middleware('bendahara');
    });

    // Laporan Pembayaran Siswa
    Route::group(['prefix' => 'laporan-pembayaran'], function () {
        Route::get('/', 'LaporanPembayaranController@index')->name('bendahara.laporan_pembayaran.index')->middleware('bendahara');
        Route::get('/{id_laporanpembayaran}', 'LaporanPembayaranController@show')->name('bendahara.laporan_pembayaran.show')->middleware('bendahara');
        Route::post('/add', 'LaporanPembayaranController@create')->name('bendahara.laporan_pembayaran.create')->middleware('bendahara');
        Route::get('/edit/{id_laporanpembayaran}', 'LaporanPembayaranController@edit')->name('bendahara.laporan_pembayaran.edit')->middleware('bendahara');
        Route::post('/delete', 'LaporanPembayaranController@delete')->name('bendahara.laporan_pembayaran.delete')->middleware('bendahara');
        Route::post('/', 'LaporanPembayaranController@store')->name('bendahara.laporan_pembayaran.store')->middleware('bendahara');
        Route::get('/update/{id_laporanpembayaran}', 'LaporanPembayaranController@update')->name('bendahara.laporan_pembayaran.update')->middleware('bendahara');
        Route::get('/hapus/{id_laporanpembayaran}', 'LaporanPembayaranController@destroy')->name('bendahara.laporan_pembayaran.destroy')->middleware('bendahara');
    });
});

Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
