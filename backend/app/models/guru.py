from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class Guru(Base):
    __tablename__ = "data_guru"
    id = Column(BigInteger, primary_key=True)
    nip = Column(BigInteger)
    nuptk = Column(BigInteger)
    nik = Column(BigInteger)
    nama_guru = Column(String(50))
    tempat_lahir = Column(String(50))
    tanggal_lahir = Column(Date)
    jenis_kelamin = Column(String(20))
    alamat = Column(Text)
    no_hp = Column(BigInteger)
    email = Column(String(50))
    status_perkawinan = Column(String(20))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class Kepegawaian(Base):
    __tablename__ = "status_kepegawaian"
    id = Column(BigInteger, primary_key=True)
    id_guru = Column(BigInteger)
    no_sk = Column(String(20))
    no_sk_ypmnu = Column(String(20))
    no_sk_operator = Column(String(20))
    id_jabatan = Column(BigInteger)
    status_kepegawaian = Column(String(20))
    alasan_tidak_aktif = Column(Text)
    surat_mutasi = Column(Text)
    jumlah_ajar = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class Jabatan(Base):
    __tablename__ = "jabatan"
    id = Column(BigInteger, primary_key=True)
    nama_jabatan = Column(String(50))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())



