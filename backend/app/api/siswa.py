from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import siswa_crud
from schemas import DataSiswa, EditDataSiswa, PendaftaranSiswa, SiswaNaik, SiswaLulus
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await siswa_crud.get_list_siswa(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_siswa}")
async def detail(id_siswa: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.get_detail_siswa(db_session=db_session, id_siswa=id_siswa)
    response.update(resp)
    return response

@router.get("/kelas/{id_kelas}")
async def detail(id_kelas: int,  page: int=1, show: int=10, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.get_list_siswa_by_kelas(db_session=db_session, id_kelas=id_kelas, page=page, show=show)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.add_siswa(request=request, db_session=db_session)
    response.update(resp)
    return response

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

@router.get("/alumni/")
async def list_alumni(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await siswa_crud.get_list_siswa_alumni(db_session=db_session, page=page, show=show)
    return result

@router.post("/naik")
async def naik(request: SiswaNaik, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    # print(request)
    resp = await siswa_crud.siswa_naik(request=request, db_session=db_session)
    response.update(resp)
    return resp

@router.post("/lulus")
async def lulus(request: SiswaLulus, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    # print(request)
    resp = await siswa_crud.siswa_lulus(request=request, db_session=db_session)
    response.update(resp)
    return resp

# Pendaftaran Siswa

@router.get("/pendaftaransiswa/")
async def list_pendaftaransiswa(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await siswa_crud.get_list_pendaftaransiswa(db_session=db_session, page=page, show=show)
    return result

@router.get("/pendaftaransiswa/{id_pendaftaransiswa}")
async def detail_pendaftaransiswa(id_pendaftaransiswa: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.get_detail_pendaftaransiswa(db_session=db_session, id_pendaftaransiswa=id_pendaftaransiswa)
    response.update(resp)
    return response

@router.post("/pendaftaransiswa/tambah")
async def add_pendaftaransiswa(request: PendaftaranSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.add_pendaftaransiswa(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/pendaftaransiswa/edit")
async def edit_pendaftaransiswa(id_pendaftaransiswa: int, request: PendaftaranSiswa, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.edit_pendaftaransiswa(id_pendaftaransiswa=id_pendaftaransiswa, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/pendaftaransiswa/hapus/{id_pendaftaransiswa}")
async def hapus_pendaftaransiswa(id_pendaftaransiswa: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await siswa_crud.delete_pendaftaransiswa(id_pendaftaransiswa=id_pendaftaransiswa, db_session=db_session)
    response.update(resp)
    return response

