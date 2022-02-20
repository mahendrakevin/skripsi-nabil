from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import dana_crud
from schemas import DanaMasuk, DanaKeluar, SumberDana, JenisPengeluaran
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/masuk/")
async def list_danamasuk(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await dana_crud.get_list_danamasuk(db_session=db_session, page=page, show=show)
    return result

@router.get("/masuk/{id_dana}")
async def detail_danamasuk(id_danamasuk: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.get_detail_danamasuk(db_session=db_session, id_danamasuk=id_danamasuk)
    response.update(resp)
    return response

@router.post("/masuk/tambah")
async def add_danamasuk(request: DanaMasuk, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.add_danamasuk(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/masuk/edit")
async def edit_danamasuk(id_danamasuk: int, request: DanaMasuk, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.edit_danamasuk(id_danamasuk=id_danamasuk, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/masuk/hapus/{id_danamasuk}")
async def hapus_danamasuk(id_danamasuk: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.delete_danamasuk(id_danamasuk=id_danamasuk, db_session=db_session)
    response.update(resp)
    return response

## Dana Keluar

@router.get("/keluar/")
async def list_danakeluar(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await dana_crud.get_list_danakeluar(db_session=db_session, page=page, show=show)
    return result

@router.get("/keluar/{id_dana}")
async def detail_danakeluar(id_danakeluar: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.get_detail_danakeluar(db_session=db_session, id_danakeluar=id_danakeluar)
    response.update(resp)
    return response

@router.post("/keluar/tambah")
async def add_danakeluar(request: DanaKeluar, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.add_danakeluar(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/keluar/edit")
async def edit_danakeluar(id_danakeluar: int, request: DanaKeluar, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.edit_danakeluar(id_danakeluar=id_danakeluar, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/keluar/hapus/{id_danakeluar}")
async def hapus_danakeluar(id_danakeluar: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.delete_danakeluar(id_danakeluar=id_danakeluar, db_session=db_session)
    response.update(resp)
    return response

## Sumber Dana

@router.get("/sumberdana/")
async def list_sumberdana(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await dana_crud.get_list_sumberdana(db_session=db_session, page=page, show=show)
    return result

@router.get("/sumberdana/{id_dana}")
async def detail_sumberdana(id_sumberdana: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.get_detail_sumberdana(db_session=db_session, id_sumberdana=id_sumberdana)
    response.update(resp)
    return response

@router.post("/sumberdana/tambah")
async def add_sumberdana(request: SumberDana, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.add_sumberdana(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/sumberdana/edit")
async def edit_sumberdana(id_sumberdana: int, request: SumberDana, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.edit_sumberdana(id_sumberdana=id_sumberdana, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/sumberdana/hapus/{id_sumberdana}")
async def hapus_sumberdana(id_sumberdana: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.delete_sumberdana(id_sumberdana=id_sumberdana, db_session=db_session)
    response.update(resp)
    return response

## Jenis Pengeluaran

@router.get("/jenispengeluaran/")
async def list_jenispengeluaran(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await dana_crud.get_list_jenispengeluaran(db_session=db_session, page=page, show=show)
    return result

@router.get("/jenispengeluaran/{id_dana}")
async def detail_jenispengeluaran(id_jenispengeluaran: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.get_detail_jenispengeluaran(db_session=db_session, id_jenispengeluaran=id_jenispengeluaran)
    response.update(resp)
    return response

@router.post("/jenispengeluaran/tambah")
async def add_jenispengeluaran(request: JenisPengeluaran, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.add_jenispengeluaran(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/jenispengeluaran/edit")
async def edit_jenispengeluaran(id_jenispengeluaran: int, request: JenisPengeluaran, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.edit_jenispengeluaran(id_jenispengeluaran=id_jenispengeluaran, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/jenispengeluaran/hapus/{id_jenispengeluaran}")
async def hapus_jenispengeluaran(id_jenispengeluaran: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await dana_crud.delete_jenispengeluaran(id_jenispengeluaran=id_jenispengeluaran, db_session=db_session)
    response.update(resp)
    return response
