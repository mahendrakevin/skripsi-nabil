from datetime import datetime, date
from sys import modules
from pydantic import BaseModel
from typing import Optional, List, Text

from pydantic.fields import Field
from sqlalchemy.orm import selectinload
from sqlalchemy.sql.sqltypes import String

class Identitas(BaseModel):
    #identitas
    jenis_identitas: str = '01' #Mapping
    nomor_identitas: str
    nama_sesuai_identitas: str
    tanggal_terbit_identitas: Optional[str] = "dd-mm-yyyy"
    tanggal_berakhir_identitas: Optional[str] = "dd-mm-yyyy"
    tempat_lahir: Optional[str]
    tanggal_lahir: str = "dd-mm-yyyy"
    #data diri
    nama_lengkap: Optional[str]
    gelar_depan: Optional[str]
    gelar_belakang: Optional[str]
    nama_alias_1: Optional[str]
    nama_alias_2: Optional[str]
    nama_alias_3: Optional[str]
    nama_alias_4: Optional[str] 
    jenis_kelamin: Optional[str] # P = Pria, W = Wanita #Mapping
    agama: Optional[str] #Mapping
    nama_ibu_kandung: Optional[str]
    status_perkawinan: Optional[str] = '0' #Mapping
    kewarganegaraan: Optional[str] #Mapping
    negara_asal: Optional[str] #Mapping
    #Informasi Lainnya
    alamat_email: Optional[str]
    pendidikan: Optional[str] = '0' #Mapping
    jenis_penduduk: Optional[str] = '0' #Mapping
    status_keterkaitan: Optional[str] = 'F' #Mapping
    keterangan: Optional[str]
    nasabah_prioritas: Optional[str] = 'F' #Mapping
    npwp: Optional[str]
    referal_nasabah: Optional[str]
    kode_marketing: Optional[str] 
    alamat_luar_negeri: Optional[str]

class IdentitasDet(Identitas):
    tanggal_lahir: Optional[str] = "dd-mm-yyyy"

class Pekerjaan(BaseModel):
    pekerjaan: Optional[str] = '0' #Mapping
    jabatan_pekerjaan: Optional[str]
    sektor_ekonomi: Optional[str] = '0' #Mapping
    kode_area_1: Optional[str] = '000'
    tlp_1: Optional[str]
    kode_area_2: Optional[str] = '000'
    tlp_2: Optional[str]
    status_pep: Optional[str] = 'F' #Mapping
    detail_pep: Optional[str] = '0' #Mapping
    status_keterkaitan_pep: Optional[str] = 'F' #Mapping
    detail_keterkaitan_pep: Optional[str] = '0' #Mapping
    nama_perusahaan: Optional[str]
    badan_hukum: Optional[str] = '0' #Mapping
    alamat: Optional[str]
    provinsi: Optional[str]
    kota_kab: Optional[str]
    kecamatan: Optional[str]
    keluarahan: Optional[str]
    rt: Optional[str]
    rw: Optional[str]
    kode_pos: Optional[str]

class Usaha(BaseModel):
    kegiatan_usaha: Optional[str] = '0' #Mapping
    bidang_usaha: Optional[str] = '0' #Mapping
    lokasi_usaha: Optional[str] = '0' #Mapping

class AlamatIdentitas(BaseModel):
    alamat: Optional[str]
    provinsi: Optional[str]
    kota_kab: Optional[str]
    kecamatan: Optional[str]
    keluarahan: Optional[str]
    rt: Optional[str]
    rw: Optional[str]
    kode_pos: Optional[str]
    kode_area_1: Optional[str] = '000'
    tlp_1: Optional[str]
    kode_area_2: Optional[str] = '000'
    tlp_2: Optional[str]
    kode_area_fax: Optional[str] = '000'
    fax: Optional[str]
    no_hp: Optional[str]

class AlamatDomisili(BaseModel):
    alamat: Optional[str]
    provinsi: Optional[str]
    kota_kab: Optional[str]
    kecamatan: Optional[str]
    keluarahan: Optional[str]
    rt: Optional[str]
    rw: Optional[str]
    kode_pos: Optional[str]
    status_tempat_tinggal: Optional[str] #Mapping
    lama_tahun_menempati_rumah: Optional[int] = 0
    lama_bulan_menempati_rumah: Optional[int] = 0

class DataTambahan(BaseModel):
    keluarga_dpt_dihubungi: Optional[str]
    hp_keluarga_dpt_dihubungi: Optional[str]
    penghasilan_utama_pertahun: Optional[str] = '0' #Mapping
    tujuan_penggunaan_dana: Optional[str] = '1' #Mapping
    golongan_nasabah: Optional[str] = '7359' #Mapping
    golongan_debitur: Optional[str] = '0' #Mapping
    golongan_pemilik_xlbrl: Optional[str] = '0' #Mapping
    buka_rek_untuk_gaji: Optional[str] = 'F' #Mapping
    buka_rek_untuk_program_pemerintah: Optional[str] = 'F' #Mapping

class Pajak(BaseModel):
    status_kena_pajak: Optional[str] = 'F' #Mapping
    keterangan_bebas_pajak: Optional[str]
    nomor_surat: Optional[str]
    tgl_terbit: Optional[str] = "dd-mm-yyyy"
    tgl_berakhir: Optional[str] = "dd-mm-yyyy"    

