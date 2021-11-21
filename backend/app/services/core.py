import httpx
import requests
import hashlib
import json
import logging
import aiohttp
from httpx._exceptions import ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout
from typing import Generic, TypeVar, Type, Optional
from pydantic import validator, AnyHttpUrl
from datetime import datetime
from jose import JWT as jwt
from fastapi import HTTPException

from core.config import settings
from db import engine
import crud
from . import core_schema as cs

SchemaType = TypeVar("SchemaType", bound=cs.BaseMsg)
SERVICE_CORE_URL = settings.SERVICE_CORE_HOST
ALGORITHM = "HS256"
logger = logging.getLogger(__name__)


def getStan():
    sSQL = engine.execute("select nextval('seq_stannumber') as stan")
    stan = [row[0] for row in sSQL]
    return stan[0]


def getSysTraceAudit():
    return datetime.now().strftime("%y%m%d") + str(getStan()).zfill(6)
# --


def encPassword(client_secret_input):
    hash_object = hashlib.sha1(client_secret_input.encode())
    hashed_client_secret = hash_object.hexdigest()
    return hashed_client_secret


def createBaseRequest(model: Generic[SchemaType], trx_type, obj_in={}):
    systraceaudit_fe = obj_in.get('systraceaudit_fe', '')
    request = model(
        **{
            "client_id": settings.SERVICE_CORE_CLIENT_ID,
            "trx_type": trx_type,
            "trx_date_time": datetime.now().strftime("%Y%m%d%H%M%S"),
            "system_trace_audit": systraceaudit_fe if systraceaudit_fe != '' else getSysTraceAudit(),
            "pos_terminal_type": "6001",  # "001", modified by KL for testing
            "sign": "-",
        },
        **obj_in,
    )
    return request


def signature(payload):
    del payload["sign"]
    signature = jwt.encode(
        payload, settings.SERVICE_CORE_SECRET_KEY, ALGORITHM)
    return signature


async def post_async_dev(data: Type[SchemaType]):
    data.sign = signature(data.dict())
    timeout = httpx.Timeout(120, connect_timeout=120)
    limits = httpx.PoolLimits(max_keepalive=5, max_connections=20)

    # log request
    req_data = json.loads(data.json())
    logger.info(f"SEND CORE:  {req_data}")

    headers = {"Content-Type": "application/json"}
    async with httpx.AsyncClient(
        timeout=timeout, pool_limits=limits, headers=headers
    ) as client:
        try:
            request = client.build_request(
                "POST", SERVICE_CORE_URL, data=data.json())
            response = await client.send(request)
        except (ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout) as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=504, 
                detail=f"Core services timeout error. Details: {err}",
                source='core'
            )
        except Exception as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=502, 
                detail=f"unknown gateway error. Details: {err}",
                source='core'
            )
        # --

    # log response
    logger.info(f"RESP CORE: {response.json()}")

    return response.json()


async def post_async(data: dict):
    #data.sign = signature(data.dict())

    # log request
    #req_data = json.loads(data.json())
    req_data = data
    logger.info(f"SEND CORE:  {req_data}")

    headers = {"Content-Type": "application/json"}
    async with aiohttp.ClientSession(headers=headers) as session:
        try:
            async with session.post(settings.SERVICE_CORE_HOST, json=req_data) as r:
                resp = await r.read()
                print(resp)
                response = json.loads(resp)
        except (ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout) as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=68, 
                detail=f"Core services timeout error. Details: {err}",
                source='core'
            )
        except Exception as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=91, 
                detail=f"unknown gateway error. Details: {err}",
                source='core'
            )
        # --
    # --

    # log response
    logger.info(f"RESP CORE: {response}")

    return response

async def post_async_refund(data: dict):
    #data.sign = signature(data.dict())

    # log request
    #req_data = json.loads(data.json())
    req_data = data
    logger.info(f"SEND CORE:  {req_data}")

    headers = {"Content-Type": "application/json"}
    async with aiohttp.ClientSession(headers=headers) as session:
        try:
            async with session.post(settings.SERVICE_CORE_HOST_REFUND, json=req_data) as r:
                resp = await r.read()
                print(resp)
                response = json.loads(resp)
        except (ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout) as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=504, 
                detail=f"Core services timeout error. Details: {err}",
                source='core'
            )
        except Exception as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=502, 
                detail=f"unknown gateway error. Details: {err}",
                source='core'
            )
        # --
    # --

    # log response
    logger.info(f"RESP CORE: {response}")

    return response

