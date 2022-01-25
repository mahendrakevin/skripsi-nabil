from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class Inventory(Base):
    __tablename__ = "data_inventory"
    id = Column(BigInteger, primary_key=True)
    nama_barang = Column(String(200))
    nomor_seri = Column(BigInteger)
    id_kategori_barang = Column(BigInteger)
    jumlah_barang = Column(BigInteger)
    tanggal_pembelian = Column(Date)
    harga_barang = Column(BigInteger)
    id_jenis_inventaris = Column(BigInteger)
    keterangan = Column(Text)
    lampiran = Column(Text)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class KategoriBarang(Base):
    __tablename__ = "data_kategori_barang"
    id = Column(BigInteger, primary_key=True)
    nama_kategori = Column(String(100))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisInventaris(Base):
    __tablename__ = "data_jenis_inventaris"
    id = Column(BigInteger, primary_key=True)
    nama_jenis_inventaris = Column(String(100))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())