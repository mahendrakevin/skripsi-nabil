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
    _dana_masuk = relationship("DanaMasuk", uselist=False, back_populates="owner")

class JenisPengeluaran(Base):
    __tablename__ = "jenis_pengeluaran"
    id = Column(BigInteger, primary_key=True)
    jenis_pengeluaran = Column(String(50))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _dana_masuk = relationship("DanaKeluar", uselist=False, back_populates="owner")

class DanaMasuk(Base):
    __tablename__ = "dana_masuk"
    id = Column(BigInteger, primary_key=True)
    tanggal = Column(Date)
    id_sumberdana = Column(BigInteger, ForeignKey("sumber_dana.id", ondelete="CASCADE"))
    nominal_dana = Column(BigInteger)
    lampiran = Column(Text)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class DanaKeluar(Base):
    __tablename__ = "dana_keluar"
    id = Column(BigInteger, primary_key=True)
    tanggal = Column(Date)
    detail_pengeluaran = Column(Text)
    id_jenispengeluaran = Column(BigInteger, ForeignKey("jenis_pengeluaran.id", ondelete="CASCADE"))
    diserahkan_kepada = Column(String(100))
    dikeluarkan_oleh = Column(String(100))
    bukti_pengeluaran = Column(Text)
    nominal_pengeluaran = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())


