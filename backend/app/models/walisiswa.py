from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class WaliSiswa(Base):
    __tablename__ = "data_wali_siswa"
    id = Column(BigInteger, primary_key=True)
    id_jeniswali = Column(BigInteger)
    nama_wali = Column(String(100))
    file_kk = Column(Text)
    tempat_lahir = Column(String(50))
    tanggal_lahir = Column(Date)
    alamat = Column(Text)
    no_hp = Column(BigInteger)
    pendidikan = Column(BigInteger)
    pekerjaan = Column(String(50))
    penghasilan = Column(BigInteger)
    nomor_kks = Column(BigInteger)
    nomor_pkh = Column(BigInteger)
    id_siswa = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisWali(Base):
    __tablename__ = "data_jenis_wali"
    id = Column(BigInteger, primary_key=True)
    jenis_wali = Column(String(20))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class LaporanPembayaran(Base):
    __tablename__ = "laporan_pembayaran"
    id = Column(BigInteger, primary_key=True)
    id_jenispembayaran = Column(BigInteger)
    status_pembayaran  = Column(String(10))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisPembayaran(Base):
    __tablename__ = "jenis_pembayaran"
    id = Column(BigInteger, primary_key=True)
    jenis_pembayaran = Column(String(50))
    nominal_pembayaran = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())