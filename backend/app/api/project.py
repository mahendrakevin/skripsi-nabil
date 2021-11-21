from db import get_async_session
from fastapi import APIRouter, Body, Depends, Request
from fastapi.logger import logger
from typing import Any
from crud import project_crud
from schemas import ProjectBaseSchema
from sqlalchemy.ext.asyncio import AsyncSession
#from utils import logger

router = APIRouter()

@router.get("/helloworld")
async def helloworld():
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/summary")
async def summary(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getSummary(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-daily")
async def count_daily(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getCountDaily(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-daily-sentiment")
async def count_daily_sentiment(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getCountDailySentiment(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-day")
async def count_day(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getCountDaily(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/sentiment-count")
async def sentiment_count(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getSentimentCount(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response

@router.post("/count-compare")
async def count_compare(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getCountCompare(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
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
async def count_day(request: ProjectBaseSchema,
                  db_session: AsyncSession = Depends(get_async_session)) -> Any:
    try:

        response = await project_crud.getCompare(request=request, db_session=db_session)
        return response

    except Exception as e:

        error = getattr(e, "message", repr(e))
        print(error)
        return error
    response = {"status": "Success", "message_id": "00"}
    return response