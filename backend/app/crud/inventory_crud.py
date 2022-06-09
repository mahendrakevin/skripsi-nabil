from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Inventory
from schemas import DataInventory, KategoriBarang, JenisInventaris
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_inventory(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_inventory
                
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
            'status': 'Gagal, Data Inventory Tidak Ditemukan'
        }

async def get_detail_inventory(db_session: AsyncSession, id_inventory: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_inventory WHERE id = {0}
            '''.format(id_inventory)
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
            'status': 'Gagal, Data Inventory Tidak Ditemukan'
        }

async def add_inventory(db_session: AsyncSession, request: DataInventory) -> dict:
    async with db_session as session:
        try:
            id_inventory = await session.execute('''select nextval('data_inventory_id_seq') as id''')
            id_inventory = id_inventory.one_or_none()
            new_inventory = {}
            new_inventory['id'] = id_inventory.id
            new_inventory['nama_barang'] = request.nama_barang
            new_inventory['nomor_seri'] = request.nomor_seri
            new_inventory['id_kategori_barang'] = request.id_kategori_barang
            new_inventory['jumlah_barang'] = request.jumlah_barang
            new_inventory['tanggal_pembelian'] = request.tanggal_pembelian
            new_inventory['harga_barang'] = request.harga_barang
            new_inventory['id_jenis_inventaris'] = request.id_jenis_inventaris
            new_inventory['keterangan'] = request.keterangan
            new_inventory['lampiran'] = request.lampiran
            data_inventory = generateQuery('data_inventory', new_inventory)
            logging.debug(f'query : {data_inventory}')
            await session.execute(data_inventory)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_inventory
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

async def edit_inventory(db_session: AsyncSession, request: DataInventory, id_inventory: int) -> dict:
    async with db_session as session:
        try:
            if id_inventory is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_inventory = {}
                edit_inventory['nama_barang'] = request.nama_barang
                edit_inventory['nomor_seri'] = request.nomor_seri
                edit_inventory['id_kategori_barang'] = request.id_kategori_barang
                edit_inventory['jumlah_barang'] = request.jumlah_barang
                edit_inventory['tanggal_pembelian'] = request.tanggal_pembelian
                edit_inventory['harga_barang'] = request.harga_barang
                edit_inventory['id_jenis_inventaris'] = request.id_jenis_inventaris
                edit_inventory['keterangan'] = request.keterangan
                edit_inventory['lampiran'] = request.lampiran
                data_inventory = '''
                                update data_inventory set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_inventory), id_inventory)
                await session.execute(data_inventory)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_inventory
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

async def delete_inventory(db_session: AsyncSession, id_inventory: int) -> dict:
    async with db_session as session:
        try:
            if id_inventory is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_inventory = '''
                                delete from data_inventory where id = {0}
                            '''.format(id_inventory)

                await session.execute(delete_inventory)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Inventory Berhasil Dihapus'
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

# Kategori Barang

async def get_list_kategori_barang(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_kategori_barang
                
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
            'status': 'Gagal, Data Kategori Tidak Ditemukan'
        }

async def get_detail_kategori_barang(db_session: AsyncSession, id_kategori_barang: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_kategori_barang WHERE id = {0}
            '''.format(id_kategori_barang)
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
            'status': 'Gagal, Data Kategori Barang Tidak Ditemukan'
        }

async def add_kategori_barang(db_session: AsyncSession, request: KategoriBarang) -> dict:
    async with db_session as session:
        try:
            kategori_id = '''
                            SELECT nama_kategori FROM data_kategori_barang
                            where LOWER(nama_kategori) = LOWER('{0}')
                    '''.format(request.nama_kategori)
            proxy_rows = await session.execute(kategori_id)
            id_kategori_barang = proxy_rows.one_or_none()

            if id_kategori_barang is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Kategori Sudah Ada'
                        }
            else:
                id_kategori_barang = await session.execute('''select nextval('data_kategori_barang_id_seq') as id''')
                id_kategori_barang = id_kategori_barang.one_or_none()
                new_kategori_barang = {}
                new_kategori_barang['id'] = id_kategori_barang.id
                new_kategori_barang['nama_kategori'] = request.nama_kategori
                data_kategori_barang = generateQuery('data_kategori_barang', new_kategori_barang)
                logging.debug(f'query : {data_kategori_barang}')
                await session.execute(data_kategori_barang)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_kategori_barang
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

async def edit_kategori_barang(db_session: AsyncSession, request: KategoriBarang, id_kategori_barang: int) -> dict:
    async with db_session as session:
        try:
            if id_kategori_barang is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_kategori_barang = {}
                edit_kategori_barang['nama_kategori'] = request.nama_kategori
                data_kategori_barang = '''
                                update data_kategori_barang set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_kategori_barang), id_kategori_barang)
                await session.execute(data_kategori_barang)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_kategori_barang
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

