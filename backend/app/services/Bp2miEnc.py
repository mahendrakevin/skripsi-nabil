#!/opt/local/bin/python

import time
import json
import string
import math
import base64
import requests
import logging
import json
import httpx

from app.core.config import settings
from fastapi import HTTPException


SERVICE_BP2MI_URL = settings.SERVICE_BP2MI_HOST
logger = logging.getLogger(__name__)


class Bp2miEnc:
    TIME_DIFF_LIMIT = 480

    @staticmethod
    def encrypt(json_data, cid, secret):
        t = str(int(time.time()))[::-1]
        return Bp2miEnc.doubleEncrypt(t + "." + json_data, cid, secret)

    @staticmethod
    def decrypt(hased_string, cid, secret):
        parseStr = Bp2miEnc.doubleDecrypt(hased_string, cid, secret)
        data = parseStr.split(".", 1)
        if len(data) == 2:
            strrevtime = data[0][::-1]
            if Bp2miEnc.tsDiff(int(strrevtime)):
                return data[1]

        return None

    @staticmethod
    def tsDiff(ts):
        return math.fabs(ts - time.time()) <= Bp2miEnc.TIME_DIFF_LIMIT

    @staticmethod
    def doubleEncrypt(stringObj, cid, secret):
        result = ''
        result = Bp2miEnc.enc(stringObj, cid)
        result = Bp2miEnc.enc(result, secret)
        # result = result.encode('base64').rstrip('=')
        result = base64.b64encode(result.encode('utf-8'))
        result = str(result, 'utf-8').rstrip('=')
        result = result.translate(str.maketrans('+/', '-_'))
        return result

    @staticmethod
    def enc(string, key):
        result = ""
        strls = len(string)
        strlk = len(key)
        for i in range(0, strls):
            char = string[i:i+1]
            st = (i % strlk) - 1
            xlen = None if st < 0 else st+1
            keychar = key[st:xlen]
            char = chr((ord(char) + ord(keychar)) % 128)
            result += char

        return result

    @staticmethod
    def doubleDecrypt(string, cid, secret):
        ceils = math.ceil(len(string) / 4.0) * 4
        while (len(string) < ceils):
            string += "="

        string = string.replace('-', '+').replace('_', '/')
        # result = string.decode('base64')
        result = base64.b64decode(string)
        result = Bp2miEnc.dec(result, cid)
        result = Bp2miEnc.dec(result, secret)
        return result

    @staticmethod
    def dec(string, key):
        result = ''
        strls = len(string)
        strlk = len(key)
        for i in range(0, strls):
            char = string[i:i+1]
            st = (i % strlk) - 1
            xlen = None if st < 0 else st+1
            keychar = key[st:xlen]
            char = chr((ord(char) - ord(keychar) + 256) % 128)
            result += char

        return result

    @staticmethod
    def post(cid, paspor_in):
        headers = {"Content-Type": "application/json"}
        data = {"client_id": cid, "data": paspor_in}
        data = json.dumps(data)

        # log request
        logger.info(f"SEND BP2MI: {data}")

        try:
            response = requests.post(
                SERVICE_BP2MI_URL, headers=headers, data=data, timeout=30
            )
        except Exception as e:
            err = getattr(e, "message", repr(e))
            raise HTTPException(
                status_code=502, detail=f"unknown gateway error. Details: {err}", source=''
            )
        # --

        # log response
        logger.info(f"RESP BP2MI: {response.json()}")

        return response.json()

    async def post_async(cid, paspor_in):
        timeout = httpx.Timeout(60, connect_timeout=60)
        limits = httpx.PoolLimits(max_keepalive=5, max_connections=20)

        headers = {"Content-Type": "application/json"}
        data = {"client_id": cid, "data": paspor_in}
        data = json.dumps(data)

        # log request
        logger.info(f"SEND BP2MI: {data}")

        async with httpx.AsyncClient(
            timeout=timeout, pool_limits=limits, headers=headers
        ) as client:
            try:
                request = client.build_request(
                    "POST", SERVICE_BP2MI_URL, data=data)
                response = await client.send(request)
            except (ConnectTimeout, ReadTimeout, WriteTimeout, PoolTimeout) as e:
                err = getattr(e, "message", repr(e))
                raise HTTPException(
                    status_code=504, detail=f"Core services timeout error. Details: {err}", source=''
                )
            except Exception as e:
                err = getattr(e, "message", repr(e))
                raise HTTPException(
                    status_code=502, detail=f"unknown gateway error. Details: {err}", source=''
                )
            # --

        # log response
        logger.info(f"RESP BP2MI: {response}")
        logger.info(f"RESP BP2MI: {response.json()}")

        return response.json()


# cid = "002"
# secret = "ef5f60af2dac759e6a6b96caa08aded7"
# # xmap = '{"a":"123","b":"XXsdasudiasuds"}';
# xmap = '{"paspor_no": "AX12345"}'
# decode = Bp2miEnc.decrypt(hashing, cid, secret)
# print(f"Output: \r\n{hashing} \r\nDecode:\r\n{decode}")
# print hashing
# print Bp2miEnc.encrypt("a", "b", "c")
# hashing = Bp2miEnc.encrypt(xmap, cid, secret)
