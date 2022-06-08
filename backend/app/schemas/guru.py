from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataGuru(BaseModel):
    nip: Optional[StrictInt] = 1828112
    nuptk: Optional[StrictInt] = 1828112
    nik: Optional[StrictInt] = 1234567890
    nama_guru: Optional[str] = 'Annisa'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = '1999-01-22'
    jenis_kelamin: Optional[str] = 'Pria'
    alamat: Optional[str] = 'Jl Wahyurejo'
    no_hp: Optional[StrictInt] = 628123456678
    email: Optional[str] = 'email@email.com'
    status_perkawinan: Optional[str] = 'Menikah'
    status_pegawai: Optional[str] = 'Aktif'

class DataKepegawaian(BaseModel):
    id_guru: Optional[StrictInt] = 1
    no_sk: Optional[str] = 123415516
    kategori_sk: Optional[str] = 'SK YPMNU'
    tanggal: Optional[str] = '2022-03-01'
    jabatan: Optional[str] = 'Guru'
    isSKPengangkatan: Optional[bool] = False

class EditKepegawaian(BaseModel):
    no_sk: Optional[str] = 123415516
    no_sk_ypmnu: Optional[str] = 1241515
    no_sk_operator: Optional[str] = 12545636
    jabatan: Optional[str]
    status_kepegawaian: Optional[str] = 'Aktif'
    alasan_tidak_aktif: Optional[str] = None
    surat_mutasi: Optional[str] = None
    jumlah_ajar: Optional[StrictInt] = None

class Jabatan(BaseModel):
    nama_jabatan: Optional[str] = 'Kepala Sekolah'