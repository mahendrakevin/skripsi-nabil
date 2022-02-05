from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text, Sequence
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class Siswa(Base):
    __tablename__ = "data_siswa"
    id = Column(BigInteger,  Sequence('data_siswa_id'), primary_key=True)
    nisn = Column(BigInteger, primary_key=True)
    nis = Column(BigInteger, Sequence('nis_seq', start=1000), primary_key=True)
    nama_siswa = Column(String(50))
    tempat_lahir = Column(String(50))
    tanggal_lahir = Column(Date)
    jenis_kelamin = Column(String(20))
    nik = Column(BigInteger)
    id_kelas = Column(BigInteger,  ForeignKey("data_kelas.id", ondelete="CASCADE"))
    status_siswa = Column(String(20))
    nomor_kip = Column(BigInteger)
    alamat = Column(String(200))
    nomor_kk = Column(BigInteger)
    nama_kepalakeluarga = Column(String(50))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class Kelas(Base):
    __tablename__ = "data_kelas"
    id = Column(BigInteger, primary_key=True)
    nama_kelas = Column(String(10))
    kapasitas_kelas = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _data_siswa = relationship("Siswa", uselist=False, back_populates="owner")

class PendaftaranSiswa(Base):
    __tablename__ = "data_pendaftaran_siswa"
    id = Column(BigInteger, primary_key=True)
    nisn = Column(BigInteger)
    nama_siswa = Column(String(50))
    tempat_lahir = Column(String(50))
    tanggal_lahir = Column(Date)
    jenis_kelamin = Column(String(20))
    nik = Column(BigInteger)
    nomor_kip = Column(BigInteger)
    alamat = Column(String(200))
    nomor_kk = Column(BigInteger)
    nama_kepalakeluarga = Column(String(50))
    status_siswa = Column(String(20))
    id_pembayaran = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
