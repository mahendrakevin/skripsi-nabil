from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Kelas
from schemas import DanaMasuk, DanaKeluar, SumberDana, JenisPengeluaran
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_danamasuk(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM dana_masuk
                
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
            'status': 'Gagal, Data Dana Masuk Tidak Ditemukan'
        }

async def get_detail_danamasuk(db_session: AsyncSession, id_danamasuk: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM dana_masuk WHERE id = {0}
            '''.format(id_danamasuk)
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
            'status': 'Gagal, Data Dana Masuk Tidak Ditemukan'
        }

async def add_danamasuk(db_session: AsyncSession, request: DanaMasuk) -> dict:
    async with db_session as session:
        try:
            id_danamasuk = await session.execute('''select nextval('dana_masuk_id_seq') as id''')
            id_danamasuk = id_danamasuk.one_or_none()
            new_danamasuk = {}
            new_danamasuk['id'] = id_danamasuk.id
            new_danamasuk['tanggal'] = request.tanggal
            new_danamasuk['id_sumberdana'] = request.id_sumberdana
            new_danamasuk['nominal_dana'] = request.nominal_dana
            new_danamasuk['lampiran'] = request.lampiran
            data_danamasuk = generateQuery('dana_masuk', new_danamasuk)
            logging.debug(f'query : {data_danamasuk}')
            await session.execute(data_danamasuk)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_danamasuk
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

async def edit_danamasuk(db_session: AsyncSession, request: DanaMasuk, id_danamasuk: int) -> dict:
    async with db_session as session:
        try:
            if id_danamasuk is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_danamasuk = {}
                edit_danamasuk['tanggal'] = request.tanggal
                edit_danamasuk['id_sumberdana'] = request.id_sumberdana
                edit_danamasuk['nominal_dana'] = request.nominal_dana
                edit_danamasuk['lampiran'] = request.lampiran
                data_danamasuk = '''
                                update dana_masuk set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_danamasuk), id_danamasuk)
                await session.execute(data_danamasuk)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_danamasuk
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

async def delete_danamasuk(db_session: AsyncSession, id_danamasuk: int) -> dict:
    async with db_session as session:
        try:
            if id_danamasuk is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_danamasuk = '''
                                delete from dana_masuk where id = {0}
                            '''.format(id_danamasuk)
                await session.execute(delete_danamasuk)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Dana Masuk Berhasil Dihapus'
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

# Dana Keluar

async def get_list_danakeluar(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM dana_keluar
                
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
            'status': 'Gagal, Data Dana Keluar Tidak Ditemukan'
        }

async def get_detail_danakeluar(db_session: AsyncSession, id_danakeluar: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM dana_keluar WHERE id = {0}
            '''.format(id_danakeluar)
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
            'status': 'Gagal, Data Dana Keluar Tidak Ditemukan'
        }

async def add_danakeluar(db_session: AsyncSession, request: DanaKeluar) -> dict:
    async with db_session as session:
        try:
            id_danakeluar = await session.execute('''select nextval('dana_keluar_id_seq') as id''')
            id_danakeluar = id_danakeluar.one_or_none()
            new_danakeluar = {}
            new_danakeluar['id'] = id_danakeluar.id
            new_danakeluar['tanggal'] = request.tanggal
            new_danakeluar['detail_pengeluaran'] = request.detail_pengeluaran
            new_danakeluar['id_jenispengeluaran'] = request.id_jenispengeluaran
            new_danakeluar['diserahkan_kepada'] = request.diserahkan_kepada
            new_danakeluar['dikeluarkan_oleh'] = request.dikeluarkan_oleh
            new_danakeluar['bukti_pengeluaran'] = request.bukti_pengeluaran
            new_danakeluar['nominal_pengeluaran'] = request.nominal_pengeluaran
            data_danakeluar = generateQuery('dana_keluar', new_danakeluar)
            logging.debug(f'query : {data_danakeluar}')
            await session.execute(data_danakeluar)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_danakeluar
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

async def edit_danakeluar(db_session: AsyncSession, request: DanaKeluar, id_danakeluar: int) -> dict:
    async with db_session as session:
        try:
            if id_danakeluar is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_danakeluar = {}
                edit_danakeluar['tanggal'] = request.tanggal
                edit_danakeluar['detail_pengeluaran'] = request.detail_pengeluaran
                edit_danakeluar['id_jenispengeluaran'] = request.id_jenispengeluaran
                edit_danakeluar['diserahkan_kepada'] = request.diserahkan_kepada
                edit_danakeluar['dikeluarkan_oleh'] = request.dikeluarkan_oleh
                edit_danakeluar['bukti_pengeluaran'] = request.bukti_pengeluaran
                edit_danakeluar['nominal_pengeluaran'] = request.nominal_pengeluaran
                data_danakeluar = '''
                                update dana_keluar set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_danakeluar), id_danakeluar)
                await session.execute(data_danakeluar)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_danakeluar
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

