from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class StatusPembayaran(Base):
    __tablename__ = "status_pembayaran"
    id = Column(BigInteger, primary_key=True)
    id_pendaftaran = Column(BigInteger)
    nominal_pembayaran = Column(BigInteger)
    status_pembayaran = Column(String(10))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())