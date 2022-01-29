from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataKelas(BaseModel):
    nama_kelas: Optional[str]
    kapasitas_kelas: Optional[StrictInt]