async def post_async_liveness(data: dict, headers: dict, url: AnyHttpUrl):
    #data.sign = signature(data.dict())

    # log request
    #req_data = json.loads(data.json())
    req_data = data
    logger.info(f"SEND ASLIRI:  {req_data}")

    #headers = {"Content-Type": "application/json"}
    async with aiohttp.ClientSession(headers=headers) as session:
        try:
            async with session.post(url, headers=headers, data=data) as r:
                resp = await r.read()
                print(resp)
                response = json.loads(resp)
        except (ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout) as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=504, 
                detail=f"Core services timeout error. Details: {err}"
            )
        except Exception as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=502, 
                detail=f"unknown gateway error. Details: {err}"
            )
        # --
    # --

    # log response
    logger.info(f"RESP CORE: {response}")

    return response

def post(data: Type[SchemaType]):
    data.sign = signature(data.dict())
    headers = {"Content-Type": "application/json"}

    # log request
    req_data = json.loads(data.json())
    logger.info(f"SEND CORE:  {req_data}")

    try:
        response = requests.post(
            SERVICE_CORE_URL, headers=headers, data=data.json(), timeout=30
        )
    except Exception as e:
        err = getattr(e, "message", repr(e))
        raise HTTPException(
            status_code=502, detail=f"unknown gateway error. Details: {err}"
        )
    # --

    # log response
    logger.info(f"RESP CORE: {response.json()}")

    return response.json()


# asynchronous function
async def balance_inquiry_async(account_no):
    return await post_async(
        createBaseRequest(cs.BINRequest, "BIN", {"account_no": account_no})
    )


# asynchronous function
async def balance_inquiry_async_dev(account_no):
    return await post_async_dev(
        createBaseRequest(cs.BINRequest, "BIN", {"account_no": account_no})
    )


async def customer_inquiry_async(account_no):
    return await post_async(
        createBaseRequest(cs.CIFRequest, "CIF", {"account_no": account_no})
    )


async def history_date_async(account_no, date_start, date_end):
    return await post_async(
        createBaseRequest(
            cs.HINRequestDate,
            "HIN",
            {
                "account_no": account_no,
                "inquiry_type": "D",
                "date_start": date_start,
                "date_end": date_end,
            },
        )
    )


async def history_last_async(account_no, recent_no=20):
    return await post_async(
        createBaseRequest(
            cs.HINRequestRecent,
            "HIN",
            {"account_no": account_no, "inquiry_type": "R", "recent_no": recent_no},
        )
    )


async def history_page_async(account_no, date_start, date_end, page_no, row_no):
    return await post_async(
        createBaseRequest(
            cs.HINRequestPage,
            "HIN",
            {
                "account_no": account_no,
                "inquiry_type": "P",
                "date_start": date_start,
                "date_end": date_end,
                "page_no": page_no,
                "row_no": row_no,
            },
        )
    )


async def kap_request_async(account_no, amount, sen_country_id):
    return await post_async(
        createBaseRequest(
            cs.KARRequest,
            "KAR",
            {
                "account_no": account_no,
                "amount": amount,
                "sen_country_id": sen_country_id
            }
        )
    )


async def itk_request_async(account_no, amount, pin, sen_country_id):
    return await post_async(
        createBaseRequest(
            cs.ITKRequest,
            "ITK",
            {
                "trx_code": "CASHOUT",
                "account_no": account_no,
                "amount": amount,
                "sen_country_id": sen_country_id,
                "enc_pin": pin
            }
        )
    )


async def change_phone_request_async(account_no, telepon_hp_nomor, pin):
    enc_pin = encPassword(account_no+pin)
    return await post_async(
        createBaseRequest(
            cs.CPRRequest,
            "CPR",
            {
                "account_no": account_no,
                "telepon_hp_nomor": telepon_hp_nomor,
                "enc_pin": enc_pin,
            }
        )
    )


