from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from schemas import PembayaranSiswa, JenisPembayaran
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_pembayaransiswa(db_session: AsyncSession, page: int, show: int, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is not None:
                where_siswa = 'WHERE id_siswa = {0}'.format(id_siswa)
            else:
                where_siswa = ''
            offset = (page - 1) * show

            q_dep = '''
                SELECT *, to_char(tanggal_pembayaran, 'DD Mon YYYY') AS created_format FROM status_pembayaran {0}
                limit {1}
                offset {2}
            '''.format(where_siswa, show, offset)
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
            'status': 'Gagal, Data Pembayaran Tidak Ditemukan'
        }

async def get_detail_pembayaransiswa_id_siswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM status_pembayaran WHERE id_siswa = {0}
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
            'status': 'Sukses',
            'data':result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Pembayaran Tidak Ditemukan'
        }

async def get_detail_pembayaransiswa(db_session: AsyncSession, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM status_pembayaran WHERE id = {0}
            '''.format(id_laporanpembayaran)
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
            'status': 'Gagal, Data Pembayaran Tidak Ditemukan'
        }

async def add_pembayaransiswa(db_session: AsyncSession, request: PembayaranSiswa) -> dict:
    async with db_session as session:
        try:
            id_jenispembayaran = await session.execute('''select nextval('status_pembayaran_id_seq') as id''')
            id_jenispembayaran = id_jenispembayaran.one_or_none()
            new_pembayaransiswa = {}
            new_pembayaransiswa['id'] = id_jenispembayaran.id
            new_pembayaransiswa['id_siswa'] = request.id_siswa
            new_pembayaransiswa['nominal_pembayaran'] = request.nominal_pembayaran
            new_pembayaransiswa['status_pembayaran'] = request.status_pembayaran
            new_pembayaransiswa['id_jenispembayaran'] = request.id_jenispembayaran
            new_pembayaransiswa['tanggal_pembayaran'] = request.tanggal_pembayaran
            status_pembayaran = generateQuery('status_pembayaran', new_pembayaransiswa)
            logging.debug(f'query : {status_pembayaran}')
            await session.execute(status_pembayaran)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
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

async def edit_pembayaransiswa(db_session: AsyncSession, request: PembayaranSiswa, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_laporanpembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_pembayaransiswa = {}
                edit_pembayaransiswa['id_siswa'] = request.id_siswa
                edit_pembayaransiswa['nominal_pembayaran'] = request.nominal_pembayaran
                edit_pembayaransiswa['status_pembayaran'] = request.status_pembayaran
                edit_pembayaransiswa['id_jenispembayaran'] = request.id_jenispembayaran
                edit_pembayaransiswa['tanggal_pembayaran'] = request.tanggal_pembayaran
                status_pembayaran = '''
                                update status_pembayaran set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_pembayaransiswa), id_laporanpembayaran)
                await session.execute(status_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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

async def delete_pembayaransiswa_id_siswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_pembayaransiswa = '''
                                delete from status_pembayaran where id_siswa = {0}
                            '''.format(id_siswa)
                await session.execute(delete_pembayaransiswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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

async def delete_pembayaransiswa(db_session: AsyncSession, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_laporanpembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_pembayaransiswa = '''
                                delete from status_pembayaran where id = {0}
                            '''.format(id_laporanpembayaran)
                await session.execute(delete_pembayaransiswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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

# Jenis Pembayaran

async def get_list_jenispembayaran(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM jenis_pembayaran
                
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
            'status': 'Gagal, Data jenispembayaran Tidak Ditemukan'
        }

async def get_detail_jenispembayaran(db_session: AsyncSession, id_jenispembayaran: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM jenis_pembayaran WHERE id = {0}
            '''.format(id_jenispembayaran)
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
            'status': 'Gagal, Data jenispembayaran Tidak Ditemukan'
        }

async def add_jenispembayaran(db_session: AsyncSession, request: JenisPembayaran) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT jenis_pembayaran FROM jenis_pembayaran
                            where LOWER(jenis_pembayaran) = LOWER('{0}')
                    '''.format(request.jenis_pembayaran)
            proxy_rows = await session.execute(q_dep)
            jenis_pembayaran = proxy_rows.scalar()
            if jenis_pembayaran is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Nama jenispembayaran Sudah Ada'
                        }
            else:
                id_jenispembayaran = await session.execute('''select nextval('jenis_pembayaran_id_seq') as id''')
                id_jenispembayaran = id_jenispembayaran.one_or_none()
                new_jenispembayaran = {}
                new_jenispembayaran['id'] = id_jenispembayaran.id
                new_jenispembayaran['jenis_pembayaran'] = request.jenis_pembayaran
                new_jenispembayaran['nominal_pembayaran'] = request.nominal_pembayaran
                jenis_pembayaran = generateQuery('jenis_pembayaran', new_jenispembayaran)
                logging.debug(f'query : {jenis_pembayaran}')
                await session.execute(jenis_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_jenispembayaran
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

async def edit_jenispembayaran(db_session: AsyncSession, request: JenisPembayaran, id_jenispembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_jenispembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_jenispembayaran = {}
                edit_jenispembayaran['jenis_pembayaran'] = request.jenis_pembayaran
                edit_jenispembayaran['nominal_pembayaran'] = request.nominal_pembayaran
                jenis_pembayaran = '''
                                update jenis_pembayaran set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_jenispembayaran), id_jenispembayaran)
                await session.execute(jenis_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_jenispembayaran
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

async def delete_jenispembayaran(db_session: AsyncSession, id_jenispembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_jenispembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_jenispembayaran = '''
                                delete from jenis_pembayaran where id = {0}
                            '''.format(id_jenispembayaran)
                await session.execute(delete_jenispembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data jenispembayaran Berhasil Dihapus'
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