async def delete_danakeluar(db_session: AsyncSession, id_danakeluar: int) -> dict:
    async with db_session as session:
        try:
            if id_danakeluar is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_danakeluar = '''
                                delete from dana_keluar where id = {0}
                            '''.format(id_danakeluar)
                await session.execute(delete_danakeluar)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Dana Keluar Berhasil Dihapus'
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

# Sumber Dana

async def get_list_sumberdana(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM sumber_dana
                
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
            'status': 'Gagal, Data Sumber Dana Tidak Ditemukan'
        }

async def get_detail_sumberdana(db_session: AsyncSession, id_sumberdana: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM sumber_dana WHERE id = {0}
            '''.format(id_sumberdana)
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
            'status': 'Gagal, Data Sumber Dana Tidak Ditemukan'
        }

async def add_sumberdana(db_session: AsyncSession, request: SumberDana) -> dict:
    async with db_session as session:
        try:
            id_sumberdana = await session.execute('''select nextval('sumber_dana_id_seq') as id''')
            id_sumberdana = id_sumberdana.one_or_none()
            new_sumberdana = {}
            new_sumberdana['id'] = id_sumberdana.id
            new_sumberdana['nama_dana'] = request.nama_dana
            data_sumberdana = generateQuery('sumber_dana', new_sumberdana)
            logging.debug(f'query : {data_sumberdana}')
            await session.execute(data_sumberdana)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_sumberdana
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

async def edit_sumberdana(db_session: AsyncSession, request: SumberDana, id_sumberdana: int) -> dict:
    async with db_session as session:
        try:
            if id_sumberdana is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_sumberdana = {}
                edit_sumberdana['nama_dana'] = request.nama_dana
                data_sumberdana = '''
                                update sumber_dana set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_sumberdana), id_sumberdana)
                await session.execute(data_sumberdana)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_sumberdana
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

async def delete_sumberdana(db_session: AsyncSession, id_sumberdana: int) -> dict:
    async with db_session as session:
        try:
            if id_sumberdana is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_sumberdana = '''
                                delete from sumber_dana where id = {0}
                            '''.format(id_sumberdana)
                await session.execute(delete_sumberdana)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Sumber Dana Berhasil Dihapus'
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

# Jenis Pengeluaran

async def get_list_jenispengeluaran(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM jenis_pengeluaran
                
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
            'status': 'Gagal, Data Jenis Pengeluaran Tidak Ditemukan'
        }

async def get_detail_jenispengeluaran(db_session: AsyncSession, id_jenispengeluaran: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM jenis_pengeluaran WHERE id = {0}
            '''.format(id_jenispengeluaran)
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
            'status': 'Gagal, Data Jenis Pengeluaran Tidak Ditemukan'
        }

async def add_jenispengeluaran(db_session: AsyncSession, request: JenisPengeluaran) -> dict:
    async with db_session as session:
        try:
            id_jenispengeluaran = await session.execute('''select nextval('jenis_pengeluaran_id_seq') as id''')
            id_jenispengeluaran = id_jenispengeluaran.one_or_none()
            new_jenispengeluaran = {}
            new_jenispengeluaran['id'] = id_jenispengeluaran.id
            new_jenispengeluaran['jenis_pengeluaran'] = request.jenis_pengeluaran
            data_jenispengeluaran = generateQuery('jenis_pengeluaran', new_jenispengeluaran)
            logging.debug(f'query : {data_jenispengeluaran}')
            await session.execute(data_jenispengeluaran)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_jenispengeluaran
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

async def edit_jenispengeluaran(db_session: AsyncSession, request: JenisPengeluaran, id_jenispengeluaran: int) -> dict:
    async with db_session as session:
        try:
            if id_jenispengeluaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_jenispengeluaran = {}
                edit_jenispengeluaran['jenis_pengeluaran'] = request.jenis_pengeluaran
                data_jenispengeluaran = '''
                                update jenis_pengeluaran set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_jenispengeluaran), id_jenispengeluaran)
                await session.execute(data_jenispengeluaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_jenispengeluaran
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

async def delete_jenispengeluaran(db_session: AsyncSession, id_jenispengeluaran: int) -> dict:
    async with db_session as session:
        try:
            if id_jenispengeluaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_jenispengeluaran = '''
                                delete from jenis_pengeluaran where id = {0}
                            '''.format(id_jenispengeluaran)
                await session.execute(delete_jenispengeluaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Jenis Pengeluaran Berhasil Dihapus'
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