async def change_phone_otp_async(account_no, otp_code, transaction_id):
    return await post_async(
        createBaseRequest(
            cs.CPPPequest,
            "CPP",
            {
                "account_no": account_no,
                "otp_code": otp_code,
                "transaction_id": transaction_id,
            }
        )
    )


async def pin_management_async(account_no, msg):
    enc_pin = msg['pin']  # encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "jenis_crp": msg['jenis_crp'],
        "enc_pin": enc_pin
    }

    if msg.get('old_pin') and msg['jenis_crp'] == "C":
        old_pin = msg['old_pin']
        oData['old_pin'] = old_pin

    # if msg.get('otp') and msg['jenis_crp'] != "C":
    #     oData['otp'] = msg['otp']

    return await post_async(createBaseRequest(cs.CRPRequest, "CRP", oData))


async def account_inquiry_async(account_no, msg):
    return await post_async(
        createBaseRequest(
            cs.AINRequest, "AIN", {
                "account_no": account_no,
                "dest_account_no": msg['dest_account_no'],
                "amount": msg['amount'],
                "dest_bank_code": msg["dest_bank_code"],
                "sen_country_id": msg['sen_country_id'],
                "recp_country_id": msg['recp_country_id'],
            }
        )
    )


async def cashout_billing_inquiry_async(account_no, msg):
    oData = {
        'account_no': account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "amount": msg['amount'],
        "sen_country_id": msg['sen_country_id'],
    }
    # Conditional Parameters
    if msg.get('dest_account_name', ''):
        oData['dest_account_name'] = msg['dest_account_name']

    return await post_async(createBaseRequest(cs.CBRRequest, "CBR", oData))


async def cashout_fee_inquiry_async(account_no, msg):
    oData = {
        'account_no': account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "dest_account_name": msg['dest_account_name'],
        "amount": msg['amount'],
        "sen_country_id": msg['sen_country_id'],
    }
    return await post_async(createBaseRequest(cs.CBNRequest, "CBN", oData))


async def transfer_async(account_no, msg):
    enc_pin = msg['pin']
    oData = {
        "account_no": account_no,
        "dest_account_no": msg['dest_account_no'],
        "amount": msg['amount'],
        "dest_bank_code": msg["dest_bank_code"],
        "fee_amount": msg['fee_amount'],
        "description": msg['description'],
        "sen_country_id": msg['sen_country_id'],
        "recp_country_id": msg['recp_country_id'],
        "enc_pin": enc_pin,
    }

    # Conditional Parameters
    if msg.get('dest_customer_name'):
        oData['dest_customer_name'] = msg['dest_customer_name']
    if msg.get('dest_bank_name'):
        oData['dest_bank_name'] = msg['dest_bank_name']
    if msg.get('inq_ref_number'):
        oData['inq_ref_number'] = msg['inq_ref_number']

    return await post_async(createBaseRequest(cs.TRFRequest, "TRF", oData))


async def cashout_payment_async(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "dest_account_name": msg['dest_account_name'],
        "amount": msg['amount'],
        "fee_amount": msg['fee_amount'],
        "enc_pin": enc_pin,
        "sen_country_id": msg['sen_country_id'],
    }
    return await post_async(createBaseRequest(cs.CBPRequest, "CBP", oData))


async def wessel_fee_inquiry_async(account_no, msg):
    oData = {
        "account_no": account_no,
        "sen_country_id": msg['sen_country_id'],
        "ben_country_id": msg['ben_country_id'],
        "amount": msg['amount']
    }
    return await post_async(createBaseRequest(cs.WINRequest, "WIN", oData))


async def wessel_async(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "fee_amount": msg['fee_amount'],
        "amount": msg['amount'],
        "request_docs": msg['request_docs'],
        "enc_pin": enc_pin,
    }

    return await post_async(createBaseRequest(cs.WSLRequest, "WSL", oData))


