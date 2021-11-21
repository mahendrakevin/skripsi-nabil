from datetime import datetime, date
from dateutil.relativedelta import relativedelta
from pydantic import BaseModel, Field, EmailStr
from typing import Optional, List


def parse_datetime(v: str):
    if isinstance(v, str):
        try:
            return datetime.strptime(v, "%Y%m%d%H%M%S")
        except:
            return datetime.now()
        # --
        return v


class BaseMsg(BaseModel):
    client_id: str
    trx_type: str
    trx_date_time: str
    system_trace_audit: str
    pos_terminal_type: str
    sign: str

    """
    class Config:
        json_encoders = {
            datetime: lambda v: v.strftime('%Y%m%d%H%M%S'),
        }

    # validators
    _normalize_datetime = validator('trx_date_time', allow_reuse=True)(parse_datetime)
    """


class MsgResp(BaseModel):
    response_code: str
    response_msg: str


class BaseResponse(BaseModel):
    client_id: str
    trx_type: str
    trx_date_time: str
    system_trace_audit: str
    pos_terminal_type: str
    response_code: str
    response_msg: str


class BaseAccount(BaseMsg):
    account_no: Optional[str]


class BaseAccountResponse(BaseResponse):
    account_no: str


# Customer Inquiry
class BaseCIFRequest(BaseModel):
    account_no: Optional[str]


class CIFRequest(BaseAccount):
    pass


# Balance Inquiry Schema
class BaseBINRequest(BaseModel):
    account_no: Optional[str]


class BINRequest(BaseAccount):
    pass


class BaseBINResponse(MsgResp):
    customer_name: str
    product_name: str
    account_type: str
    balance: int
    balance_eff: int


class BINResponse(BaseAccountResponse):
    customer_name: str
    product_name: str
    balance: int
    balance_eff: int


# History Schema
class BaseHINRequest(BaseModel):
    account_no: str
    date_start: Optional[str]
    date_end: Optional[str]
    page_no: Optional[str]
    row_no: Optional[str]


class HINRequestBase(BaseAccount):
    inquiry_type: Optional[str]


class HINRequestRecent(HINRequestBase):
    recent_no: Optional[int]


class HINRequestDate(HINRequestBase):
    date_start: Optional[str]
    date_end: Optional[str]


class HINRequestPage(HINRequestDate):
    page_no: Optional[str]
    row_no: Optional[str]


class BaseHINResponse(MsgResp):
    initial_balance: Optional[int]
    final_balance: Optional[int]
    transactions: Optional[List]


class HINResponse(BaseHINResponse):
    currentPage: Optional[int]
    show: Optional[int]
    totalRow: Optional[int]
    totalPage: Optional[int]


# NIK Inquiry
class BaseNIKRequest(BaseModel):
    nik: str


class NIKRequest(BaseMsg):
    nik: str


class NIKResponseDocs(BaseModel):
    nama_lengkap: str
    nama_ibu_kandung: str
    alamat_kelurahan: str
    tempat_lahir: str
    alamat_rw: str
    alamat_rt: str
    alamat_kota_kabupaten: str
    nomor_kk: str
    alamat_provinsi: str
    pekerjaan: str
    tanggal_lahir: str
    alamat_kecamatan: str
    jenis_kelamin: str
    kode_kota_kabupaten: str
    kode_kelurahan: str
    kode_kecamatan: str
    alamat_jalan: str
    kode_provinsi: str


class NIKResponse(BaseResponse):
    response_docs: NIKResponseDocs


# Request KAP
class BaseKARRequest(BaseModel):
    sen_country_id: Optional[str]
    account_no: str
    amount: int


class KARRequest(BaseAccount):
    amount: int
    sen_country_id: Optional[str]


class BaseKARResponse(BaseModel):
    inq_ref_number: Optional[str]
    trx_date_time: Optional[str]
    expired_time: Optional[str]
    pin: Optional[str]
    token: Optional[str]


class BaseITKRequest(BaseModel):
    sen_country_id: Optional[str]
    account_no: str
    amount: int
    pin: str


class ITKRequest(BaseAccount):
    sen_country_id: Optional[str]
    trx_code: str
    amount: int
    enc_pin: str


# Account Inquiry
class BaseAINRequest(BaseModel):
    account_no: str
    dest_account_no: str
    dest_bank_code: Optional[str]
    amount: int
    sen_country_id: str
    recp_country_id: Optional[str]
    # description: str


