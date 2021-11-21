# from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
# from crud import search_crud
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger


router = APIRouter()

@router.get("/get-data")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

