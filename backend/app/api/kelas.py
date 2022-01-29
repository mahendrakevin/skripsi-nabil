from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import kelas_crud
from schemas import DataKelas
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await kelas_crud.get_list_kelas(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_kelas}")
async def detail(id_kelas: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await kelas_crud.get_detail_kelas(db_session=db_session, id_kelas=id_kelas)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataKelas, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await kelas_crud.add_kelas(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_kelas: int, request: DataKelas, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await kelas_crud.edit_kelas(id_kelas=id_kelas, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_kelas}")
async def hapus(id_kelas: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await kelas_crud.delete_kelas(id_kelas=id_kelas, db_session=db_session)
    response.update(resp)
    return response