class AINRequest(BaseAccount):
    dest_account_no: str
    dest_bank_code: Optional[str]
    amount: int
    sen_country_id: str
    recp_country_id: Optional[str]
    # description: str


class BaseAINResponse(BaseModel):
    dest_customer_name: Optional[str] = ""
    dest_bank_name: Optional[str] = ""
    inq_ref_number: Optional[str] = ""
    amount: Optional[int] = 0
    fee_amount: Optional[int] = 0


class AINResponse(BaseResponse):
    dest_customer_name: Optional[str]
    dest_bank_name: Optional[str]
    inq_ref_number: Optional[str]
    fee_amount: Optional[int]


# Transfer
class BaseTRFRequest(BaseModel):
    account_no: str
    dest_account_no: str
    amount: int
    dest_bank_code: Optional[str]
    dest_customer_name: Optional[str]
    dest_bank_name: Optional[str]
    inq_ref_number: Optional[str]
    fee_amount: Optional[int]
    description: Optional[str]
    sen_country_id: Optional[str]
    recp_country_id: Optional[str]
    pin: str


class TRFRequest(BaseAccount):
    dest_account_no: str
    amount: int
    dest_bank_code: Optional[str]
    dest_customer_name: Optional[str]
    dest_bank_name: Optional[str]
    inq_ref_number: Optional[str]
    fee_amount: Optional[int]
    description: Optional[str]
    enc_pin: str
    sen_country_id: Optional[str]
    recp_country_id: Optional[str]


class BaseTRFResponse(MsgResp):
    inq_ref_number: Optional[str]
    trx_date_time: Optional[str]
    account_balance: Optional[int]
    receipt: Optional[str]


class TRFResponse(BaseAccountResponse):
    account_balance: int


# Billing Inquiry
class BaseBLNRequest(BaseModel):
    account_no: str
    amount: int
    product_code: str
    customer_no: str
    product_type: Optional[str]
    biller_code: Optional[str]
    sen_country_id: Optional[str]
    inst_code: Optional[str]


class BaseBilling(BaseAccount):
    product_code: str
    customer_no: str
    amount: int


class BLNRequest(BaseBilling):
    product_type: Optional[str]
    biller_code: Optional[str]
    sen_country_id: Optional[str]
    inst_code: Optional[str]


class BaseBLNResponse(MsgResp):
    product_code: Optional[str]
    product_name: Optional[str]
    product_desc: Optional[str]
    product_image: Optional[str]
    product_type: Optional[str]
    category: Optional[str]
    icon_code: Optional[str]
    biller_code: Optional[str]
    customer_no: Optional[str]
    customer_name: Optional[str]
    amount: Optional[int]
    inq_ref_number: Optional[str]
    fee_amount: Optional[int]
    sen_country_id: Optional[str]
    inst_code: Optional[str]
    billing_info: Optional[str]
    response_data: Optional[str]


class BLNResponse(BaseAccountResponse):
    inq_ref_number: str
    amount: int
    fee_amount: int


# Billing Payment
class BaseBLPRequest(BaseModel):
    account_no: str
    product_code: str
    customer_no: str
    customer_name: Optional[str]
    sen_country_id: Optional[str]
    inst_code: Optional[str]
    inq_ref_number: str
    amount: int
    fee_amount: int
    pin: str
    systraceaudit_fe: Optional[str]
    product_type: Optional[str]
    biller_code: Optional[str]


class BLPRequest(BaseBilling):
    customer_name: Optional[str]
    product_type: Optional[str]
    biller_code: Optional[str]
    sen_country_id: Optional[str]
    inst_code: Optional[str]
    inq_ref_number: str
    amount: int
    fee_amount: int
    enc_pin: str


class BLPResponse(BaseAccountResponse):
    account_balance: int


class BaseBLPResponse(BaseModel):
    response_code: Optional[str]
    response_msg: Optional[str]
    account_no: Optional[str]
    trx_date_time: Optional[str]
    account_balance: Optional[int]
    receipt: Optional[str]


# Billing Advice
class BaseBLARequest(BaseModel):
    account_no: str
    inq_ref_number: str
    product_code: str
    customer_no: str
    systraceaudit_fe: Optional[str]


class BLARequest(BaseBilling):
    inq_ref_number: str


class BLAResponse(BaseAccountResponse):
    customer_name: str
    billing_info: str


