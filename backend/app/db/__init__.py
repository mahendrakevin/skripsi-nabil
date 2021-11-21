from sqlalchemy import MetaData
from sqlalchemy.ext.asyncio import create_async_engine, AsyncSession
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker
from config import settings

engine = create_async_engine(
    settings.SQLALCHEMY_DATABASE_URI,
    echo=False, # set it to True if you wanna know what sqlalchemy did
    pool_size=100,
    max_overflow=200,
    pool_recycle=300,
    pool_pre_ping=True,
    pool_use_lifo=True)

# create AsyncSession sessionmaker version
async_session = sessionmaker(
    engine, expire_on_commit=False, class_=AsyncSession
)

metadata = MetaData()
Base = declarative_base(metadata=metadata)

# db async session
async def get_async_session():
    db = async_session()
    try:
        yield db
    finally:
        await db.close()

# Dependency
def get_session():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()
