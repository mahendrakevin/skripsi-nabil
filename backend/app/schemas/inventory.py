from pydantic import BaseModel, StrictInt
from typing import Optional, List
from pydantic.fields import Field

class DataInventory(BaseModel):
    nama_barang: Optional[str] = None
    nomor_seri: Optional[StrictInt] = None
    id_kategori_barang: Optional[StrictInt] = None
    jumlah_barang: Optional[StrictInt] = None
    tanggal_pembelian: Optional[str] = None
    harga_barang: Optional[StrictInt] = None
    id_jenis_inventaris: Optional[StrictInt] = None
    keterangan: Optional[str] = None
    lampiran: Optional[str] = None

class KategoriBarang(BaseModel):
    nama_kategori: Optional[str]

class JenisInventaris(BaseModel):
    nama_jenis_inventaris: Optional[str]