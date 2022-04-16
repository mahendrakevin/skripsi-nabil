from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import guru_crud
from schemas import DataGuru, DataKepegawaian, Jabatan
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await guru_crud.get_list_guru(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_guru}")
async def detail(id_guru: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.get_detail_guru(db_session=db_session, id_guru=id_guru)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataGuru, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.add_guru(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_guru: int, request: DataGuru, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.edit_guru(id_guru=id_guru, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_guru}")
async def hapus(id_guru: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.delete_guru(id_guru=id_guru, db_session=db_session)
    response.update(resp)
    return response

# Kepegawaian

@router.get("/kepegawaian/")
async def list_kepegawaian(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10, id_guru: int=None):
    result = await guru_crud.get_list_kepegawaian(db_session=db_session, page=page, show=show, id_guru=id_guru)
    return result

@router.get("/kepegawaian/{id_guru}")
async def detail_kepegawaian_id_guru(id_guru: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.get_detail_kepegawaian_id_guru(db_session=db_session, id_guru=id_guru)
    response.update(resp)
    return response

@router.get("/kepegawaian/detail/{id_kepegawaian}")
async def detail_kepegawaian(id_kepegawaian: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.get_detail_kepegawaian(db_session=db_session, id_kepegawaian=id_kepegawaian)
    response.update(resp)
    return response

@router.post("/kepegawaian/tambah")
async def add_kepegawaian(request: DataKepegawaian, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.add_kepegawaian(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/kepegawaian/edit")
async def edit_kepegawaian_id_guru(id_guru: int, request: DataKepegawaian, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.edit_kepegawaian_id_guru(id_guru=id_guru, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/kepegawaian/pegawai/edit")
async def edit_kepegawaian(id_kepegawaian: int, request: DataKepegawaian, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.edit_kepegawaian(id_kepegawaian=id_kepegawaian, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/kepegawaian/hapus/{id_guru}")
async def hapus_kepegawaian_id_guru(id_guru: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.delete_kepegawaian_id_guru(id_guru=id_guru, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/kepegawaian/hapus/pegawai/{id_kepegawaian}")
async def hapus_kepegawaian(id_kepegawaian: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.delete_kepegawaian(id_kepegawaian=id_kepegawaian, db_session=db_session)
    response.update(resp)
    return response

# Jabatan

@router.get("/jabatan/")
async def list_jabatan(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.get_list_jabatan(db_session=db_session, page=page, show=show)
    response.update(resp)
    return response

@router.get("/jabatan/{id_jabatan}")
async def detail_jabatan(id_jabatan: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.get_detail_jabatan(db_session=db_session, id_jabatan=id_jabatan)
    response.update(resp)
    return response

@router.post("/jabatan/tambah")
async def add_jabatan(request: Jabatan, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.add_jabatan(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/jabatan/edit")
async def edit_jabatan(id_jabatan: int, request: Jabatan, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.edit_jabatan(id_jabatan=id_jabatan, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/jabatan/hapus/{id_jabatan}")
async def hapus_jabatan(id_jabatan: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await guru_crud.delete_jabatan(id_jabatan=id_jabatan, db_session=db_session)
    response.update(resp)
    return response

