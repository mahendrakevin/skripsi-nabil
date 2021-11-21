from pydantic import BaseModel
from typing import Optional, List
from pydantic.fields import Field

class TransaksiBelumOtorisasi(BaseModel):
    account_number: str
    reference_number: str
    amount: float

class DetilTrx(BaseModel):
    nomor_rekening: str = '001102000133'
    jenis_mutasi: str = 'D'
    nilai_mutasi: float = 1.0
    jenis_detil_transaksi: str = '002' # 002 liability, 004 teller
    nilai_kurs_manual: int = 1 # 1 for idr
    keterangan: Optional[str] = 'keterangan detil'

class TransferInfo(BaseModel):
    jenis_transfer: str = 'S' #S SKN, R RTGS
    kode_bank: str = '014'
    nama_penerima: str = 'penerima'
    nama_pengirim: str = 'pengirim'
    nomor_rekening_penerima: str = 'penerima'
    nomor_rekening_pengirim: str = 'pengirim'
    jenis_penduduk: str = '1' #1 penduduk, 2 bukan penduduk


class Transaksi(BaseModel):
    kode_transaksi: str = 'CWD'
    keterangan: str = 'Keterangan'
    nomor_referensi: str = 'nomor_referensi'
    kode_cabang_transaksi: str = '001'
    user_input: str = 'SYSTEM'
    user_otorisasi: str = 'SYSTEM'
    detiltransaksi: Optional[List[DetilTrx]] = Field(alias='detiltransaksi')
    #transferinfo: Optional[TransferInfo] = Field(alias='transferinfo')