class QRData(BaseModel):
    account_no: Optional[str]
    terminal_label: str
    merchant_criteria: str
    additional_field: str
    amount: int
    customer_data: str
    merchant_city: str
    merchant_name: str
    fee_percent: int
    fee_amount: int
    reverse_domain_name: str
    postal_code: str
    currency_code: str
    country_code: str
    merchant_category: str
    merchant_id: str
    pan: str
    fee_indicator: str


class QRGenResponse(MsgResp):
    qr: Optional[str]


# QR Inquiry
class BaseQRNRequest(BaseModel):
    account_no: str
    qr: str
    systraceaudit_fe: Optional[str]


class QRNRequest(BaseAccount):
    qr: str
    systraceaudit_fe: Optional[str]


class BaseQRNResponse(MsgResp):
    qr_data: Optional[QRData]


# QR Payment
class BaseQRPRequest(BaseModel):
    account_no: str
    qr_data: dict
    pin: str
    systraceaudit_fe: Optional[str]


class QRPRequest(BaseAccount):
    qr_data: QRData
    enc_pin: str
    systraceaudit_fe: Optional[str]


class BaseQRPResponse(BaseModel):
    response_code: Optional[str]
    response_msg: Optional[str]
    trx_date_time: Optional[str]
    inq_ref_number: Optional[str]
    account_balance: Optional[int]
    invoiceNumber: Optional[str]
    qr_data: Optional[QRData]


# Cashout – Account Inquiry
class BaseCBRRequest(BaseModel):
    account_no: str
    amount: int
    dest_bank_code: str
    dest_account_no: str
    dest_account_name: Optional[str] = ""
    sen_country_id: Optional[str]


class BaseCashout(BaseAccount):
    dest_bank_code: str
    dest_account_no: str
    sen_country_id: Optional[str]


class CBRRequest(BaseCashout):
    dest_account_name: Optional[str]


class CBRResponse(BaseAccountResponse):
    pass


# Cashout – Fee Inquiry
class BaseCBNRequest(BaseModel):
    account_no: str
    dest_bank_code: str
    dest_account_no: str
    dest_account_name: Optional[str]
    amount: int
    sen_country_id: Optional[str]


class CBNRequest(BaseCashout):
    dest_account_name: str
    amount: int


class CBNResponse(BaseAccountResponse):
    fee_amount: str


# Cashout – Payment
class BaseCBPRequest(BaseModel):
    account_no: str
    dest_bank_code: str
    dest_account_no: str
    dest_account_name: str
    amount: int
    fee_amount: int
    sen_country_id: Optional[str]
    pin: str


class CBPRequest(BaseCashout):
    dest_account_name: str
    amount: int
    fee_amount: int


class CBPResponse(BaseAccountResponse):
    pass


# Reversal
class BaseREVRequest(BaseModel):
    account_no: str
    amount: int


class REVRequest(BaseAccount):
    amount: int


class REVResponse(BaseAccountResponse):
    pass


# Account Register
class CRTRequestDocs(BaseModel):
    nama_nasabah: str = ''
    nama_singkat: str = ''
    jenis_identitas: str = ''
    nomor_identitas: str = ''
    alamat_rumah_jalan: str = ''
    telepon_hp_nomor: str = ''
    nama_ibu_kandung: str = ''
    request_date: str = datetime.now().strftime('%d/%m/%Y')
    tanggal_buka: str = datetime.now().strftime('%d/%m/%Y')
    alamat_email: Optional[str] = '-'
    alamat_rumah_kota_kabupaten: Optional[str] = '-'
    alamat_rumah_kode_pos: Optional[str] = '-'

    '''
    tempat_lahir: Optional[str] = '-'
    tanggal_lahir: Optional[str] = None
    jenis_kelamin: Optional[str] = None
    alamat_rumah_rt: Optional[str] = None
    alamat_rumah_rw: Optional[str] = None
    alamat_rumah_kelurahan: Optional[str] = None
    alamat_rumah_kecamatan: Optional[str] = None
    alamat_rumah_provinsi: Optional[str] = None
    tanggal_berakhir_identitas: str = (datetime.now()+relativedelta(years=10)).strftime('%d/%m/%Y')
    kode_cabang: str = "000"
    agama: str = '1'
    pekerjaan: str = 'R'
    status_perkawinan: str = '1'
    tujuan_penggunaan_dana: str = '4'
    sumber_dana: str = '03'
    penghasilan_utama_per_tahun: str = '1'
    '''


