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
    result = await arsipsurat_crud.get_list_surat(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_surat}")
async def detail(id_surat: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await arsipsurat_crud.get_detail_surat(db_session=db_session, id_surat=id_surat)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: ArsipSurat, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    result = await arsipsurat_crud.add_surat(request=request, db_session=db_session)
    if result["status"] == "00":
        return JSONResponse(result, status_code=status.HTTP_200_OK)
    else:
        return JSONResponse(result, status_code=status.HTTP_400_BAD_REQUEST)

@router.put("/edit")
async def edit(id_surat: int, request: ArsipSurat, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await arsipsurat_crud.edit_surat(id_surat=id_surat, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_surat}")
async def hapus(id_surat: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await arsipsurat_crud.delete_surat(id_surat=id_surat, db_session=db_session)
    response.update(resp)
    return response

