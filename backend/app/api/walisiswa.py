from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import walisiswa_crud
from schemas import WaliSiswa, JenisWali, LaporanPembayaran, JenisPembayaran
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await walisiswa_crud.get_list_walisiswa(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_siswa}")
async def detail(id_siswa: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.get_detail_walisiswa(db_session=db_session, id_siswa=id_siswa)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: WaliSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.add_walisiswa(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_siswa: int, request: WaliSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.edit_walisiswa(id_siswa=id_siswa, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_siswa}")
async def hapus(id_siswa: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.delete_walisiswa(id_siswa=id_siswa, db_session=db_session)
    response.update(resp)
    return response

# Jenis Wali

@router.get("/jeniswali/")
async def list_jeniswali(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await walisiswa_crud.get_list_jeniswali(db_session=db_session, page=page, show=show)
    return result

@router.get("/jeniswali/{id_jeniswali}")
async def detail_jeniswali(id_jeniswali: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.get_detail_jeniswali(db_session=db_session, id_jeniswali=id_jeniswali)
    response.update(resp)
    return response

@router.post("/jeniswali/tambah")
async def add_jeniswali(request: JenisWali, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.add_jeniswali(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/jeniswali/edit")
async def edit_jeniswali(id_jeniswali: int, request: JenisWali, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.edit_jeniswali(id_jeniswali=id_jeniswali, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/jeniswali/hapus/{id_jeniswali}")
async def hapus_jeniswali(id_jeniswali: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.delete_jeniswali(id_jeniswali=id_jeniswali, db_session=db_session)
    response.update(resp)
    return response

# Laporan Pembayaran

@router.get("/laporanpembayaran/")
async def list_laporanpembayaran(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await walisiswa_crud.get_list_laporanpembayaran(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_laporanpembayaran}")
async def detail(id_laporanpembayaran: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.get_detail_laporanpembayaran(db_session=db_session, id_laporanpembayaran=id_laporanpembayaran)
    response.update(resp)
    return response

@router.post("/laporanpembayaran/tambah")
async def add_laporanpembayaran(request: LaporanPembayaran, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.add_laporanpembayaran(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/laporanpembayaran/edit")
async def edit_laporanpembayaran(id_laporanpembayaran: int, request: LaporanPembayaran, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.edit_laporanpembayaran(id_laporanpembayaran=id_laporanpembayaran, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/laporanpembayaran/hapus/{id_laporanpembayaran}")
async def hapus_laporanpembayaran(id_laporanpembayaran: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await walisiswa_crud.delete_laporanpembayaran(id_laporanpembayaran=id_laporanpembayaran, db_session=db_session)
    response.update(resp)
    return response