# Account Basic Register
class CRTBasicRequestDocs(BaseModel):
    nama_nasabah: str = ''
    nama_singkat: str = ''
    alamat_email: Optional[str] = '-'
    telepon_hp_nomor: str = ''
    request_date: str = datetime.now().strftime('%d/%m/%Y')
    tanggal_buka: str = datetime.now().strftime('%d/%m/%Y')

    '''
    jenis_identitas: str = ''
    nomor_identitas: str = ''
    alamat_rumah_jalan: str = ''
    nama_ibu_kandung: str = ''
    alamat_rumah_kota_kabupaten: Optional[str] = '-'
    alamat_rumah_kode_pos: Optional[str] = '-'
    tempat_lahir: Optional[str] = '-'
    tanggal_lahir: Optional[str] = None
    jenis_kelamin: Optional[str] = None
    alamat_rumah_rt: Optional[str] = None
    alamat_rumah_rw: Optional[str] = None
    alamat_rumah_kelurahan: Optional[str] = None
    alamat_rumah_kecamatan: Optional[str] = None
    alamat_rumah_provinsi: Optional[str] = None
    tanggal_berakhir_identitas: str = (datetime.now()+relativedelta(years=10)).strftime('%d/%m/%Y')
    kode_cabang: str = "000"
    agama: str = '1'
    pekerjaan: str = 'R'
    status_perkawinan: str = '1'
    tujuan_penggunaan_dana: str = '4'
    sumber_dana: str = '03'
    penghasilan_utama_per_tahun: str = '1'
    '''


class CRTRequest(BaseMsg):
    request_docs: CRTRequestDocs

# Account Upgrade


class CRURequestDocs(BaseModel):
    nama_nasabah: str = ''
    nama_singkat: str = ''
    jenis_identitas: str = ''
    nomor_identitas: str = ''
    alamat_rumah_jalan: str = ''
    telepon_hp_nomor: str = ''
    nama_ibu_kandung: str = ''
    request_date: str = datetime.now().strftime('%d/%m/%Y')
    tanggal_buka: str = datetime.now().strftime('%d/%m/%Y')
    alamat_email: str = None
    tempat_lahir: str = None
    tanggal_lahir: str = None
    jenis_kelamin: str = None
    alamat_rumah_rt: str = None
    alamat_rumah_rw: str = None
    alamat_rumah_kelurahan: str = None
    alamat_rumah_kecamatan: str = None
    alamat_rumah_kota_kabupaten: str = None
    alamat_rumah_provinsi: str = None
    alamat_rumah_kode_pos: str = '-'
    tanggal_berakhir_identitas: str = '01/01/2099'
    kode_cabang: str = "40071"
    agama: str = '1'
    pekerjaan: str = 'R'
    status_perkawinan: str = '1'
    tujuan_penggunaan_dana: str = '4'
    sumber_dana: str = '03'
    penghasilan_utama_per_tahun: str = '1'


class CRURequest(BaseAccount):
    request_docs: CRURequestDocs


class CRTResponseDocs(BaseModel):
    nomor_nasabah: str
    nomor_rekening: str


class CRTResponse(BaseResponse):
    response_docs: CRTResponseDocs


# Request OTP
class BaseOTRRequest(BaseModel):
    account_no: Optional[str]
    jenis_kirim: Optional[str]


class OTRRequest(BaseAccount):
    jenis_kirim: str


class OTRResponse(BaseAccountResponse):
    kode_otp: str
    telepon_hp_nomor: str


class BaseOTRResponse(BaseModel):
    kode_otp: str
    telepon_hp_nomor: str


# Create, Reset PIN
class BaseCRPRequest(BaseModel):
    account_no: str
    pin: str
    jenis_crp: str
    old_pin: Optional[str]
    otp: Optional[str]


class CRPRequest(BaseAccount):
    old_pin: Optional[str]
    otp: Optional[str]
    jenis_crp: str
    enc_pin: str


class CRPResponse(BaseAccountResponse):
    pass


# Wessel Inquiry
class BaseWINRequest(BaseModel):
    account_no: str
    sen_country_id: str
    ben_country_id: str
    amount: int


class WINRequest(BaseAccount):
    sen_country_id: str
    ben_country_id: str
    amount: int


class BaseWINResponse(BaseModel):
    sen_country_id: Optional[str]
    ben_country_id: Optional[str]
    amount: Optional[int]
    fee_amount: Optional[int]


