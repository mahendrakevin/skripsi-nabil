from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text, Sequence
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class Otorisasi(Base):
    __tablename__ = "otorisasi"
    id = Column(BigInteger, primary_key=True)
    id_otorisasi = Column(BigInteger, Sequence("otorisasi_seq"), primary_key=True)

    tgl_input = Column(DateTime())
    kode_entri = Column(String(10))
    nama_entri = Column(String(50))
    user_input = Column(String(20))
    terminal_input = Column(String(25))
    tgl_otorisasi = Column(DateTime())
    user_otorisasi = Column(String(20))
    user_override = Column(String(20))
    status_otorisasi = Column(String(1))
    keterangan = Column(String(100))
    info1 = Column(String(30))
    info2 = Column(String(30))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())