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

# Kepegawaian

async def get_list_kepegawaian(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM status_kepegawaian
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
            'status': 'Gagal, Data Kepegawaian Tidak Ditemukan'
        }

async def get_detail_kepegawaian(db_session: AsyncSession, id_guru: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM status_kepegawaian WHERE id_guru = {0}
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
            'status': 'Success',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def add_kepegawaian(db_session: AsyncSession, request: DataKepegawaian) -> dict:
    async with db_session as session:
        try:
            guru_id = '''
                            SELECT dg.id, sk.id_guru FROM status_kepegawaian sk
                            INNER JOIN data_guru dg ON sk.id_guru = dg.id
                            where dg.id = {0}
                    '''.format(request.id_guru)
            proxy_rows = await session.execute(guru_id)
            id_guru_kepegawaian = proxy_rows.one_or_none()

            if id_guru_kepegawaian is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Guru Sudah Memiliki Status Kepegawaian'
                        }
            else:
                id_kepegawaian = await session.execute('''select nextval('status_kepegawaian_id_seq') as id''')
                id_kepegawaian = id_kepegawaian.one_or_none()
                new_kepegawaian = {}
                new_kepegawaian['id'] = id_kepegawaian.id
                new_kepegawaian['id_guru'] = request.id_guru
                new_kepegawaian['no_sk'] = request.no_sk
                new_kepegawaian['no_sk_ypmnu'] = request.no_sk_ypmnu
                new_kepegawaian['no_sk_operator'] = request.no_sk_operator
                new_kepegawaian['id_jabatan'] = request.id_jabatan
                new_kepegawaian['status_kepegawaian'] = request.status_kepegawaian
                new_kepegawaian['alasan_tidak_aktif'] = request.alasan_tidak_aktif
                new_kepegawaian['surat_mutasi'] = request.surat_mutasi
                new_kepegawaian['jumlah_ajar'] = request.jumlah_ajar
                data_kepegawaian = generateQuery('status_kepegawaian', new_kepegawaian)
                logging.debug(f'query : {data_kepegawaian}')
                await session.execute(data_kepegawaian)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Success',
                    'data': new_kepegawaian
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

async def edit_kepegawaian(db_session: AsyncSession, request: EditKepegawaian, id_guru: int) -> dict:
    async with db_session as session:
        try:
            if id_guru is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_kepegawaian = {}
                edit_kepegawaian['no_sk'] = request.no_sk
                edit_kepegawaian['no_sk_ypmnu'] = request.no_sk_ypmnu
                edit_kepegawaian['no_sk_operator'] = request.no_sk_operator
                edit_kepegawaian['id_jabatan'] = request.id_jabatan
                edit_kepegawaian['status_kepegawaian'] = request.status_kepegawaian
                edit_kepegawaian['alasan_tidak_aktif'] = request.alasan_tidak_aktif
                edit_kepegawaian['surat_mutasi'] = request.surat_mutasi
                edit_kepegawaian['jumlah_ajar'] = request.jumlah_ajar
                data_kepegawaian = '''
                                update status_kepegawaian set {0} where id_guru = {1}
                            '''.format(generateQueryUpdate(edit_kepegawaian), id_guru)
                await session.execute(data_kepegawaian)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_kepegawaian
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

async def delete_kepegawaian(db_session: AsyncSession, id_guru: int) -> dict:
    async with db_session as session:
        try:
            if id_guru is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_guru = '''
                                delete from status_kepegawaian where id_guru = {0}
                            '''.format(id_guru)
                await session.execute(delete_guru)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Kepegawaian Berhasil Dihapus'
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

# Jabatan
async def get_list_jabatan(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM jabatan
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
            'status': 'Gagal, Data Jabatan Tidak Ditemukan'
        }

async def get_detail_jabatan(db_session: AsyncSession, id_jabatan: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM jabatan WHERE id = {0}
            '''.format(id_jabatan)
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
            'status': 'Success',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def add_jabatan(db_session: AsyncSession, request: Jabatan) -> dict:
    async with db_session as session:
        try:
            jabatan_id = """
                            SELECT nama_jabatan FROM jabatan where LOWER(nama_jabatan) = LOWER('{0}')
                    """.format(request.nama_jabatan)
            proxy_rows = await session.execute(jabatan_id)
            nama_jabatan = proxy_rows.scalar()

            if nama_jabatan is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Jabatan Sudah Ada'
                        }
            else:
                id_jabatan = await session.execute('''select nextval('jabatan_id_seq') as id''')
                id_jabatan = id_jabatan.one_or_none()
                new_jabatan = {}
                new_jabatan['id'] = id_jabatan.id
                new_jabatan['nama_jabatan'] = request.nama_jabatan
                data_jabatan = generateQuery('jabatan', new_jabatan)
                logging.debug(f'query : {data_jabatan}')
                await session.execute(data_jabatan)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Success',
                    'data': new_jabatan
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

async def edit_jabatan(db_session: AsyncSession, request: Jabatan, id_jabatan: int) -> dict:
    async with db_session as session:
        try:
            if id_jabatan is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_jabatan = {}
                edit_jabatan['nama_jabatan'] = request.nama_jabatan
                data_jabatan = '''
                                update jabatan set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_jabatan), id_jabatan)
                await session.execute(data_jabatan)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_jabatan
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

async def delete_jabatan(db_session: AsyncSession, id_jabatan: int) -> dict:
    async with db_session as session:
        try:
            if id_jabatan is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_guru = '''
                                delete from jabatan where id = {0}
                            '''.format(id_jabatan)
                await session.execute(delete_guru)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Jabatan Berhasil Dihapus'
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
