from datetime import datetime, date
from sys import modules
from pydantic import BaseModel
from typing import Optional, List, Text

from pydantic.fields import Field
from sqlalchemy.orm import selectinload
from sqlalchemy.sql.sqltypes import String

class Nasabah(BaseModel):
    #nasabah page
    #data nasabah
    nama_nasabah: Optional[str] = 'PERUSAHAAN FIKTIF'
    #data perusahaan
    id_bidang_usaha: Optional[str] = '0001'
    lokasi_usaha: Optional[str] = '1201'
    status_keterkaitan: Optional[str] = '0'
    is_bank: Optional[str] = 'F'
    #data pemilik
    id_golongan_pemilik: Optional[str] = '4159'
    #data alamat kontak
    alamat_surat_jalan: Optional[str] = 'jalan'
    alamat_surat_rt: Optional[str] = 'rt'
    alamat_surat_rw: Optional[str] = 'rw'
    alamat_surat_kelurahan: Optional[str] = 'kelurahan'
    alamat_surat_kecamatan: Optional[str] = 'kecamatan'
    alamat_surat_kota_kabupaten: Optional[str] = 'kota'
    alamat_surat_provinsi: Optional[str] = 'provinsi'
    alamat_surat_kode_pos: Optional[str] = '40191'
    #informasi lainnya
    nasabah_prioritas: Optional[str] = 'F'
    #hirarki nasabah
    nomor_nasabah_induk: Optional[str] = '1234567890'
    referal_nasabah: Optional[str] = 'referel'
    kode_marketing: Optional[str] = 'kode marketing'
    keterangan: Optional[str] = 'keterangan'

    #cdd page
    #data tambahan
    sumber_dana_lain: Optional[str] = 'bisnis'
    id_golongan_nasabah: Optional[str] = '4173'
    id_tujuan_penggunaan_dana: Optional[str] = '2'
    id_sumber_dana: Optional[str] = '1201'
    #status pajak dan skb pajak
    status_skb: Optional[str] = '1'
    keterangan_skb: Optional[str] = 'keterangan skb'
    nomor_surat_skb: Optional[str] = '123455678'
    tgl_terbit_skb: Optional[str] = '01-10-1990'
    tgl_berakhir_skb: Optional[str] = '01-10-1990'
    #limit transaksi
    limit_nom_setor_tunai: float = 0.0
    limit_nom_setor_nontunai: float = 0.0
    limit_nom_tarik_tunai: float = 0.0
    limit_nom_tarik_nontunai: float = 0.0
    limit_frek_setor_tunai: float = 0.0
    limit_frek_setor_nontunai: float = 0.0
    limit_frek_tarik_tunai: float = 0.0
    limit_frek_tarik_nontunai: float = 0.0
    #faktor resiko
    status_resiko: Optional[str] = 'L'

    #-- another default data
    is_otorisasi: Optional[str] = 'T'
    is_wic: Optional[str] = 'F'
    status_data: Optional[str] = 'A'
    jenis_nasabah: Optional[str] = 'K'
    jenis_penduduk: Optional[str] = 'P'
    #golongan_pemilik_xlbrl: Optional[str]
    #buka_rek_untuk_gaji: Optional[str] = 'F'
    #buka_rek_untuk_program_pemerintah: Optional[str] = 'F'
    id_faktor_resiko: Optional[int] = 0
    #status_info_komersial: Optional[str] = 'Y'
    tujuan_buka_rekening: Optional[str] = ''

class NasabahKorporat(BaseModel):
    #nasabah page
    #data nasabah
    nama_perusahaan: Optional[str] = 'PERUSAHAAN FIKTIF'
    aset_perusahaan: float = 0.0 #field baru
    omset_perusahaan: float = 0.0 #field baru
    id_badan_hukum: Optional[str] = 'A'
    nomor_npwp: Optional[str] = '123456789012345'
    #data perusahaan
    id_sektor_ekonomi: Optional[str] = 'B'
    nomor_siupp: Optional[str] = '12345'
    tanggal_siupp: Optional[str] = '01-10-1990'
    akte_perubahan_nomor:Optional[str] = '12345'
    akte_perubahan_tanggal: Optional[str] = '01-10-1990'
    skdp_nomor:Optional[str] = '12345'
    skdp_tanggal_pengesahan: Optional[str] = '01-10-1990'
    skdp_tanggal_kadaluarsa: Optional[str] = '01-10-1990'
    akte_pendirian_nomor: Optional[str] = '12345'
    akte_pendirian_tanggal: Optional[str] = '01-10-1990'
    sk_menkumham_nomor: Optional[str] = '12345'
    sk_menkumham_tanggal: Optional[str] = '01-10-1990'
    akte_pendirian_tempat: Optional[str] = 'tempat'
    tdp_nomor: Optional[str] = '12345'
    #data pemilik
    cp_nama: Optional[str] = 'CP NAMA'
    id_pemilik: Optional[str] = 'C'
    #data alamat kontak
    telp_kantor1_kode_area: Optional[str] = '1'
    telp_kantor1_nomor: Optional[str] = '1'
    telp_kantor2_kode_area: Optional[str] = '2'
    telp_kantor2_nomor: Optional[str] = '2'
    telp_kantor3_kode_area: Optional[str] = '3'
    telp_kantor3_nomor: Optional[str] = '3'
    fax_kode_area: Optional[str] = 'area'
    fax_nomor: Optional[str] = 'fax nomor'
    alamat_email: Optional[str] = 'email'
    #informasi lainnya
    #hirarki nasabah

    #cdd page
    #data tambahan
    id_penghasilan_kotor: Optional[str] = '1'

