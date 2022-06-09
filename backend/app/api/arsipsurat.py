from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import arsipsurat_crud
from schemas import ArsipSurat
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await arsipsurat_crud.get_list_arsipsurat(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_arsipsurat}")
async def detail(id_arsipsurat: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Sukses", "message_id": "00"}
    resp = await arsipsurat_crud.get_detail_arsipsurat(db_session=db_session, id_arsipsurat=id_arsipsurat)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: ArsipSurat, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Sukses", "message_id": "00"}
    resp = await arsipsurat_crud.add_arsipsurat(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_arsipsurat: int, request: ArsipSurat, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Sukses", "message_id": "00"}
    resp = await arsipsurat_crud.edit_arsipsurat(id_arsipsurat=id_arsipsurat, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_arsipsurat}")
async def hapus(id_arsipsurat: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Sukses", "message_id": "00"}
    resp = await arsipsurat_crud.delete_arsipsurat(id_arsipsurat=id_arsipsurat, db_session=db_session)
    response.update(resp)
    return response