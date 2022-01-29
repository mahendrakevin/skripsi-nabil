from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class ArsipSurat(BaseModel):
    nama_surat: Optional[str]
    nomor_surat: Optional[str]
    tanggal_surat: Optional[str]
    jenis_surat: Optional[str]
    keterangan: Optional[str]
    lampiran: Optional[str]