async def billing_inquiry_async(account_no, msg):
    oData = {
        "account_no": account_no,
        "amount": msg['amount'],
        "product_code": msg['product_code'],
        "customer_no": msg['customer_no'],
        "product_type": msg.get('product_type'),
        "biller_code": msg.get('biller_code', 'POS'),
        "sen_country_id": msg.get('sen_country_id', 'ID'),
        "inst_code": msg.get('inst_code', '')
    }

    reqData = createBaseRequest(cs.BLNRequest, "BLN", oData)

    if reqData.inst_code in [None, '']:
        del reqData.inst_code
    # --

    return await post_async(reqData)


async def billing_payment_async(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "product_code": msg['product_code'],
        'product_type': msg.get('product_type', ''),
        'biller_code': msg.get('biller_code', ''),
        "customer_no": msg['customer_no'],
        'inq_ref_number': msg['inq_ref_number'],
        "amount": msg['amount'],
        'fee_amount': msg['fee_amount'],
        'systraceaudit_fe': msg.get('systraceaudit_fe', ''),
        'sen_country_id': msg.get('sen_country_id', ''),
        'customer_name': msg.get('customer_name', ''),
        'inst_code': msg.get('inst_code', ''),
        'enc_pin': enc_pin,
    }

    reqData = createBaseRequest(cs.BLPRequest, "BLP", oData)

    if reqData.inst_code in [None, '']:
        del reqData.inst_code
    # --

    return await post_async(reqData)


async def billing_advice_async(account_no, msg):
    oData = {
        "account_no": account_no,
        'inq_ref_number': msg['inq_ref_number'],
        "product_code": msg['product_code'],
        "customer_no": msg['customer_no'],
        'systraceaudit_fe': msg.get('systraceaudit_fe', ''),
    }
    return await post_async(createBaseRequest(cs.BLARequest, "BLA", oData))


async def nik_inquiry_async(nik):
    return await post_async(createBaseRequest(cs.NIKRequest, "KTP", {"nik": nik}))


async def phone_check_async(phone_number):
    return await post_async(
        createBaseRequest(
            cs.PRCRequest,
            "PRC",
            {
                "phone_number": phone_number
            }
        )
    )


async def account_register_async(request_docs):
    return await post_async(
        createBaseRequest(
            cs.CRTRequest, "CRT", {"request_docs": request_docs}
        )
    )


async def account_upgrade_async(account_no, request_docs):
    return await post_async(
        createBaseRequest(
            cs.CRURequest, "CRU", {
                "account_no": account_no, "request_docs": request_docs}
        )
    )


async def qr_inquiry_async(account_no, qr, systraceaudit_fe):
    oData = {
        "account_no": account_no,
        "qr": qr,
        "systraceaudit_fe": systraceaudit_fe,
    }

    return await post_async(createBaseRequest(cs.QRNRequest, "QRN", oData))


async def qr_payment_async(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        'qr_data': msg['qr_data'],
        'systraceaudit_fe': msg.get('systraceaudit_fe', ''),
        'enc_pin': enc_pin,
    }

    return await post_async(createBaseRequest(cs.QRPRequest, "QRP", oData))


# synchronous function
def balance_inquiry(account_no):
    return post(createBaseRequest(cs.BINRequest, "BIN", {"account_no": account_no}))


def history_last(account_no, recent_no=20):
    return post(
        createBaseRequest(
            cs.HINRequest,
            "HIN",
            {"account_no": account_no, "inquiry_type": "R", "recent_no": recent_no},
        )
    )


def history_date(account_no, date_start, date_end):
    return post(
        createBaseRequest(
            cs.HINRequest,
            "HIN",
            {
                "account_no": account_no,
                "inquiry_type": "D",
                "date_start": date_start,
                "date_end": date_end,
                "recent_no": 5,
            },
        )
    )


def nik_inquiry(nik):
    return post(createBaseRequest(cs.NIKRequest, "KTP", {"nik": nik}))


def customer_inquiry(account_no):
    return post(createBaseRequest(cs.CIFRequest, "CIF", {"account_no": account_no}))


def kap_request(account_no, amount, sen_country_id):
    return post(
        createBaseRequest(
            cs.KARRequest,
            "KAR",
            {
                "account_no": account_no,
                "amount": amount,
                "sen_country_id": sen_country_id
            }
        )
    )


