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
    nama_aset: Optional[str]
    luas_lahan: Optional[StrictInt]
    luas_bangunan: Optional[StrictInt]
    nama_pemilik: Optional[str]
    no_sertifikat: Optional[str]

class SuratKeterangan(BaseModel):
    nomor_surat_operasional: Optional[str]
    tanggal_surat_operasional: Optional[str]
    nomor_surat_kemenkumham: Optional[str]
    tanggal_surat_kemenkumham: Optional[str]