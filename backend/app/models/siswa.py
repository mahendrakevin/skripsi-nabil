from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text, Sequence
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base


class Siswa(Base):
    __tablename__ = "data_siswa"
    id = Column(BigInteger,  Sequence('data_siswa_id'), primary_key=True, unique=True)
    nisn = Column(BigInteger, primary_key=True)
    nis = Column(BigInteger, primary_key=True)
    nama_siswa = Column(String(50))
    tempat_lahir = Column(String(50))
    tanggal_lahir = Column(Date)
    jenis_kelamin = Column(String(20))
    nik = Column(BigInteger)
    id_kelas = Column(BigInteger, ForeignKey("data_kelas.id", ondelete="CASCADE"))
    status_siswa = Column(String(20))
    nomor_kip = Column(BigInteger)
    alamat = Column(String(200))
    nomor_kk = Column(BigInteger)
    file_kk = Column(Text)
    jenis_wali = Column(Text)
    nomor_kks = Column(BigInteger)
    nomor_pkh = Column(BigInteger)
    current_state = Column(String(30))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _data_siswa = relationship("Siswa", uselist=False, back_populates="owner")
    _status_pembayaran = relationship("StatusPembayaran", uselist=False, back_populates="owner")

class StatusPembayaran(Base):
    __tablename__ = "status_pembayaran"
    id = Column(BigInteger, primary_key=True)
    id_siswa = Column(BigInteger, ForeignKey("data_siswa.id", ondelete="CASCADE"))
    id_jenispembayaran = Column(BigInteger, ForeignKey("jenis_pembayaran.id", ondelete="CASCADE"))
    nominal_pembayaran = Column(BigInteger)
    status_pembayaran = Column(String(20))
    tanggal_pembayaran = Column(Date)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _laporan_pembayaran = relationship("LaporanPembayaran", uselist=False, back_populates="owner")

class Kelas(Base):
    __tablename__ = "data_kelas"
    id = Column(BigInteger, primary_key=True)
    nama_kelas = Column(String(64))
    tingkat = Column(String(10))
    kapasitas_kelas = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    id_wali_kelas = Column(BigInteger, ForeignKey("data_guru.id", ondelete="CASCADE"))
    _data_siswa = relationship("Siswa", uselist=False, back_populates="owner")

# class PendaftaranSiswa(Base):
#     __tablename__ = "data_pendaftaran_siswa"
#     id = Column(BigInteger, primary_key=True)
#     nisn = Column(BigInteger)
#     nama_siswa = Column(String(50))
#     tempat_lahir = Column(String(50))
#     tanggal_lahir = Column(Date)
#     jenis_kelamin = Column(String(20))
#     nik = Column(BigInteger)
#     nomor_kip = Column(BigInteger)
#     alamat = Column(String(200))
#     nomor_kk = Column(BigInteger)
#     nama_kepalakeluarga = Column(String(50))
#     status_siswa = Column(String(20))
#     id_pembayaran = Column(BigInteger)
#     created = Column(DateTime, server_default=func.now())
#     updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
