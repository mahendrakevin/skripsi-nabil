from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from schemas import PembayaranSiswa
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_pembayaransiswa(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM status_pembayaran
                limit {0}
                offset {1}
            '''.format(show, offset)
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()

            # commit the db transaction
            await session.commit()

        except gevent.Timeout:
            await session.invalidate()
            return {
                'message_id': '02',
                'status': 'Failed, DB transaction was time out...'
            }

        except SQLAlchemyError as e:
            logger.info(e)
            await session.rollback()
            return {
                'message_id': '02',
                'status': 'Failed, something wrong rollback DB transaction...'
            }

    # result data handling
    if result:
        logger.info(str(result))
        return {
            'message_id': '00',
            'status': 'Succes',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Pembayaran Tidak Ditemukan'
        }

async def get_detail_pembayaransiswa(db_session: AsyncSession, id_pembayaransiswa: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM status_pembayaran WHERE id = {0}
            '''.format(id_pembayaransiswa)
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.one_or_none()

        except gevent.Timeout:
            await session.invalidate()
            return {
                'message_id': '02',
                'status': 'Failed, DB transaction was time out...'
            }

        except SQLAlchemyError as e:
            logger.info(e)
            await session.rollback()
            return {
                'message_id': '02',
                'status': 'Failed, something wrong rollback DB transaction...'
            }

    # result data handling
    if result:
        logger.info(str(result))
        return {
            'message_id': '00',
            'status': 'Succes',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Pembayaran Tidak Ditemukan'
        }

async def add_pembayaransiswa(db_session: AsyncSession, request: PembayaranSiswa) -> dict:
    async with db_session as session:
        try:
            id_pembayaransiswa = await session.execute('''select nextval('status_pembayaran_id_seq') as id''')
            id_pembayaransiswa = id_pembayaransiswa.one_or_none()
            new_pembayaransiswa = {}
            new_pembayaransiswa['id'] = id_pembayaransiswa.id
            new_pembayaransiswa['id_pendaftaran'] = request.id_pendaftaran
            new_pembayaransiswa['nominal_pembayaran'] = request.nominal_pembayaran
            new_pembayaransiswa['status_pembayaran'] = request.status_pembayaran
            new_pembayaransiswa['id_jenis_pembayaran'] = request.id_jenis_pembayaran
            status_pembayaran = generateQuery('status_pembayaran', new_pembayaransiswa)
            logging.debug(f'query : {status_pembayaran}')
            await session.execute(status_pembayaran)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Succes',
                'data': new_pembayaransiswa
            }

        except gevent.Timeout:
            await session.invalidate()
            return {
                'message_id': '02',
                'status': 'Failed, DB transaction was time out...'
            }

        except SQLAlchemyError as e:
            logger.info(e)
            await session.rollback()
            return {
                'message_id': '02',
                'status': 'Failed, something wrong rollback DB transaction...'
            }

async def edit_pembayaransiswa(db_session: AsyncSession, request: PembayaranSiswa, id_pembayaransiswa: int) -> dict:
    async with db_session as session:
        try:
            if id_pembayaransiswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_pembayaransiswa = {}
                edit_pembayaransiswa['id_pendaftaran'] = request.id_pendaftaran
                edit_pembayaransiswa['nominal_pembayaran'] = request.nominal_pembayaran
                edit_pembayaransiswa['status_pembayaran'] = request.status_pembayaran
                edit_pembayaransiswa['id_jenis_pembayaran'] = request.id_jenis_pembayaran
                status_pembayaran = '''
                                update status_pembayaran set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_pembayaransiswa), id_pembayaransiswa)
                await session.execute(status_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_pembayaransiswa
                }

        except gevent.Timeout:
            await session.invalidate()
            return {
                'message_id': '02',
                'status': 'Failed, DB transaction was time out...'
            }

        except SQLAlchemyError as e:
            logger.info(e)
            await session.rollback()
            return {
                'message_id': '02',
                'status': 'Failed, something wrong rollback DB transaction...'
            }

async def delete_pembayaransiswa(db_session: AsyncSession, id_pembayaransiswa: int) -> dict:
    async with db_session as session:
        try:
            if id_pembayaransiswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_pembayaransiswa = '''
                                delete from status_pembayaran where id = {0}
                            '''.format(id_pembayaransiswa)
                await session.execute(delete_pembayaransiswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Pembayaran Berhasil Dihapus'
                }

        except gevent.Timeout:
            await session.invalidate()
            return {
                'message_id': '02',
                'status': 'Failed, DB transaction was time out...'
            }

        except SQLAlchemyError as e:
            logger.info(e)
            await session.rollback()
            return {
                'message_id': '02',
                'status': 'Failed, something wrong rollback DB transaction...'
            }

