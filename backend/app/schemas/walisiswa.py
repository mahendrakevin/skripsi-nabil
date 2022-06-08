from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class WaliSiswa(BaseModel):
    nama_ayah: Optional[str]
    file_kk_ayah: Optional[str] = 'string'
    tempat_lahir_ayah: Optional[str]
    tanggal_lahir_ayah: Optional[str]
    alamat_ayah: Optional[str]
    status_keluarga_ayah: Optional[str]
    status_hidup_ayah: Optional[str]
    no_hp_ayah: Optional[StrictInt]
    pendidikan_ayah: Optional[str]
    pekerjaan_ayah: Optional[str]
    penghasilan_ayah: Optional[StrictInt]
    nomor_kks_ayah: Optional[StrictInt]
    nomor_pkh_ayah: Optional[StrictInt]
    nama_ibu: Optional[str]
    file_kk_ibu: Optional[str] = 'string'
    tempat_lahir_ibu: Optional[str]
    tanggal_lahir_ibu: Optional[str]
    alamat_ibu: Optional[str]
    status_keluarga_ibu: Optional[str]
    status_hidup_ibu: Optional[str]
    no_hp_ibu: Optional[StrictInt]
    pendidikan_ibu: Optional[str]
    pekerjaan_ibu: Optional[str]
    penghasilan_ibu: Optional[StrictInt]
    nomor_kks_ibu: Optional[StrictInt]
    nomor_pkh_ibu: Optional[StrictInt]
    nama_wali: Optional[str] = '-'
    tempat_lahir_wali: Optional[str] = '2000-01-01'
    tanggal_lahir_wali: Optional[str] = '-'
    alamat_wali: Optional[str] = '-'
    no_hp_wali: Optional[StrictInt] = 0
    pendidikan_wali: Optional[str] = '-'
    pekerjaan_wali: Optional[str] = '-'
    penghasilan_wali: Optional[StrictInt]
    nomor_kks_wali: Optional[StrictInt]
    nomor_pkh_wali: Optional[StrictInt]
    id_siswa: Optional[StrictInt]

class JenisWali(BaseModel):
    jenis_wali: Optional[str]

class LaporanPembayaran(BaseModel):
    id_jenispembayaran: Optional[StrictInt]
    id_statuspembayaran: Optional[StrictInt]

class JenisPembayaran(BaseModel):
    jenis_pembayaran: Optional[str]
    nominal_pembayaran: Optional[StrictInt]