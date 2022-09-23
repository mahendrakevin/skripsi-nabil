<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $guru  = DB::select("SELECT nip, nuptk, nik, nama_guru, status_pegawai, tempat_lahir, tanggal_lahir, jenis_kelamin, status_perkawinan as status_pernikahan, alamat, no_hp, email FROM data_guru");
        return collect($guru);
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
        return ["NIP", "NUPTK", "NIK", "Nama Guru", "Status Pegawai", "Tempat Lahir", "Tanggal Lahir",
            "Jenis Kelamin", "Status Pernikahan", "Alamat", "No HP", "Email"];

    }
}
