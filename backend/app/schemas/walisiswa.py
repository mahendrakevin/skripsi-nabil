from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class WaliSiswa(BaseModel):
    id_jeniswali: Optional[StrictInt]
    nama_wali: Optional[str]
    file_kk: Optional[str]
    tempat_lahir: Optional[str]
    tanggal_lahir: Optional[str]
    alamat: Optional[str]
    no_hp: Optional[StrictInt]
    pendidikan: Optional[str]
    pekerjaan: Optional[str]
    penghasilan: Optional[StrictInt]
    nomor_kks: Optional[StrictInt]
    nomor_pkh: Optional[StrictInt]
    id_siswa: Optional[StrictInt]

class JenisWali(BaseModel):
    jenis_wali: Optional[str]

class LaporanPembayaran(BaseModel):
    id_jenispembayaran: Optional[StrictInt]
    status_pembayaran: Optional[str]

class JenisPembayaran(BaseModel):
    jenis_pembayaran: Optional[str]
    nominal_pembayaran: Optional[StrictInt]