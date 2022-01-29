from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from schemas import ArsipSurat
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_arsipsurat(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM arsip_surat
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
            'status': 'Gagal, Data Arsip Surat Tidak Ditemukan'
        }

async def get_detail_arsipsurat(db_session: AsyncSession, id_arsipsurat: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM arsip_surat WHERE id = {0}
            '''.format(id_arsipsurat)
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
            'status': 'Gagal, Data Arsip Surat Tidak Ditemukan'
        }

async def add_arsipsurat(db_session: AsyncSession, request: ArsipSurat) -> dict:
    async with db_session as session:
        try:
            id_arsipsurat = await session.execute('''select nextval('arsip_surat_id_seq') as id''')
            id_arsipsurat = id_arsipsurat.one_or_none()
            new_arsipsurat = {}
            new_arsipsurat['id'] = id_arsipsurat.id
            new_arsipsurat['nama_surat'] = request.nama_surat
            new_arsipsurat['nomor_surat'] = request.nomor_surat
            new_arsipsurat['tanggal_surat'] = request.tanggal_surat
            new_arsipsurat['jenis_surat'] = request.jenis_surat
            new_arsipsurat['keterangan'] = request.keterangan
            new_arsipsurat['lampiran'] = request.lampiran
            arsip_surat = generateQuery('arsip_surat', new_arsipsurat)
            logging.debug(f'query : {arsip_surat}')
            await session.execute(arsip_surat)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Succes',
                'data': new_arsipsurat
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

async def edit_arsipsurat(db_session: AsyncSession, request: ArsipSurat, id_arsipsurat: int) -> dict:
    async with db_session as session:
        try:
            if id_arsipsurat is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_arsipsurat = {}
                edit_arsipsurat['nama_surat'] = request.nama_surat
                edit_arsipsurat['nomor_surat'] = request.nomor_surat
                edit_arsipsurat['tanggal_surat'] = request.tanggal_surat
                edit_arsipsurat['jenis_surat'] = request.jenis_surat
                edit_arsipsurat['keterangan'] = request.keterangan
                edit_arsipsurat['lampiran'] = request.lampiran
                arsip_surat = '''
                                update arsip_surat set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_arsipsurat), id_arsipsurat)
                await session.execute(arsip_surat)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_arsipsurat
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

async def delete_arsipsurat(db_session: AsyncSession, id_arsipsurat: int) -> dict:
    async with db_session as session:
        try:
            if id_arsipsurat is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_arsipsurat = '''
                                delete from arsip_surat where id = {0}
                            '''.format(id_arsipsurat)

                await session.execute(delete_arsipsurat)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Arsip Surat Berhasil Dihapus'
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