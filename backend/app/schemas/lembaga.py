from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataLembaga(BaseModel):
    nama_lembaga: Optional[str]
    akreditasi: Optional[str]
    tahun_berdiri: Optional[str]
    no_telp: Optional[str]
    alamat: Optional[str]
    email: Optional[str]
    npsn: Optional[StrictInt]
    nsm: Optional[StrictInt]

class SaranaPrasarana(BaseModel):
    nama_lahan: Optional[str]
    luas_lahan: Optional[StrictInt]
    luas_bangunan: Optional[StrictInt]
    jumlah_lantai: Optional[str]
    tahun: Optional[str]
    alamat: Optional[str]

class Aset(BaseModel):
    jenis_ruangan: Optional[str]
    nama_ruangan: Optional[str]
    tahun: Optional[StrictInt]
    panjang: Optional[StrictInt]
    lebar: Optional[StrictInt]

class SuratKeterangan(BaseModel):
    nomor_surat_operasional: Optional[str]
    tanggal_surat_operasional: Optional[str]
    nomor_surat_kemenkumham: Optional[str]
    tanggal_surat_kemenkumham: Optional[str]