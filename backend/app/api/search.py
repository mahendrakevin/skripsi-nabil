# from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
# from crud import search_crud
from sqlalchemy.ext.asyncio import AsyncSession
from utils import logger


router = APIRouter()

@router.get("/helloworld")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/summary")
async def summary():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-daily")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-daily-sentiment")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-day")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-compare")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/trending-topic")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/top-hashtag")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/top-site")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-daily")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/top-profile-active")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/top-public-active")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/top-public-profile")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/tweet-daily")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.get("/wordcloud")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/compare")
async def daytoday():
    response = {"status": "Success", "message_id": "00"}
    return response

