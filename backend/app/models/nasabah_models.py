from datetime import datetime
from sqlalchemy import Column, Integer, String, BigInteger, ForeignKey, Date, DateTime, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from sqlalchemy.sql.sqltypes import TIMESTAMP
from db import Base

class RekeningBankLain(Base):
    # define table name
    __tablename__ = "rekeningbanklain"

    id_rekening = Column(Integer, primary_key=True)
    jenis_rekening= Column(String(1))
    nomor_rekening= Column(String(30))
    kode_valuta= Column(String(5))
    sandi_bank= Column(String(30))
    tgl_pembukaan= Column(Date)
    keterangan= Column(String(100))
    nomor_nasabah= Column(String(30))

class BeneficiaryOwner(Base):
    # define table name
    __tablename__ = 'beneficiaryowner'

    id_beneficiaryowner = Column(Integer, primary_key=True)
    beneficiaryownertype = Column(String(1))
    id_individu = Column(Integer)
    id_korporat = Column(Integer)
    id_sumber_dana = Column(Integer)
    id_penghasilan = Column(Integer)
    id_tujuan_penggunaan_dana = Column(Integer)
    nomor_nasabah = Column(String(30))
    nomor_nasabah_bo = Column(String(30))
    keterangan = Column(String(200))
    status = Column(String(1))
    alamat_domisili_jalan = Column(String(150))
    alamat_domisili_kecamatan = Column(String(30))
    alamat_domisili_kelurahan = Column(String(30))
    alamat_domisili_kode_pos = Column(String(10))
    alamat_domisili_kota_kabupaten = Column(String(30))
    alamat_domisili_provinsi = Column(String(30))
    alamat_domisili_rt = Column(String(10))
    alamat_domisili_rw = Column(String(10))

class RelasiNasabah(Base):
    # define table name
    __tablename__ = "relasinasabah"

    id_relasi = Column(Integer, primary_key=True)
    id_tipe_relasi = Column(Integer)
    jabatan = Column(String(50))
    nomor_nasabah = Column(String(30))
    nomor_nasabah_relasi = Column(String(30))

class AhliWaris(Base):
    # define table name
    __tablename__ = "ahliwaris"

    id_ahli_waris = Column(Integer, primary_key=True)
    nomor_urut_prioritas = Column(Integer)
    nama_lengkap = Column(String(50))
    jenis_kelamin = Column(String(1))
    hubungan_keluarga = Column(Integer)
    keterangan = Column(String(100))
    nomor_nasabah = Column(String(30))

class Nasabah(Base):
    # define table name
    __tablename__ = "nasabah"

    nomor_nasabah = Column(String(30), primary_key=True)
    status_data = Column(String(1))
    kode_cabang_input = Column(String(20))
    jenis_nasabah = Column(String(1))
    tanggal_buka = Column(DateTime)
    nama_nasabah = Column(String(100))
    jenis_penduduk = Column(String(1))
    alamat_surat_jalan = Column(String(150))
    alamat_surat_rt = Column(String(30))
    alamat_surat_rw = Column(String(30))
    alamat_surat_kelurahan = Column(String(30))
    alamat_surat_kecamatan = Column(String(30))
    alamat_surat_kota_kabupaten = Column(String(30))
    alamat_surat_provinsi = Column(String(30))
    alamat_surat_kode_pos = Column(String(10))
    status_keterkaitan = Column(String(1))
    keterangan = Column(String(200))
    nasabah_prioritas = Column(String(1))
    referal_nasabah = Column(String(100))
    kode_marketing = Column(String(20))
    id_tujuan_penggunaan_dana = Column(Integer)
    id_golongan_nasabah = Column(Integer)
    id_golongan_pemilik = Column(Integer)
    golongan_pemilik_xlbrl = Column(Integer)
    buka_rek_untuk_gaji = Column(String(1))
    buka_rek_untuk_program_pemerintah = Column(String(1))
    limit_nom_setor_tunai = Column(Integer)
    limit_nom_setor_nontunai = Column(Integer)
    limit_nom_tarik_tunai = Column(Integer)
    limit_nom_tarik_nontunai = Column(Integer)
    limit_frek_setor_tunai = Column(Integer)
    limit_frek_setor_nontunai = Column(Integer)
    limit_frek_tarik_tunai = Column(Integer)
    limit_frek_tarik_nontunai = Column(Integer)
    status_skb = Column(String(1))
    keterangan_skb = Column(String(100))
    nomor_surat_skb = Column(String(100))
    tgl_terbit_skb = Column(Date)
    tgl_berakhir_skb = Column(Date)
    status_resiko = Column(String(1))
    id_bidang_usaha = Column(Integer)
    lokasi_usaha = Column(Integer)

