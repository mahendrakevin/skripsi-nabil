from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataSiswa(BaseModel):
    nisn: Optional[StrictInt] = 1828112
    nis: Optional[StrictInt] = 7077
    nama_siswa: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = '2015-01-22'
    jenis_kelamin: Optional[str] = 'Pria'
    nik: Optional[StrictInt] = 1234567890
    id_kelas: Optional[StrictInt] = 1
    status_siswa: Optional[str] = 'Aktif'
    nomor_kip: Optional[StrictInt] = 123456789
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_kk: Optional[StrictInt] = 123456789
    file_kk: Optional[str] = 'string'
    nomor_kks: Optional[StrictInt] = 0
    nomor_pkh: Optional[StrictInt] = 0
    jeniswali: Optional[str] = 'Ayah'
    current_state: Optional[str] = ''

class SiswaNaik(BaseModel):
    id_kelas: Optional[StrictInt] = 0
    daftar_siswa: Optional[List]

class SiswaLulus(BaseModel):
    daftar_siswa: Optional[List]

class EditDataSiswa(BaseModel):
    nisn: Optional[StrictInt] = 1828112
    nis: Optional[StrictInt] = 7077
    nama_siswa: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = '2015-01-22'
    jenis_kelamin: Optional[str] = 'Pria'
    nik: Optional[StrictInt] = 1234567890
    id_kelas: Optional[StrictInt] = 1
    status_siswa: Optional[str] = 'Aktif'
    nomor_kip: Optional[StrictInt] = 123456789
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_kk: Optional[StrictInt] = 123456789
    jeniswali: Optional[str] = 'Ayah'
    nomor_kks: Optional[StrictInt] = 0
    nomor_pkh: Optional[StrictInt] = 0
    current_state: Optional[str] = ''

class PendaftaranSiswa(BaseModel):
    nisn: Optional[StrictInt]
    nama_siswa: Optional[str]
    tempat_lahir: Optional[str]
    tanggal_lahir: Optional[str]
    jenis_kelamin: Optional[str]
    nik: Optional[StrictInt]
    nomor_kip: Optional[StrictInt]
    alamat: Optional[str]
    nomor_kk: Optional[StrictInt]
    nama_kepalakeluarga: Optional[str]
    status_siswa: Optional[str]
    id_pembayaran: Optional[StrictInt]