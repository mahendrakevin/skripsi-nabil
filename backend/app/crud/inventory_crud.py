from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Guru
from schemas import DataGuru, DataKepegawaian, EditKepegawaian, Jabatan
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_guru(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_guru
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
            'status': 'Gagal, Data Guru Tidak Ditemukan'
        }

async def get_detail_guru(db_session: AsyncSession, id_guru: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_guru WHERE id = {0}
            '''.format(id_guru)
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
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def add_guru(db_session: AsyncSession, request: DataGuru) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT id, nip FROM data_guru
                            where nip = {0}
                    '''.format(request.nip)
            proxy_rows = await session.execute(q_dep)
            nip = proxy_rows.scalar()
            print(nip)
            if nip is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, NIP Sudah Terdaftar'
                        }
            else:
                id_guru = await session.execute('''select nextval('data_guru_id_seq') as id''')
                id_guru = id_guru.one_or_none()
                new_guru = {}
                new_guru['id'] = id_guru.id
                new_guru['nip'] = request.nip
                new_guru['nuptk'] = request.nuptk
                new_guru['nik'] = request.nik
                new_guru['nama_guru'] = request.nama_guru
                new_guru['tempat_lahir'] = request.tempat_lahir
                new_guru['tanggal_lahir'] = request.tanggal_lahir
                new_guru['jenis_kelamin'] = request.jenis_kelamin
                new_guru['alamat'] = request.alamat
                new_guru['no_hp'] = request.no_hp
                new_guru['email'] = request.email
                new_guru['status_perkawinan'] = request.status_perkawinan
                data_guru = generateQuery('data_guru', new_guru)
                logging.debug(f'query : {data_guru}')
                await session.execute(data_guru)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': new_guru
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

async def edit_guru(db_session: AsyncSession, request: DataGuru, id_guru: int) -> dict:
    async with db_session as session:
        try:
            if id_guru is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_guru = {}
                edit_guru['nip'] = request.nip
                edit_guru['nuptk'] = request.nuptk
                edit_guru['nik'] = request.nik
                edit_guru['nama_guru'] = request.nama_guru
                edit_guru['tempat_lahir'] = request.tempat_lahir
                edit_guru['tanggal_lahir'] = request.tanggal_lahir
                edit_guru['jenis_kelamin'] = request.jenis_kelamin
                edit_guru['alamat'] = request.alamat
                edit_guru['no_hp'] = request.no_hp
                edit_guru['email'] = request.email
                edit_guru['status_perkawinan'] = request.status_perkawinan
                data_guru = '''
                                update data_guru set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_guru), id_guru)
                await session.execute(data_guru)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_guru
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

async def delete_guru(db_session: AsyncSession, id_guru: int) -> dict:
    async with db_session as session:
        try:
            if id_guru is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_guru = '''
                                delete from data_guru where id = {0}
                            '''.format(id_guru)
                delete_kepegawaian = '''
                                        delete from status_kepegawaian where id_guru = {0}
                                    '''.format(id_guru)

                await session.execute(delete_guru)
                await session.execute(delete_kepegawaian)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Guru Berhasil Dihapus'
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