class LimitTransaksi(BaseModel):
    nominal_setor_tunai: Optional[int] = 0
    frek_setor_tunai: Optional[int] = 0
    nominal_setor_non_tunai: Optional[int] = 0
    frek_setor_non_tunai: Optional[int] = 0
    nominal_tarik_tunai: Optional[int] = 0
    frek_tarik_tunai: Optional[int] = 0
    nominal_tarik_non_tunai: Optional[int] = 0
    frek_tarik_non_tunai: Optional[int] = 0

class ItemFaktorResiko(BaseModel):
    item: str #Mapping
    tingkat_resiko: str = 'L' #Mapping

class FaktorResiko(BaseModel):
    status_resiko: Optional[str] = 'L' #Mapping
    item_faktor_resiko: Optional[List[ItemFaktorResiko]] = Field(alias='item_faktor_resiko')

class RekeningBankLain(BaseModel):
    jenis_rekening: Optional[str] #Mapping
    nomor_rekening: Optional[str]
    kode_valuta: Optional[str] #Mapping
    sandi_bank: Optional[str] #Mapping
    tgl_pembukaan: Optional[str] = "dd-mm-yyyy"
    keterangan: Optional[str]

class RelasiNasabah(BaseModel):
    tipe_relasi: Optional[str] #Mapping
    jabatan: Optional[str]
    nomor_nasabah_relasi: Optional[str]

class AhliWaris(BaseModel):
    no_urut_prioritas: Optional[int]
    nama_lengkap: Optional[str]
    jenis_kelamin: Optional[str] #Mapping
    hubungan_keluarga: Optional[str] #Mapping
    keterangan: Optional[str]

class BeneficiaryOwner(BaseModel):
    # #beneficiary owner
    beneficiaryownertype: Optional[str] #Mapping
    nama_lengkap: Optional[str]
    tempat_lahir: Optional[str]
    tanggal_lahir: Optional[str] = "dd-mm-yyyy"
    jenis_kelamin: Optional[str] #Mapping
    agama: Optional[str] #Mapping
    telepon_kode_area: Optional[str] = '000'
    telepon_nomor: Optional[str]
    hp_nomor: Optional[str]
    alamat_identitas_jalan: Optional[str]
    alamat_identitas_kecamatan: Optional[str]
    alamat_identitas_kelurahan: Optional[str]
    alamat_identitas_kode_pos: Optional[str]
    alamat_identitas_kota_kabupaten: Optional[str]
    alamat_identitas_provinsi: Optional[str]
    alamat_identitas_rt: Optional[str]
    alamat_identitas_rw: Optional[str]
    alamat_domisili_jalan: Optional[str]
    alamat_domisili_kecamatan: Optional[str]
    alamat_domisili_kelurahan: Optional[str]
    alamat_domisili_kode_pos: Optional[str]
    alamat_domisili_kota_kabupaten: Optional[str]
    alamat_domisili_provinsi: Optional[str]
    alamat_domisili_rt: Optional[str]
    alamat_domisili_rw: Optional[str]

class NasabahIndividuReq(BaseModel):
    kode_cabang: str = '001'
    identitas: Optional[Identitas] = Field(alias='identitas')
    alamat_identitas: Optional[AlamatIdentitas] = Field(alias='alamat_identitas')
    alamat_domisili: Optional[AlamatDomisili] = Field(alias='alamat_domisili')
    pekerjaan: Optional[Pekerjaan] = Field(alias='pekerjaan')
    usaha: Optional[Usaha] = Field(alias='usaha')
    data_tambahan: Optional[DataTambahan] = Field(alias='data_tambahan')
    limit_transaksi: Optional[LimitTransaksi] = Field(alias='limit_transaksi')
    faktor_resiko: Optional[FaktorResiko] = Field(alias='faktor_resiko')
    pajak: Optional[Pajak] = Field(alias='pajak')
    rekening_bank_lain: Optional[List[RekeningBankLain]] = Field(alias='rekening_bank_lain')
    relasi_nasabah: Optional[List[RelasiNasabah]] = Field(alias='relasi_nasabah')
    ahli_waris: Optional[List[AhliWaris]] = Field(alias='ahli_waris')
    beneficiary_owner: Optional[List[BeneficiaryOwner]] = Field(alias='beneficiary_owner')

class NasabahIndividuReqDet(NasabahIndividuReq):
    identitas: Optional[IdentitasDet] = Field(alias='identitas')

class NasabahIndividuUbahReq(NasabahIndividuReq):
    nomor_nasabah: str
    kode_cabang: Optional[str]

class NasabahIndividuResp(BaseModel):
    nomor_nasabah: str = None
    nama_nasabah: str = None

class NasabahIndividuDetResp(NasabahIndividuReqDet):
    nomor_nasabah: str = None
    nama_nasabah: str = None

class NasabahIndividu(BaseModel):
    nomor_nasabah: str = None
    nama_nasabah: str = None

class NasabahIndividuCreate(NasabahIndividu):
    pass

class NasabahIndividuCheck(NasabahIndividu):
    pass