from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataLembaga(BaseModel):
    nama_lembaga: Optional[str]
    tahun_berdiri: Optional[str]
    no_telp: Optional[str]
    alamat: Optional[str]
    email: Optional[str]
    npsn: Optional[StrictInt]
    nsm: Optional[StrictInt]

class SaranaPrasarana(BaseModel):
    id_lembaga: Optional[StrictInt]
    luas_lahan: Optional[StrictInt]
    luas_bangunan: Optional[StrictInt]
    nama_pemilik: Optional[str]
    no_sertifikat: Optional[str]

class SuratKeterangan(BaseModel):
    id_lembaga: Optional[StrictInt]
    nama_surat_keterangan: Optional[str]
    nomor_surat_keterangan: Optional[str]
    tanggal_surat_keterangan: Optional[str]