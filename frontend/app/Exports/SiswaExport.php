<?php

namespace App\Exports;

//use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {

        $siswa = DB::Select("SELECT nisn, nis, nama_siswa, tempat_lahir, tanggal_lahir as tanggal_lahir_siswa, jenis_kelamin, nik AS nik_siswa,
                                   nama_kelas, tingkat AS tingkat_kelas, status_siswa, nomor_kip, alamat, nomor_kk, nama_ayah, nik_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, alamat_ayah, status_keluarga_ayah,
                                   status_hidup_ayah as status_ayah, no_hp_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah,
                                   nama_ibu, nik_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, alamat_ibu, status_keluarga_ibu,
                                   status_hidup_ibu as status_ibu, no_hp_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu, jenis_wali,
                                   nama_wali, keterangan, alamat as alamat_wali, no_hp_wali, nomor_kks, nomor_pkh FROM data_siswa ds
                            INNER JOIN data_kelas dk on ds.id_kelas = dk.id
                            INNER JOIN data_wali_siswa dws on ds.id = dws.id_siswa");
        return collect($siswa);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true], 'alignment' => ['wrapText' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],],
        ];
    }

    public function headings(): array
    {
        return ["NISN", "NIS", "Nama Siswa", "Tempat Lahir Siswa", "Tanggal Lahir Siswa", "Jenis Kelamin", "NIK Siswa",
            "Kelas", "Tingkat", "Status Siswa", "Nomor KIP", "Alamat", "Nomor KK", "Nama Ayah", "NIK Ayah", "Tempat Lahir Ayah", "Tanggal Lahir Ayah", "Alamat Ayah",
            "Status Keluarga Ayah", "Status Ayah", "No HP Ayah", "Pendidikan Ayah", "Pekerjaan Ayah", "Penghasilan Ayah", "Nama Ibu", "NIK Ibu", "Tempat Lahir Ibu", "Tanggal Lahir Ibu",
            "Alamat Ibu", "Status Keluarga Ibu", "Status Ibu", "No HP Ibu", "Pendidikan Ibu", "Pekerjaan Ibu", "Penghasilan Ibu", "Jenis Wali", "Nama Wali",
            "Keterangan", "Alamat Wali", "No HP Wali", "No KKS", "No PKH"];

    }
}
