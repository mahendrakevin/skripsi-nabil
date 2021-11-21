from sys import prefix
from fastapi import APIRouter
from api import project, search, controlling, sna, api, keyword

api_router = APIRouter()

api_router.include_router(api.router, prefix="/api", tags=["API Management"])
api_router.include_router(keyword.router, prefix="/keyword", tags=["Keyword Management"])
api_router.include_router(project.router, prefix="/project", tags=["Analytic Project"])
api_router.include_router(search.router, prefix="/search", tags=["Analytic Search"])
api_router.include_router(controlling.router, prefix="/controlling", tags=["Controlling Ranger"])
api_router.include_router(sna.router, prefix="/sna", tags=["Social Network Analysis"])
