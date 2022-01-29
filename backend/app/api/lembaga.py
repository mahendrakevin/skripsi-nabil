from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import lembaga_crud
from schemas import DataLembaga, SaranaPrasarana, SuratKeterangan
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await lembaga_crud.get_list_lembaga(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_lembaga}")
async def detail(id_lembaga: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.get_detail_lembaga(db_session=db_session, id_lembaga=id_lembaga)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataLembaga, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.add_lembaga(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_lembaga: int, request: DataLembaga, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.edit_lembaga(id_lembaga=id_lembaga, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_lembaga}")
async def hapus(id_lembaga: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.delete_lembaga(id_lembaga=id_lembaga, db_session=db_session)
    response.update(resp)
    return response

# Sarana Prasarana

@router.get("/sarpras/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await lembaga_crud.get_list_sarpras(db_session=db_session, page=page, show=show)
    return result

@router.get("/sarpras/{id_sarpras}")
async def detail(id_sarpras: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.get_detail_sarpras(db_session=db_session, id_sarpras=id_sarpras)
    response.update(resp)
    return response

@router.post("/sarpras/tambah")
async def add(request: SaranaPrasarana, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.add_sarpras(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/sarpras/edit")
async def edit(id_sarpras: int, request: SaranaPrasarana, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.edit_sarpras(id_sarpras=id_sarpras, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/sarpras/hapus/{id_sarpras}")
async def hapus(id_sarpras: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.delete_sarpras(id_sarpras=id_sarpras, db_session=db_session)
    response.update(resp)
    return response

# Surat Keterangan

@router.get("/suratketerangan/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await lembaga_crud.get_list_suratketerangan(db_session=db_session, page=page, show=show)
    return result

@router.get("/suratketerangan/{id_suratketerangan}")
async def detail(id_suratketerangan: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.get_detail_suratketerangan(db_session=db_session, id_suratketerangan=id_suratketerangan)
    response.update(resp)
    return response

@router.post("/suratketerangan/tambah")
async def add(request: SuratKeterangan, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.add_suratketerangan(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/suratketerangan/edit")
async def edit(id_suratketerangan: int, request: SuratKeterangan, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.edit_suratketerangan(id_suratketerangan=id_suratketerangan, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/suratketerangan/hapus/{id_suratketerangan}")
async def hapus(id_suratketerangan: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await lembaga_crud.delete_suratketerangan(id_suratketerangan=id_suratketerangan, db_session=db_session)
    response.update(resp)
    return response