async def delete_kategori_barang(db_session: AsyncSession, id_kategori_barang: int) -> dict:
    async with db_session as session:
        try:
            if id_kategori_barang is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_guru = '''
                                delete from data_kategori_barang where id = {0}
                            '''.format(id_kategori_barang)
                await session.execute(delete_guru)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Kategori Berhasil Dihapus'
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

# Jenis Inventaris

async def get_list_jenis_inventaris(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_jenis_inventaris
                
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
            'status': 'Gagal, Data Jenis Inventaris Tidak Ditemukan'
        }

async def get_detail_jenis_inventaris(db_session: AsyncSession, id_jenis_inventaris: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_jenis_inventaris WHERE id = {0}
            '''.format(id_jenis_inventaris)
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
            'status': 'Gagal, Data Jenis Inventaris Tidak Ditemukan'
        }

async def add_jenis_inventaris(db_session: AsyncSession, request: JenisInventaris) -> dict:
    async with db_session as session:
        try:
            nama_jenis_inventaris_id = '''
                            SELECT nama_jenis_inventaris FROM data_jenis_inventaris
                            where LOWER(nama_jenis_inventaris) = LOWER('{0}')
                    '''.format(request.nama_jenis_inventaris)
            proxy_rows = await session.execute(nama_jenis_inventaris_id)
            id_jenis_inventaris = proxy_rows.one_or_none()

            if id_jenis_inventaris is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Jenis Inventaris Sudah Ada'
                        }
            else:
                id_jenis_inventaris = await session.execute('''select nextval('data_jenis_inventaris_id_seq') as id''')
                id_jenis_inventaris = id_jenis_inventaris.one_or_none()
                new_jenis_inventaris = {}
                new_jenis_inventaris['id'] = id_jenis_inventaris.id
                new_jenis_inventaris['nama_jenis_inventaris'] = request.nama_jenis_inventaris
                data_jenis_inventaris = generateQuery('data_jenis_inventaris', new_jenis_inventaris)
                logging.debug(f'query : {data_jenis_inventaris}')
                await session.execute(data_jenis_inventaris)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_jenis_inventaris
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

async def edit_jenis_inventaris(db_session: AsyncSession, request: JenisInventaris, id_jenis_inventaris: int) -> dict:
    async with db_session as session:
        try:
            if id_jenis_inventaris is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_jenis_inventaris = {}
                edit_jenis_inventaris['nama_jenis_inventaris'] = request.nama_jenis_inventaris
                data_jenis_inventaris = '''
                                update data_jenis_inventaris set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_jenis_inventaris), id_jenis_inventaris)
                await session.execute(data_jenis_inventaris)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_jenis_inventaris
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

async def delete_jenis_inventaris(db_session: AsyncSession, id_jenis_inventaris: int) -> dict:
    async with db_session as session:
        try:
            if id_jenis_inventaris is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_jenis_inventaris = '''
                                delete from data_jenis_inventaris where id = {0}
                            '''.format(id_jenis_inventaris)
                await session.execute(delete_jenis_inventaris)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Jenis Inventaris Berhasil Dihapus'
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

