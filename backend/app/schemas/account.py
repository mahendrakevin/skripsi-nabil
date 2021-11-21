from pydantic import BaseModel
from typing import Optional, List
from pydantic.fields import Field

class RekeningTransaksi(BaseModel):
    nama_rekening: Optional[str] = 'Nama Rekening'
    keterangan: Optional[str] = 'Keterangan'
    kode_valuta: Optional[str] = 'IDR'
    nama_valuta: Optional[str] = 'RUPIAH'
    kode_jenis: Optional[str] = 'SAV' # Tabungan SAV, Giro CA, Deposito DEP

class RekeningLiabilitas(BaseModel):
    kode_produk: Optional[str] = '102'
    #is_dapat_bagi_hasil: Optional[str] = 'T'
    nisbah_spesial: Optional[float] = 10
    #persentase_zakat_bagi_hasil: Optional[float] = 10
    #tarif_pajak: Optional[float] = 10
    #nisbah_bagi_hasil: Optional[float] = 10
    nomor_rekening_disposisi: Optional[str] = '1234567890'
    penerima_transfer_bagi_hasil: Optional[str] = 'penerima transfer'
    #alamat_kirim: Optional[str] = 'D'
    #is_boleh_debet: Optional[str] = 'T'
    #is_boleh_kredit: Optional[str] = 'T'
    #is_cetak_nota: Optional[str] = 'T'
    #is_status_passbook: Optional[str] = 'T'
    #is_tidak_dormant: Optional[str] = 'T'
    #is_biaya_rekening_dormant: Optional[str] = 'T'
    #is_kena_biayalayananumum: Optional[str] = 'T'
    #is_biaya_saldo_minimum: Optional[str] = 'T'
    #is_biaya_atm: Optional[str] = 'T'
    #is_kena_biayapdc: Optional[str] = 'T'
    id_sumber_dana: Optional[str] = '1201'
    id_tujuan_rekening: Optional[str] = '2'
    #kode_marketing_referensi: Optional[str] = 'MARREF'
    kode_marketing_current: Optional[str] = 'MARCUR'
    kode_marketing_pertama: Optional[str] = 'MARPER'
    id_asuransi_utama: Optional[str] = '1'
    id_asuransi: Optional[str] = '1'
    tanggal_jatuh_tempo_asuransi: Optional[str] = '01-01-1990'
    jenis_rekening_liabilitas: Optional[str] = 'T' # Tabungan T, Giro G, R Rencana

class RekeningRencana(BaseModel):
    jangka_waktu: Optional[int] = 12
    tanggal_setoran_rutin: Optional[int] = 26
    target_nominal: Optional[float] = 1000000
    setoran_awal: Optional[float] = 1000
    nomor_rekening_pencairan: Optional[str] = '1234567890'
    rencana_pencairan: Optional[int] = 1

class AlamatAlternatif(BaseModel):
    alamat_jalan: Optional[str] = 'jalan'
    alamat_kota_kabupaten: Optional[str] = 'kota'
    alamat_kecamatan: Optional[str] = 'kecamatan'
    alamat_rtrw: Optional[str] = 'rtrw'
    alamat_kelurahan: Optional[str] = 'kelurahan'
    alamat_provinsi: Optional[str] = 'provinsi'
    alamat_kode_pos: Optional[str] = 'kpos'
    alamat_email: Optional[str] = 'email'
    telepon: Optional[str] = 'telepon'
    status: Optional[str] = 'A'

class AccountRegister(BaseModel):
    kode_cabang: Optional[str] = '001'
    user_input: Optional[str] = 'SYSTEM'
    user_update: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'
    nomor_nasabah: Optional[str] = '1234567890'
    rekeningtransaksi: Optional[RekeningTransaksi] = Field(alias='rekeningtransaksi')
    rekeningliabilitas: Optional[RekeningLiabilitas] = Field(alias='rekeningliabilitas')
    rekeningrencana: Optional[RekeningRencana] = Field(alias='rekeningrencana')
    #alamatalternatif: Optional[AlamatAlternatif] = Field(alias='alamatalternatif')

class RekeningLiabilitasDeposito(BaseModel):
    kode_produk: Optional[str] = '102'
    #status_kelengkapan: Optional[str] = 'L'
    #status_restriksi: Optional[str] = 'F'
    nisbah_spesial: Optional[float] = 10

class Deposito(BaseModel):
    nomor_bilyet: Optional[str] = '1234567890'
    tanggal_jatuh_tempo_terakhir: Optional[str] = '01-01-1990'
    disposisi_nominal: Optional[str] = 'A'
    rekening_disposisi: Optional[str] = '1234567890'
    penerima_transfer_disposisi: Optional[str] = 'PENERIMA'

class DepositoRegister(BaseModel):
    kode_cabang: Optional[str] = '001'
    user_input: Optional[str] = 'SYSTEM'
    user_update: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'
    nomor_nasabah: Optional[str] = '1234567890'
    rekeningtransaksi: Optional[RekeningTransaksi] = Field(alias='rekeningtransaksi')
    rekeningliabilitas: Optional[RekeningLiabilitas] = Field(alias='rekeningliabilitas')
    deposito: Optional[Deposito] = Field(alias='deposito')
    #rekeningrencana: Optional[RekeningRencana] = Field(alias='rekeningrencana')
    #alamatalternatif: Optional[AlamatAlternatif] = Field(alias='alamatalternatif')

class AccountBlok(BaseModel):
    nomor_rekening: Optional[str] = '001102000133'
    is_blokir: Optional[str] = 'T'
    keterangan: Optional[str] = 'keterangan'
    user_input: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'

class BalanceHold(BaseModel):
    nomor_rekening: Optional[str] = '001102000133'
    nominal_hold: Optional[float] = 1000
    alasan_hold: Optional[str] = 'keterangan'
    tanggal_hold: Optional[str] = '01-01-1990'
    tanggal_kadaluarsa: Optional[str] = '01-01-1990'
    is_regulatory: Optional[str] = 'T'
    user_hold: Optional[str] = 'SYSTEM'
    user_otorisasi: Optional[str] = 'SYSTEM'

class JoinAccount(BaseModel):
    nomor_rekening: Optional[str] = 'string'
    kode_join_account: Optional[str] = 'string'
    list_joinacc: Optional[List] = Field(alias='list_joinacc')