class NasabahIndividu(Base):
    # define table name
    __tablename__ = "nasabahindividu"

    id_individu = Column(Integer)
    nomor_nasabah = Column(String(30), primary_key=True)
    pendidikan = Column(String(1))
    id_pekerjaan = Column(Integer)
    jabatanpekerjaan = Column(String(100))
    id_sektor_ekonomi = Column(Integer)
    nama_perusahaan_kerja = Column(String(32))
    id_badan_hukum_kerja = Column(Integer)
    alamat_kerja_jalan = Column(String(150))
    alamat_kerja_rt = Column(String(30))
    alamat_kerja_rw = Column(String(30))
    alamat_kerja_kelurahan = Column(String(30))
    alamat_kerja_kecamatan = Column(String(30))
    alamat_kerja_kota_kabupaten = Column(String(30))
    alamat_kerja_provinsi = Column(String(30))
    alamat_kerja_kode_pos = Column(String(10))
    telepon_kerja_kode_area = Column(String(5))
    telepon_kerja_nomor = Column(String(15))
    telepon_kerja2_kode_area = Column(String(5))
    telepon_kerja2_nomor = Column(String(15))
    status_pep = Column(String(1))
    detail_pep = Column(Integer)
    status_keterkaitan_pep = Column(String(1))
    detail_keterkaitan_pep = Column(Integer)
    keluarga_dihub_nama = Column(String(100))
    keluarga_dihub_tlp_nomor = Column(String(15))
    id_penghasilan = Column(Integer)
    id_status_rumah = Column(Integer)
    lama_menempati_rumah_thn = Column(Integer)
    lama_menempati_rumah_bln = Column(Integer)

class Korporat(Base):
    # define table name
    __tablename__ = "korporat"

    id_korporat = Column(Integer, primary_key=True)

class Individu(Base):
    # define table name
    __tablename__ = "individu"

    id_individu = Column(Integer, primary_key=True)
    jenis_identitas = Column(String(1))
    nomor_identitas = Column(String(30))
    nama_tanpa_singkatan = Column(String(200))
    nama_lengkap = Column(String(100))
    gelar_depan = Column(String(50))
    gelar_belakang = Column(String(50))
    nama_alias_1 = Column(String(100))
    nama_alias_2 = Column(String(100))
    nama_alias_3 = Column(String(100))
    nama_alias_4 = Column(String(100))
    tanggal_terbit_identitas = Column(Date)
    tanggal_berakhir_identitas = Column(Date)
    tempat_lahir = Column(String(30))
    tanggal_lahir = Column(Date)
    nama_ibu_kandung = Column(String(100))
    status_perkawinan = Column(String(1))
    kewarganegaraan = Column(String(1))
    id_negara = Column(Integer)
    jenis_kelamin = Column(String(1))
    agama= Column(String(1))
    alamat_email = Column(String(1))
    nomor_npwp = Column(String(30))
    alamat_rumah_jalan = Column(String(150))
    alamat_rumah_rt = Column(String(30))
    alamat_rumah_rw = Column(String(30))
    alamat_rumah_kelurahan = Column(String(30))
    alamat_rumah_kecamatan = Column(String(30))
    alamat_rumah_kota_kabupaten = Column(String(30))
    alamat_rumah_provinsi = Column(String(30))
    alamat_rumah_kode_pos = Column(String(10))
    telepon_rumah_kode_area = Column(String(10))
    telepon_rumah_nomor = Column(String(15))
    telepon_rumah2_kode_area = Column(String(10))
    telepon_rumah2_nomor = Column(String(15))
    fax_kode_area = Column(String(5))
    fax_nomor = Column(String(20))
    telepon_hp_nomor = Column(String(20))
    alamat_luar_negeri = Column(String(300))

class RiskIndicatorCust(Base):
    # define table name
    __tablename__ = "riskindicatorcust"

    id_riskcust = Column(Integer, primary_key=True)
    id_riskparam = Column(Integer)
    nomor_nasabah = Column(String(30))
    risk_status = Column(String(1))