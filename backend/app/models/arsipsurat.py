from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class ArsipSurat(Base):
    __tablename__ = "arsip_surat"
    id = Column(BigInteger, primary_key=True)
    nama_surat = Column(String(100))
    nomor_surat = Column(String(100))
    tanggal_surat = Column(Date)
    jenis_surat = Column(String(100))
    keterangan = Column(Text)
    lampiran = Column(Text)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

