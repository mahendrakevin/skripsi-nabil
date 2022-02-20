from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class WaliSiswa(BaseModel):
    nama_ayah: Optional[str]
    file_kk: Optional[str]
    tempat_lahir_ayah: Optional[str]
    tanggal_lahir_ayah: Optional[str]
    alamat_ayah: Optional[str]
    no_hp_ayah: Optional[StrictInt]
    pendidikan_ayah: Optional[str]
    pekerjaan_ayah: Optional[str]
    penghasilan_ayah: Optional[StrictInt]
    nomor_kks_ayah: Optional[StrictInt]
    nomor_pkh_ayah: Optional[StrictInt]
    nama_ibu: Optional[str]
    tempat_lahir_ibu: Optional[str]
    tanggal_lahir_ibu: Optional[str]
    alamat_ibu: Optional[str]
    no_hp_ibu: Optional[StrictInt]
    pendidikan_ibu: Optional[str]
    pekerjaan_ibu: Optional[str]
    penghasilan_ibu: Optional[StrictInt]
    nomor_kks_ibu: Optional[StrictInt]
    nomor_pkh_ibu: Optional[StrictInt]
    id_siswa: Optional[StrictInt]

class JenisWali(BaseModel):
    jenis_wali: Optional[str]

class LaporanPembayaran(BaseModel):
    id_jenispembayaran: Optional[StrictInt]
    status_pembayaran: Optional[str]

class JenisPembayaran(BaseModel):
    jenis_pembayaran: Optional[str]
    nominal_pembayaran: Optional[StrictInt]