class IndividuKorporat(BaseModel):
    alamat_rumah_jalan: Optional[str] = 'jalan'
    alamat_email: Optional[str] = 'email'
    fax_kode_area: Optional[str] = 'fax'
    fax_nomor: Optional[str] = 'fax'
    gelar_belakang: Optional[str] = 'ST'
    alamat_rumah_kecamatan: Optional[str] = 'kecamatan'
    alamat_rumah_kelurahan: Optional[str] = 'kelurahan'
    kewarganegaraan: Optional[str] = '1'
    alamat_rumah_kode_pos: Optional[str] = '40191'
    alamat_rumah_kota_kabupaten: Optional[str] = 'kota'
    nama_lengkap: Optional[str] = 'nama'
    id_negara: Optional[str] = 'ID'
    telepon_hp_nomor: Optional[str] = 'hp'
    nomor_identitas: Optional[str] = 'identitas'
    nomor_npwp: Optional[str] = 'npwp'
    id_pekerjaan: Optional[str] = '0001'
    alamat_rumah_provinsi: Optional[str] = 'provinsi'
    alamat_rumah_rt: Optional[str] = 'rt'
    alamat_rumah_rw: Optional[str] = 'rw'
    telepon_rumah_kode_area: Optional[str] = 'area'
    telepon_rumah_nomor: Optional[str] = 'nomor'

class PejabatKorporat(BaseModel):
    id_jabatan: Optional[str] = '1'
    keterangan: Optional[str] = 'keterangan'
    nomor_nasabah_pejabat: Optional[str] = ''
    persentase_kepemilikan: Optional[float] = 30.5

class Pejabat(BaseModel):
    individu: Optional[IndividuKorporat] = Field(alias='individu')
    pejabatkorporat: Optional[PejabatKorporat] = Field(alias='pejabatkorporat')

class RiskFactorKorporat(BaseModel):
    id_riskcust: str
    risk_status: str = 'L'

class Renas(BaseModel):
    id_tipe_relasi: Optional[str] = ''
    jabatan: Optional[str] = ''
    nomor_nasabah_relasi: Optional[str] = ''

class ReNasKorporat(BaseModel):
    individu: Optional[IndividuKorporat] = Field(alias='individu')
    relasinasabah: Optional[Renas] = Field(alias='relasinasabah')

class BeOwnKorporat(BaseModel):
    beneficiaryownertype: Optional[str] = 'I'
    status: Optional[str] = 'A'
    keterangan: Optional[str] = 'keterangan'
    id_sumber_dana: Optional[str] = '1201'
    id_tujuan_penggunaan_dana: Optional[str] = '2'
    alamat_domisili_jalan: Optional[str] = 'jalan'
    alamat_domisili_kecamatan: Optional[str] = 'kecamatan'
    alamat_domisili_kelurahan: Optional[str] = 'kelurahan'
    alamat_domisili_kode_pos: Optional[str] = '40191'
    alamat_domisili_kota_kabupaten: Optional[str] = 'kota'
    alamat_domisili_provinsi: Optional[str] = 'provinsi'
    alamat_domisili_rt: Optional[str] = 'rt'
    alamat_domisili_rw: Optional[str] = 'rw'

class BOKorporat(BaseModel):
    individu: Optional[IndividuKorporat] = Field(alias='individu')
    beneficiaryowner: Optional[BeOwnKorporat] = Field(alias='beneficiaryowner')

class NasabahKorporatRegister(BaseModel):
    kode_cabang: Optional[str] = '001'
    user_input: Optional[str] = 'SYSTEM'
    user_update: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'
    nasabah: Optional[Nasabah] = Field(alias='nasabah')
    nasabahkorporat: Optional[NasabahKorporat] = Field(alias='nasabahkorporat')
    faktorresiko: Optional[List[RiskFactorKorporat]] = Field(alias='faktorresiko')
    pejabat: Optional[List[Pejabat]] = Field(alias='pejabat')
    relasinasabah: Optional[List[ReNasKorporat]] = Field(alias='relasinasabah')
    beneficiaryowner: Optional[BOKorporat] = Field(alias='beneficiaryowner')

class NasabahKorporatUpdate(BaseModel):
    nomor_nasabah: Optional[str] = '1234'
    kode_cabang: Optional[str] = '001'
    user_input: Optional[str] = 'SYSTEM'
    user_update: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'
    nasabah: Optional[Nasabah] = Field(alias='nasabah')
    nasabahkorporat: Optional[NasabahKorporat] = Field(alias='nasabahkorporat')