class WINResponse(BaseAccountResponse):
    fee_amount: int


# Wessel Request Docs
class WSLRequestDocs(BaseModel):
    sen_name: str
    sen_city: str
    sen_country_id: str
    sen_address1: Optional[str] = ""
    ben_name: str
    ben_address1: str
    ben_province: str
    ben_city: str
    ben_country_id: str
    ben_phone: Optional[str] = ""
    purpose_code: str

    # sen_address2: Optional[str] = ""
    # sen_phone: Optional[str] = ""
    # sen_email: Optional[str] = ""
    # sen_postcode: Optional[str] = ""
    # sen_place_of_birth: Optional[str] = ""
    # sen_date_of_birth: Optional[str] = ""
    # sen_id_type: Optional[str] = ""
    # sen_id_number: Optional[str] = ""
    # sen_occupation: Optional[str] = ""
    # ben_address2: Optional[str] = ""
    # ben_email: Optional[str] = ""
    # ben_postcode: Optional[str] = ""
    # ben_date_of_birth: Optional[str] = ""
    # ben_id_type: Optional[str] = ""
    # ben_id_number: Optional[str] = ""
    # ben_nationality_id: Optional[str] = ""
    # ben_occupation: Optional[str] = ""
    # ben_bank_code: Optional[str] = ""
    # ben_account_no: Optional[str] = ""
    # source_of_fund: Optional[str] = ""
    # message: Optional[str] = ""
    # question: Optional[str] = ""
    # answer: Optional[str] = ""


# Wessel Posting
class BaseWSLRequest(BaseModel):
    account_no: str
    amount: int
    fee_amount: int
    request_docs: WSLRequestDocs
    pin: str


class WSLRequest(BaseAccount):
    amount: int
    fee_amount: int
    request_docs: WSLRequestDocs
    enc_pin: str


class WSLResponse(BaseAccountResponse):
    ntp: str
    pin: str
    account_balance: int


class BaseWSLResponse(MsgResp):
    inq_ref_number: Optional[str]
    trx_date_time: Optional[str]
    ntp: Optional[str]
    pin: Optional[str]
    account_balance: Optional[int]


# Wessel Trace
class BaseWTRRequest(BaseModel):
    account_no: str
    ntp: str
    # pin: str


class WTRRequest(BaseAccount):
    ntp: str
    # enc_pin: str


class WTRResponse(BaseAccountResponse):
    sen_name: str
    ben_name: str
    amount: int
    status_msg: str
    ref_no: str


class BaseWTRResponse(BaseModel):
    sen_name: Optional[str]
    ben_name: Optional[str]
    amount: Optional[int]
    status_msg: Optional[str]
    ref_no: Optional[str]


# Change Phone Request
class BaseCPRRequest(BaseModel):
    account_no: str
    telepon_hp_nomor: str
    pin: str


class CPRRequest(BaseAccount):
    telepon_hp_nomor: str
    enc_pin: str


class CPRResponse(BaseAccountResponse):
    transaction_id: str


# Change Phone OTP
class BaseCPPPequest(BaseModel):
    account_no: str
    otp_code: str
    transaction_id: str


class CPPPequest(BaseAccount):
    otp_code: str
    transaction_id: str


class CPPResponse(BaseAccountResponse):
    pass


# Token
class BaseToken(BaseAccount):
    kode_kap: str
    enc_pin: str


# Token Inquiry
class BaseTINRequest(BaseModel):
    account_no: str
    kode_kap: str
    pin: str


class TINRequest(BaseToken):
    pass


class TINResponse(BaseAccountResponse):
    info: str


# Token Withdrawal
class BaseTWDRequest(BaseModel):
    account_no: str
    kode_kap: str
    pin: str


class TWDRequest(BaseToken):
    pass


class TWDResponse(BaseAccountResponse):
    pass


# SMS
class BaseSMSRequest(BaseModel):
    phone_number: str
    kode_negara: str
    device_id: str


class SMSRequest(BaseMsg):
    msisdn: str
    message: str


class ValidateOTP(BaseModel):
    phone_number: str
    kode_negara: str
    otpcode: str


class PRCRequest(BaseMsg):
    phone_number: str


class BaseITARequest(BaseModel):
    account_no: str
    amount: int
    token: str
    request_date: str
    merchant: str


class ITARequest(BaseAccount):
    amount: int
    token: str
    request_date: str
    merchant: str
