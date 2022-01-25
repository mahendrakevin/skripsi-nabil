from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataGuru(BaseModel):
    nip: Optional[StrictInt] = 1828112
    nuptk: Optional[StrictInt] = 1828112
    nik: Optional[StrictInt] = 1234567890
    nama_guru: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = 'yyyy-mm-dd'
    jenis_kelamin: Optional[str] = 'Pria'
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_hp: Optional[StrictInt] = 628123456678
    email: Optional[str] = 'email@email.com'
    status_perkawinan: Optional[str] = 'Menikah'

class EditDataGuru(BaseModel):
    nip: Optional[StrictInt] = 1828112
    nuptk: Optional[StrictInt] = 1828112
    nik: Optional[StrictInt] = 1234567890
    nama_guru: Optional[str] = 'Wahyu'
    tempat_lahir: Optional[str] = 'Semarang'
    tanggal_lahir: Optional[str] = 'yyyy-mm-dd'
    jenis_kelamin: Optional[str] = 'Pria'
    alamat: Optional[str] = 'Jl Wahyurejo'
    nomor_hp: Optional[StrictInt] = 628123456678
    email: Optional[str] = 'email@email.com'
    status_perkawinan: Optional[str] = 'Menikah'