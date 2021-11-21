from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
from crud import api_crud
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger


router = APIRouter()

@router.get("/list")
async def api_list(db_session: AsyncSession = Depends(get_async_session)):
    response = {"status": "Success", "message_id": "00"}
    resp = await api_crud.getAPI(db_session)
    response.update(resp)
    return response

@router.post("/add")
async def keyword_add():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.delete("/delete/{app_key}")
async def delete_keyword(app_key: str):
    response = {"status": "Success", "message_id": "00"}
    return response