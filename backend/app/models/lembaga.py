from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class DataLembaga(Base):
    __tablename__ = "data_lembaga"
    id = Column(BigInteger, primary_key=True)
    nama_lembaga = Column(String(100))
    akreditasi = Column(String(20))
    tahun_berdiri = Column(Date)
    no_telp = Column(String(20))
    alamat = Column(Text)
    email = Column(String(100))
    npsn = Column(BigInteger)
    nsm = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class SaranaPrasarana(Base):
    __tablename__ = "sarana_prasarana"
    id = Column(BigInteger, primary_key=True)
    nama_aset = Column(String(100))
    luas_lahan = Column(BigInteger)
    luas_bangunan = Column(BigInteger)
    nama_pemilik = Column(String(100))
    no_sertifikat = Column(String(100))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class SuratKeterangan(Base):
    __tablename__ = "data_surat_keterangan"
    id = Column(BigInteger, primary_key=True)
    nomor_surat_operasional = Column(String(100))
    tanggal_surat_operasional = Column(Date)
    nomor_surat_kemenkumham = Column(String(100))
    tanggal_surat_kemenkumham = Column(Date)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
