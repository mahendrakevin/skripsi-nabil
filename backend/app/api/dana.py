from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import siswa_crud
from schemas import DataSiswa, EditDataSiswa
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await siswa_crud.get_list_siswa(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_dana}")
async def detail(id_siswa: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.get_detail_siswa(db_session=db_session, id_siswa=id_siswa)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    result = await siswa_crud.add_siswa(request=request, db_session=db_session)
    if result["status"] == "00":
        return JSONResponse(result, status_code=status.HTTP_200_OK)
    else:
        return JSONResponse(result, status_code=status.HTTP_400_BAD_REQUEST)

@router.put("/edit")
async def edit(id_siswa: int, request: EditDataSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.edit_siswa(id_siswa=id_siswa, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_siswa}")
async def hapus(id_siswa: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.delete_siswa(id_siswa=id_siswa, db_session=db_session)
    response.update(resp)
    return response

