from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class WaliSiswa(Base):
    __tablename__ = "data_wali_siswa"
    id = Column(BigInteger, primary_key=True)
    nama_ayah = Column(String(100))
    nik_ayah = Column(BigInteger)
    file_kk_ayah = Column(Text)
    tempat_lahir_ayah = Column(String(50))
    tanggal_lahir_ayah = Column(Date)
    alamat_ayah = Column(Text)
    status_keluarga_ayah = Column(String(50))
    status_hidup_ayah = Column(String(50))
    no_hp_ayah = Column(String(20))
    pendidikan_ayah = Column(String(50))
    pekerjaan_ayah = Column(String(50))
    penghasilan_ayah = Column(BigInteger)
    nama_ibu = Column(String(100))
    nik_ibu = Column(BigInteger)
    file_kk_ibu = Column(Text)
    tempat_lahir_ibu = Column(String(50))
    tanggal_lahir_ibu = Column(Date)
    alamat_ibu = Column(Text)
    status_keluarga_ibu = Column(String(50))
    status_hidup_ibu = Column(String(50))
    no_hp_ibu = Column(String(20))
    pendidikan_ibu = Column(String(50))
    pekerjaan_ibu = Column(String(50))
    penghasilan_ibu = Column(BigInteger)
    nama_wali = Column(String(100))
    tempat_lahir_wali = Column(String(50))
    tanggal_lahir_wali = Column(Date)
    alamat_wali = Column(Text)
    no_hp_wali = Column(String(20))
    pendidikan_wali = Column(String(50))
    pekerjaan_wali = Column(String(50))
    penghasilan_wali = Column(BigInteger)
    keterangan = Column(Text)
    id_siswa = Column(BigInteger, ForeignKey("data_siswa.id", ondelete="CASCADE"))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisWali(Base):
    __tablename__ = "data_jenis_wali"
    id = Column(BigInteger, primary_key=True)
    jenis_wali = Column(String(20))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _data_siswa = relationship("Siswa", uselist=False, back_populates="owner")

class LaporanPembayaran(Base):
    __tablename__ = "laporan_pembayaran"
    id = Column(BigInteger, primary_key=True)
    id_jenispembayaran = Column(BigInteger, ForeignKey("jenis_pembayaran.id", ondelete="CASCADE"))
    id_statuspembayaran  = Column(BigInteger, ForeignKey("status_pembayaran.id", ondelete="CASCADE"))
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())

class JenisPembayaran(Base):
    __tablename__ = "jenis_pembayaran"
    id = Column(BigInteger, primary_key=True)
    jenis_pembayaran = Column(String(50))
    nominal_pembayaran = Column(BigInteger)
    created = Column(DateTime, server_default=func.now())
    updated = Column(DateTime, server_default=func.now(), server_onupdate=func.now())
    _status_pembayaran = relationship("StatusPembayaran", uselist=False, back_populates="owner")