def itk_request(account_no, amount, pin, sen_country_id):
    return post(
        createBaseRequest(
            cs.ITKRequest,
            "ITK",
            {
                "trx_code": "CASHOUT",
                "account_no": account_no,
                "amount": amount,
                "sen_country_id": sen_country_id,
                "enc_pin": pin
            }
        )
    )


def account_inquiry(account_no, msg):
    return post(
        createBaseRequest(
            cs.AINRequest, "AIN", {
                "account_no": account_no,
                "dest_account_no": msg['dest_account_no'],
                "amount": msg['amount'],
                "dest_bank_code": msg["dest_bank_code"],
                "sen_country_id": msg['sen_country_id'],
            }
        )
    )


def transfer(account_no, msg):
    enc_pin = msg['pin']
    oData = {
        "account_no": account_no,
        "dest_account_no": msg['dest_account_no'],
        "amount": msg['amount'],
        "dest_bank_code": msg["dest_bank_code"],
        "fee_amount": msg['fee_amount'],
        "description": msg['description'],
        "enc_pin": enc_pin,
    }

    # Conditional Parameters
    if msg.get('dest_customer_name'):
        oData['dest_customer_name'] = msg['dest_customer_name']
    if msg.get('dest_bank_name'):
        oData['dest_bank_name'] = msg['dest_bank_name']
    if msg.get('inq_ref_number'):
        oData['inq_ref_number'] = msg['inq_ref_number']

    return post(createBaseRequest(cs.TRFRequest, "TRF", oData))


def billing_inquiry(account_no, msg):
    oData = {
        "account_no": account_no,
        "amount": msg['amount'],
        "product_code": msg['product_code'],
        "customer_no": msg['customer_no'],
        "product_type": msg.get('product_type'),
        "biller_code": msg.get('biller_code'),
    }

    # Conditional Parameters
    if msg.get('sen_country_id'):
        oData['sen_country_id'] = msg['sen_country_id']

    return post(createBaseRequest(cs.BLNRequest, "BLN", oData))


def billing_payment(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "product_code": msg['product_code'],
        "customer_no": msg['customer_no'],
        'inq_ref_number': msg['inq_ref_number'],
        "amount": msg['amount'],
        'fee_amount': msg['fee_amount'],
        'systraceaudit_fe': msg.get('systraceaudit_fe', ''),
        'enc_pin': enc_pin,
    }
    # Conditional Parameters
    if msg.get('sen_country_id'):
        oData['sen_country_id'] = msg['sen_country_id']
    return post(createBaseRequest(cs.BLPRequest, "BLP", oData))


def billing_advice(account_no, msg):
    oData = {
        'inq_ref_number': msg['inq_ref_number'],
        "product_code": msg['product_code'],
        "customer_no": msg['customer_no'],
        'systraceaudit_fe': msg.get('systraceaudit_fe', ''),
    }
    return post(createBaseRequest(cs.BLARequest, "BLA", oData))


def cashout_billing_inquiry(account_no, msg):
    oData = {
        'account_no': account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "amount": msg['amount'],
    }
    # Conditional Parameters
    if msg.get('dest_account_name', ''):
        oData['dest_account_name'] = msg['dest_account_name']
    return post(createBaseRequest(cs.CBRRequest, "CBR", oData))


def cashout_fee_inquiry(account_no, msg):
    oData = {
        'account_no': account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "dest_account_name": msg['dest_account_name'],
        "amount": msg['amount'],
    }
    return post(createBaseRequest(cs.CBNRequest, "CBN", oData))


def cashout_payment(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        'dest_bank_code': msg['dest_bank_code'],
        "dest_account_no": msg['dest_account_no'],
        "dest_account_name": msg['dest_account_name'],
        "amount": msg['amount'],
        "fee_amount": msg['fee_amount'],
        "enc_pin": enc_pin,
    }
    return post(createBaseRequest(cs.CBPRequest, "CBP", oData))


def reversal(account_no, amount):
    return post(
        createBaseRequest(
            cs.REVRequest, "REV",
            {
                "account_no": account_no,
                "amount": amount
            }
        )
    )


