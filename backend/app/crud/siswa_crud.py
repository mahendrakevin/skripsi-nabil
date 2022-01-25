from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Siswa
from schemas import DataSiswa
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_siswa(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_siswa
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
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def get_detail_siswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_siswa WHERE id = {0}
            '''.format(id_siswa)
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

async def add_siswa(db_session: AsyncSession, request: DataSiswa) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT id, nisn FROM data_siswa
                            where nisn = {0}
                    '''.format(request.nisn)
            proxy_rows = await session.execute(q_dep)
            nisn = proxy_rows.scalar()
            print(nisn)
            if nisn is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, NISN Sudah Terdaftar'
                        }
            else:
                nis = await session.execute('''select nextval('nis_seq') as id''')
                nis = nis.one_or_none()
                id_siswa = await session.execute('''select nextval('data_siswa_id') as id''')
                id_siswa = id_siswa.one_or_none()
                new_siswa = {}
                new_siswa['id'] = id_siswa.id
                new_siswa['nisn'] = request.nisn
                new_siswa['nis'] = nis.id
                new_siswa['nama_siswa'] = request.nama_siswa
                new_siswa['tempat_lahir'] = request.tempat_lahir
                new_siswa['tanggal_lahir'] = str(request.tanggal_lahir)
                new_siswa['jenis_kelamin'] = request.jenis_kelamin
                new_siswa['nik'] = request.nik
                new_siswa['id_kelas'] = request.id_kelas
                new_siswa['status_siswa'] = request.status_siswa
                new_siswa['nomor_kip'] = request.nomor_kip
                new_siswa['alamat'] = request.alamat
                new_siswa['nomor_kk'] = request.nomor_kk
                new_siswa['nama_kepalakeluarga'] = request.nama_kepalakeluarga
                data_siswa = generateQuery('data_siswa', new_siswa)
                logging.debug(f'query : {data_siswa}')
                await session.execute(data_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': new_siswa
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

async def edit_siswa(db_session: AsyncSession, request: DataSiswa, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_siswa = {}
                edit_siswa['nisn'] = request.nisn
                edit_siswa['nama_siswa'] = request.nama_siswa
                edit_siswa['tempat_lahir'] = request.tempat_lahir
                edit_siswa['tanggal_lahir'] = str(request.tanggal_lahir)
                edit_siswa['jenis_kelamin'] = request.jenis_kelamin
                edit_siswa['nik'] = request.nik
                edit_siswa['id_kelas'] = request.id_kelas
                edit_siswa['status_siswa'] = request.status_siswa
                edit_siswa['nomor_kip'] = request.nomor_kip
                edit_siswa['alamat'] = request.alamat
                edit_siswa['nomor_kk'] = request.nomor_kk
                edit_siswa['nama_kepalakeluarga'] = request.nama_kepalakeluarga
                data_siswa = '''
                                update data_siswa set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_siswa), id_siswa)
                await session.execute(data_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_siswa
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

async def delete_siswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_siswa = '''
                                delete from data_siswa where id = {0}
                            '''.format(id_siswa)
                await session.execute(delete_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Siswa Berhasil Dihapus'
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

