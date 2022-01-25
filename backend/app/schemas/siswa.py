from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataSiswa(BaseModel):
    nisn: Optional[StrictInt] = 1828112
    nama_siswa: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = 'yyyy-mm-dd'
    jenis_kelamin: Optional[str] = 'Pria'
    nik: Optional[StrictInt] = 1234567890
    id_kelas: Optional[StrictInt] = 1
    status_siswa: Optional[str] = 'Aktif'
    nomor_kip: Optional[StrictInt] = 123456789
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_kk: Optional[StrictInt] = 123456789
    nama_kepalakeluarga: Optional[str] = 'Test'

class EditDataSiswa(BaseModel):
    nisn: Optional[StrictInt] = 1828112
    nama_siswa: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = 'yyyy-mm-dd'
    jenis_kelamin: Optional[str] = 'Pria'
    nik: Optional[StrictInt] = 1234567890
    id_kelas: Optional[StrictInt] = 1
    status_siswa: Optional[str] = 'Aktif'
    nomor_kip: Optional[StrictInt] = 123456789
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_kk: Optional[StrictInt] = 123456789
    nama_kepalakeluarga: Optional[str] = 'Test'