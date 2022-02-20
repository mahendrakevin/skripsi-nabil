from sys import prefix
from fastapi import APIRouter
from api import siswa, guru, dana, inventory, kelas, pembayaransiswa, walisiswa, lembaga, arsipsurat

api_router = APIRouter()

api_router.include_router(siswa.router, prefix="/siswa", tags=["Data Siswa"])
api_router.include_router(guru.router, prefix="/guru", tags=["Data Guru"])
api_router.include_router(walisiswa.router, prefix="/walisiswa", tags=["Data Wali Siswa"])
api_router.include_router(kelas.router, prefix="/kelas", tags=["Data Kelas"])
api_router.include_router(lembaga.router, prefix="/lembaga", tags=["Data Lembaga"])
api_router.include_router(inventory.router, prefix="/inventory", tags=["Data Inventory"])
api_router.include_router(dana.router, prefix="/dana", tags=["Data Alokasi Dana"])
api_router.include_router(pembayaransiswa.router, prefix="/pembayaransiswa", tags=["Data Pembayaran Siswa"])
api_router.include_router(arsipsurat.router, prefix="/arsipsurat", tags=["Data Arsip Surat"])
