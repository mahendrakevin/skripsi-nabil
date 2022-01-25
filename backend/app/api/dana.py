# from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
# from crud import search_crud
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger


router = APIRouter()

@router.get("/list")
async def list():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/tambah")
async def add():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.put("/edit")
async def edit():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.delete("/hapus")
async def hapus():
    response = {"status": "Success", "message_id": "00"}
    return response

