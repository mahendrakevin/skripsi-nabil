from datetime import datetime
from pydantic import BaseModel
from typing import Optional, List, Any
from schemas.appl import *

def BaseResponse(status):
    return {
        'status': status,
        'err_info': '',
        'message_id': ''
    }

def ErrorResponse(error, err_info):
    return {
        'status': error,
        'err_info': err_info
    }

class MsgRespBase(BaseModel):
    message_id: Optional[str]
    status: Optional[str]
    message: Optional[Any]

class MsgRespNasabahIndividu(MsgRespBase):
    message_id: Optional[str] = '00'
    status: Optional[str] = "Success"
    message: Optional[Any] = "Registrasi nasabah berhasil"
    data: Optional[NasabahIndividuResp]

class MsgRespNasabahIndividuUbah(MsgRespNasabahIndividu):
    message: Optional[Any] = "Ubah data nasabah berhasil"

class MsgRespNasabahIndividuDetail(MsgRespBase):
    message_id: Optional[str] = '00'
    status: Optional[str] = "Success"
    message: Optional[Any] = "Nasabah Individu Detail"
    data: Optional[NasabahIndividuDetResp]