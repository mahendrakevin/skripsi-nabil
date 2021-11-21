import logging
import random
import string
import time
from fastapi import FastAPI, Request
from starlette.exceptions import HTTPException as StarletteHTTPException
from starlette.middleware.cors import CORSMiddleware
from fastapi.middleware.httpsredirect import HTTPSRedirectMiddleware
from fastapi.encoders import jsonable_encoder
from fastapi.exceptions import RequestValidationError
from fastapi.responses import PlainTextResponse, JSONResponse
from utils import logger
from api import api_router
from config import settings
from db import engine, Base

#metadata.create_all(engine)

app = FastAPI(
    title=settings.PROJECT_NAME, openapi_url=f"{settings.API_V1_STR}/openapi.json"
)

# setup loggers
#logging.config.fileConfig('logging.conf',disable_existing_loggers=False)
# get root logger
#logger = logging.getLogger(__name__)

@app.exception_handler(StarletteHTTPException)
async def http_exception_handler(request, exc):
    response = {
        "response_code": f"{exc.status_code}",
        "response_msg": exc.detail}
    print(f"ERROR: {response}")
    return JSONResponse(
        status_code=200,
        content=jsonable_encoder(response),
    )


@app.exception_handler(RequestValidationError)
async def validation_exception_handler(request, exc):
    print(f"ERROR: {exc}")
    err = exc.errors()
    err_info = (' \n').join(
        # [f"{(e['loc'][1]).capitalize()} Harus Diisi" for e in err])
        [f"{(e['loc'])} {(e['msg'])}" for e in err])
    return JSONResponse(
        content=jsonable_encoder({
            "response_code": "01",
            "response_msg": err_info}),
        status_code=200)


@app.middleware("http")
async def log_requests(request: Request, call_next):
    idem = "".join(random.choices(string.ascii_uppercase + string.digits, k=6))
    logger.info(f"rid={idem} start request path={request.url.path}")
    logger.info(f"TOKEN: {request.headers.get('Authorization')}")

    start_time = time.time()
    response = await call_next(request)

    process_time = (time.time() - start_time) * 1000
    formatted_process_time = "{0:.2f}".format(process_time)
    logger.info(
        f"rid={idem} completed_in={formatted_process_time}ms status_code={response.status_code}"
    )

    return response


@app.on_event("startup")
async def startup():
    async with engine.begin() as conn:
        # DELETE ALL TABLE
        # await conn.run_sync(Base.metadata.drop_all)

        # CREATE ALL TABLE based on imported models
        await conn.run_sync(Base.metadata.create_all)

        # migration seed
        #logger.info("Migration started...")
        #logger.info("Migration finished...")
    #--
#--

@app.on_event("shutdown")
async def shutdown():
    pass


app.include_router(api_router, prefix=f"{settings.API_V1_STR}")

# Set all CORS enabled origins
if settings.BACKEND_CORS_ORIGINS:
    app.add_middleware(
        CORSMiddleware,
        allow_origins=[str(origin)
                       for origin in settings.BACKEND_CORS_ORIGINS],
        # allow_origins=["*"],
        allow_credentials=True,
        allow_methods=["*"],
        allow_headers=["*"],
    )