def account_register(request_docs):
    return post(
        createBaseRequest(
            cs.CRTRequest, "CRT", {"request_docs": request_docs}
        )
    )


def otp_request(account_no, jenis_kirim):
    return post(
        createBaseRequest(
            cs.OTRRequest, "OTR",
            {
                "account_no": account_no,
                "jenis_kirim": jenis_kirim
            }
        )
    )


def pin_management(account_no, msg):
    enc_pin = msg['pin']  # encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "jenis_crp": msg['jenis_crp'],
        "enc_pin": enc_pin
    }

    if msg.get('old_pin') and msg['jenis_crp'] == "C":
        old_pin = msg['old_pin']
        oData['old_pin'] = old_pin

    # if msg.get('otp') and msg['jenis_crp'] != "C":
    #     oData['otp'] = msg['otp']

    return post(createBaseRequest(cs.CRPRequest, "CRP", oData))


def wessel_fee_inquiry(account_no, msg):
    oData = {
        "account_no": account_no,
        "sen_country_id": msg['sen_country_id'],
        "ben_country_id": msg['ben_country_id'],
        "amount": msg['amount']
    }
    return post(createBaseRequest(cs.WINRequest, "WIN", oData))


def wessel(account_no, msg):
    enc_pin = encPassword(account_no+msg.get('pin', ''))
    oData = {
        "account_no": account_no,
        "fee_amount": msg['fee_amount'],
        "amount": msg['amount'],
        "request_docs": msg['request_docs'],
        "enc_pin": enc_pin,
    }
    return post(createBaseRequest(cs.WSLRequest, "WSL", oData))


def wessel_trace(account_no, ntp):
    # def wessel_trace(account_no, ntp, pin):
    # enc_pin = encPassword(account_no+pin)
    return post(
        createBaseRequest(
            cs.WTRRequest,
            "WTR",
            {
                "account_no": account_no,
                "ntp": ntp,
                # "enc_pin": enc_pin,
            }
        )
    )


def change_phone_request(account_no, telepon_hp_nomor, pin):
    enc_pin = encPassword(account_no+pin)
    return post(
        createBaseRequest(
            cs.CPRRequest,
            "CPR",
            {
                "account_no": account_no,
                "telepon_hp_nomor": telepon_hp_nomor,
                "enc_pin": enc_pin,
            }
        )
    )


def change_phone_otp(account_no, otp_code, transaction_id):
    return post(
        createBaseRequest(
            cs.CPPPequest,
            "CPP",
            {
                "account_no": account_no,
                "otp_code": otp_code,
                "transaction_id": transaction_id,
            }
        )
    )


def token_inquiry(account_no, kode_kap, pin):
    enc_pin = encPassword(account_no+pin)
    return post(
        createBaseRequest(
            cs.TINRequest,
            "TIN",
            {
                "account_no": account_no,
                "kode_kap": kode_kap,
                "enc_pin": enc_pin,
            }
        )
    )


def token_withdrawal(account_no, kode_kap, pin):
    enc_pin = encPassword(account_no+pin)
    return post(
        createBaseRequest(
            cs.TWDRequest,
            "TWD",
            {
                "account_no": account_no,
                "kode_kap": kode_kap,
                "enc_pin": enc_pin,
            }
        )
    )


def send_sms(msisdn, message):
    return post(
        createBaseRequest(
            cs.SMSRequest,
            "SMS",
            {
                "msisdn": msisdn,
                "message": message,
            }
        )
    )


def phone_check(phone_number):
    return post(
        createBaseRequest(
            cs.PRCRequest,
            "PRC",
            {
                "phone_number": phone_number
            }
        )
    )


def account_upgrade(account_no, request_docs):
    return post(
        createBaseRequest(
            cs.CRURequest, "CRU", {
                "account_no": account_no, "request_docs": request_docs}
        )
    )


def cashout_trace(account_no, msg):
    return post(
        createBaseRequest(
            cs.ITARequest, "ITA", {
                "account_no": account_no,
                "amount": msg.get('amount'),
                "token": msg.get('token'),
                "request_date": msg.get('request_date'),
                "merchant": msg.get('merchant')}
        )
    )
