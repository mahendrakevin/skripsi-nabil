from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import pembayaransiswa_crud
from schemas import PembayaranSiswa
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await pembayaransiswa_crud.get_list_pembayaransiswa(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_pembayaransiswa}")
async def detail(id_pembayaransiswa: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await pembayaransiswa_crud.get_detail_pembayaransiswa(db_session=db_session, id_pembayaransiswa=id_pembayaransiswa)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: PembayaranSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await pembayaransiswa_crud.add_pembayaransiswa(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_pembayaransiswa: int, request: PembayaranSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await pembayaransiswa_crud.edit_pembayaransiswa(id_pembayaransiswa=id_pembayaransiswa, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_pembayaransiswa}")
async def hapus(id_pembayaransiswa: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await pembayaransiswa_crud.delete_pembayaransiswa(id_pembayaransiswa=id_pembayaransiswa, db_session=db_session)
    response.update(resp)
    return response