from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request, status
from fastapi.responses import JSONResponse
from fastapi.logger import logger
from typing import Any
from crud import inventory_crud
from schemas import DataInventory, KategoriBarang, JenisInventaris
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger
from typing import Dict


router = APIRouter()

@router.get("/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await inventory_crud.get_list_inventory(db_session=db_session, page=page, show=show)
    return result

@router.get("/{id_inventory}")
async def detail(id_inventory: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.get_detail_inventory(db_session=db_session, id_inventory=id_inventory)
    response.update(resp)
    return response

@router.post("/tambah")
async def add(request: DataInventory, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.add_inventory(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/edit")
async def edit(id_inventory: int, request: DataInventory, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.edit_inventory(id_inventory=id_inventory, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/hapus/{id_inventory}")
async def hapus(id_inventory: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.delete_inventory(id_inventory=id_inventory, db_session=db_session)
    response.update(resp)
    return response

# Kategori Barang

@router.get("/kategori_barang/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await inventory_crud.get_list_kategori_barang(db_session=db_session, page=page, show=show)
    return result

@router.get("/kategori_barang/{id_kategori_barang}")
async def detail(id_kategori_barang: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.get_detail_kategori_barang(db_session=db_session, id_kategori_barang=id_kategori_barang)
    response.update(resp)
    return response

@router.post("/kategori_barang/tambah")
async def add(request: KategoriBarang, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.add_kategori_barang(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/kategori_barang/edit")
async def edit(id_kategori_barang: int, request: KategoriBarang, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.edit_kategori_barang(id_kategori_barang=id_kategori_barang, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/kategori_barang/hapus/{id_kategori_barang}")
async def hapus(id_kategori_barang: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.delete_kategori_barang(id_kategori_barang=id_kategori_barang, db_session=db_session)
    response.update(resp)
    return response

# Jenis Inventaris

@router.get("/jenis_inventaris/")
async def list(db_session: AsyncSession = Depends(get_async_session), page: int=1, show: int=10):
    result = await inventory_crud.get_list_jenis_inventaris(db_session=db_session, page=page, show=show)
    return result

@router.get("/jenis_inventaris/{id_jenis_inventaris}")
async def detail(id_jenis_inventaris: int, db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.get_detail_jenis_inventaris(db_session=db_session, id_jenis_inventaris=id_jenis_inventaris)
    response.update(resp)
    return response

@router.post("/jenis_inventaris/tambah")
async def add(request: JenisInventaris, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.add_jenis_inventaris(request=request, db_session=db_session)
    response.update(resp)
    return response

@router.put("/jenis_inventaris/edit")
async def edit(id_jenis_inventaris: int, request: JenisInventaris, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.edit_jenis_inventaris(id_jenis_inventaris=id_jenis_inventaris, request=request, db_session=db_session)
    response.update(resp)
    return response

@router.delete("/jenis_inventaris/hapus/{id_jenis_inventaris}")
async def hapus(id_jenis_inventaris: int, db_session: AsyncSession = Depends(get_async_session)) -> Dict[str, Any]:
    response = {"status": "Success", "message_id": "00"}
    resp = await inventory_crud.delete_jenis_inventaris(id_jenis_inventaris=id_jenis_inventaris, db_session=db_session)
    response.update(resp)
    return response
