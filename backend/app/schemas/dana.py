from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class SumberDana(BaseModel):
    nama_dana: Optional[str]

class JenisPengeluaran(BaseModel):
    jenis_pengeluaran: Optional[str]

class DanaMasuk(BaseModel):
    tanggal: Optional[str]
    id_sumberdana: Optional[StrictInt]
    nominal_dana: Optional[StrictInt]
    lampiran: Optional[str]

class DanaKeluar(BaseModel):
    tanggal: Optional[str]
    detail_pengeluaran: Optional[str]
    id_jenispengeluaran: Optional[StrictInt]
    diserahkan_kepada: Optional[str]
    dikeluarkan_oleh: Optional[str]
    bukti_pengeluaran: Optional[str]
    nominal_pengeluaran: Optional[StrictInt]