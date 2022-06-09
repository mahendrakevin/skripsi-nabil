from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Kelas
from schemas import DataKelas
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_kelas(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_kelas
                
            '''
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
            'status': 'Sukses',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Kelas Tidak Ditemukan'
        }

async def get_detail_kelas(db_session: AsyncSession, id_kelas: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_kelas WHERE id = {0}
            '''.format(id_kelas)
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
            'status': 'Sukses',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Kelas Tidak Ditemukan'
        }

async def add_kelas(db_session: AsyncSession, request: DataKelas) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT nama_kelas FROM data_kelas
                            where LOWER(nama_kelas) = LOWER('{0}')
                    '''.format(request.nama_kelas)
            proxy_rows = await session.execute(q_dep)
            nama_kelas = proxy_rows.scalar()
            if nama_kelas is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Nama Kelas Sudah Ada'
                        }
            else:
                id_kelas = await session.execute('''select nextval('data_kelas_id_seq') as id''')
                id_kelas = id_kelas.one_or_none()
                new_kelas = {}
                new_kelas['id'] = id_kelas.id
                new_kelas['nama_kelas'] = request.nama_kelas
                new_kelas['tingkat'] = request.tingkat
                new_kelas['kapasitas_kelas'] = request.kapasitas_kelas
                new_kelas['id_wali_kelas'] = request.id_wali_kelas
                data_kelas = generateQuery('data_kelas', new_kelas)
                logging.debug(f'query : {data_kelas}')
                await session.execute(data_kelas)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_kelas
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

async def edit_kelas(db_session: AsyncSession, request: DataKelas, id_kelas: int) -> dict:
    async with db_session as session:
        try:
            if id_kelas is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_kelas = {}
                edit_kelas['nama_kelas'] = request.nama_kelas
                edit_kelas['tingkat'] = request.tingkat
                edit_kelas['kapasitas_kelas'] = request.kapasitas_kelas
                edit_kelas['id_wali_kelas'] = request.id_wali_kelas
                data_kelas = '''
                                update data_kelas set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_kelas), id_kelas)
                await session.execute(data_kelas)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_kelas
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

async def delete_kelas(db_session: AsyncSession, id_kelas: int) -> dict:
    async with db_session as session:
        try:
            if id_kelas is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_kelas = '''
                                delete from data_kelas where id = {0}
                            '''.format(id_kelas)
                await session.execute(delete_kelas)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Kelas Berhasil Dihapus'
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

