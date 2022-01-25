from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text, BIGINT
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class SumberDana(Base):
    __tablename__ = "sumber_dana"
    id = Column(BigInteger, primary_key=True)
    nama_dana = Column(String(50))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisPengeluaran(Base):
    __tablename__ = "jenis_pengeluaran"
    id = Column(BigInteger, primary_key=True)
    jenis_pengeluaran = Column(String(50))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class DanaMasuk(Base):
    __tablename__ = "dana_masuk"
    id = Column(BigInteger, primary_key=True)
    tanggal = Column(Date)
    id_sumberdana = Column(BigInteger)
    nominal_dana = Column(BigInteger)
    lampiran = Column(Text)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class DanaKeluar(Base):
    __tablename__ = "dana_keluar"
    id = Column(BigInteger, primary_key=True)
    tanggal = Column(Date)
    detail_pengeluaran = Column(Text)
    id_jenispengeluaran = Column(BigInteger)
    diserahkan_kepada = Column(String(100))
    dikeluarkan_oleh = Column(String(100))
    bukti_pengeluaran = Column(Text)
    nominal_pengeluaran = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())


