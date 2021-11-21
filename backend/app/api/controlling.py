# from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
# from crud import controlling_crud
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger


router = APIRouter()

@router.get("/cluster-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/perusahaan-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/ranger-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/lalo")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/kabupaten-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/provinsi-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/provinsi-ranger-count")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/cluster-daily")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/perusahaan-daily")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/ranger-daily")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/ranger-timeline")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response