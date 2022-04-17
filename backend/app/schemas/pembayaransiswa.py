from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class PembayaranSiswa(BaseModel):
    id_siswa: Optional[StrictInt]
    nominal_pembayaran: Optional[StrictInt]
    status_pembayaran: Optional[str]
    id_jenispembayaran: Optional[StrictInt]