from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from schemas import DataLembaga, SaranaPrasarana, SuratKeterangan
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_lembaga(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_lembaga
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
            'status': 'Gagal, Data Lembaga Tidak Ditemukan'
        }

async def get_detail_lembaga(db_session: AsyncSession, id_lembaga: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_lembaga WHERE id = {0}
            '''.format(id_lembaga)
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
            'status': 'Gagal, Data Lembaga Tidak Ditemukan'
        }

async def add_lembaga(db_session: AsyncSession, request: DataLembaga) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT nama_lembaga FROM data_lembaga
                            where LOWER(nama_lembaga) = LOWER('{0}')
                    '''.format(request.nama_lembaga)
            proxy_rows = await session.execute(q_dep)
            nama_lembaga = proxy_rows.scalar()
            if nama_lembaga is not None:
                return {
                    'message_id': '01',
                    'status': 'Gagal, Nama Lembaga Sudah Ada'
                }
            else:
                id_lembaga = await session.execute('''select nextval('data_lembaga_id_seq') as id''')
                id_lembaga = id_lembaga.one_or_none()
                new_lembaga = {}
                new_lembaga['id'] = id_lembaga.id
                new_lembaga['nama_lembaga'] = request.nama_lembaga
                new_lembaga['tahun_berdiri'] = request.tahun_berdiri
                new_lembaga['no_telp'] = request.no_telp
                new_lembaga['alamat'] = request.alamat
                new_lembaga['email'] = request.email
                new_lembaga['npsn'] = request.npsn
                new_lembaga['nsm'] = request.nsm
                data_lembaga = generateQuery('data_lembaga', new_lembaga)
                logging.debug(f'query : {data_lembaga}')
                await session.execute(data_lembaga)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': new_lembaga
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

async def edit_lembaga(db_session: AsyncSession, request: DataLembaga, id_lembaga: int) -> dict:
    async with db_session as session:
        try:
            if id_lembaga is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_lembaga = {}
                edit_lembaga['nama_lembaga'] = request.nama_lembaga
                edit_lembaga['tahun_berdiri'] = request.tahun_berdiri
                edit_lembaga['no_telp'] = request.no_telp
                edit_lembaga['alamat'] = request.alamat
                edit_lembaga['email'] = request.email
                edit_lembaga['npsn'] = request.npsn
                edit_lembaga['nsm'] = request.nsm
                data_lembaga = '''
                                update data_lembaga set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_lembaga), id_lembaga)
                await session.execute(data_lembaga)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_lembaga
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

async def delete_lembaga(db_session: AsyncSession, id_lembaga: int) -> dict:
    async with db_session as session:
        try:
            if id_lembaga is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_lembaga = '''
                                delete from data_lembaga where id = {0}
                            '''.format(id_lembaga)

                await session.execute(delete_lembaga)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Lembaga Berhasil Dihapus'
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

# Sarana Prasarana

async def get_list_sarpras(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM sarana_prasarana
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
            'status': 'Gagal, Data Lembaga Tidak Ditemukan'
        }

async def get_detail_sarpras(db_session: AsyncSession, id_sarpras: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM sarana_prasarana WHERE id = {0}
            '''.format(id_sarpras)
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
            'status': 'Gagal, Data Lembaga Tidak Ditemukan'
        }

async def add_sarpras(db_session: AsyncSession, request: SaranaPrasarana) -> dict:
    async with db_session as session:
        try:
            id_sarpras = await session.execute('''select nextval('sarana_prasarana_id_seq') as id''')
            id_sarpras = id_sarpras.one_or_none()
            new_sarpras = {}
            new_sarpras['id'] = id_sarpras.id
            new_sarpras['id_lembaga'] = request.id_lembaga
            new_sarpras['luas_lahan'] = request.luas_lahan
            new_sarpras['luas_bangunan'] = request.luas_bangunan
            new_sarpras['nama_pemilik'] = request.nama_pemilik
            new_sarpras['no_sertifikat'] = request.no_sertifikat
            sarana_prasarana = generateQuery('sarana_prasarana', new_sarpras)
            logging.debug(f'query : {sarana_prasarana}')
            await session.execute(sarana_prasarana)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Succes',
                'data': new_sarpras
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

async def edit_sarpras(db_session: AsyncSession, request: SaranaPrasarana, id_sarpras: int) -> dict:
    async with db_session as session:
        try:
            if id_sarpras is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_sarpras = {}
                edit_sarpras['id_lembaga'] = request.id_lembaga
                edit_sarpras['luas_lahan'] = request.luas_lahan
                edit_sarpras['luas_bangunan'] = request.luas_bangunan
                edit_sarpras['nama_pemilik'] = request.nama_pemilik
                edit_sarpras['no_sertifikat'] = request.no_sertifikat
                sarana_prasarana = '''
                                update sarana_prasarana set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_sarpras), id_sarpras)
                await session.execute(sarana_prasarana)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_sarpras
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

async def delete_sarpras(db_session: AsyncSession, id_sarpras: int) -> dict:
    async with db_session as session:
        try:
            if id_sarpras is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_sarpras = '''
                                delete from sarana_prasarana where id = {0}
                            '''.format(id_sarpras)

                await session.execute(delete_sarpras)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Lembaga Berhasil Dihapus'
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

async def delete_sarpras_lembaga(db_session: AsyncSession, id_lembaga: int) -> dict:
    async with db_session as session:
        try:
            if id_lembaga is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_sarpras = '''
                                delete from sarana_prasarana where id_lembaga = {0}
                            '''.format(id_lembaga)

                await session.execute(delete_sarpras)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Lembaga Berhasil Dihapus'
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

# Surat Keterangan

async def get_list_suratketerangan(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_surat_keterangan
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
            'status': 'Gagal, Data Surat Keterangan Tidak Ditemukan'
        }

async def get_detail_suratketerangan(db_session: AsyncSession, id_suratketerangan: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_surat_keterangan WHERE id = {0}
            '''.format(id_suratketerangan)
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
            'status': 'Gagal, Data Lembaga Tidak Ditemukan'
        }

async def add_suratketerangan(db_session: AsyncSession, request: SuratKeterangan) -> dict:
    async with db_session as session:
        try:
            id_suratketerangan = await session.execute('''select nextval('data_surat_keterangan_id_seq') as id''')
            id_suratketerangan = id_suratketerangan.one_or_none()
            new_suratketerangan = {}
            new_suratketerangan['id'] = id_suratketerangan.id
            new_suratketerangan['id_lembaga'] = request.id_lembaga
            new_suratketerangan['nama_surat_keterangan'] = request.nama_surat_keterangan
            new_suratketerangan['nomor_surat_keterangan'] = request.nomor_surat_keterangan
            new_suratketerangan['tanggal_surat_keterangan'] = request.tanggal_surat_keterangan
            data_surat_keterangan = generateQuery('data_surat_keterangan', new_suratketerangan)
            logging.debug(f'query : {data_surat_keterangan}')
            await session.execute(data_surat_keterangan)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Succes',
                'data': new_suratketerangan
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

async def edit_suratketerangan(db_session: AsyncSession, request: SuratKeterangan, id_suratketerangan: int) -> dict:
    async with db_session as session:
        try:
            if id_suratketerangan is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_suratketerangan = {}
                edit_suratketerangan['nama_surat_keterangan'] = request.nama_surat_keterangan
                edit_suratketerangan['nomor_surat_keterangan'] = request.nomor_surat_keterangan
                edit_suratketerangan['tanggal_surat_keterangan'] = request.tanggal_surat_keterangan
                data_surat_keterangan = '''
                                update data_surat_keterangan set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_suratketerangan), id_suratketerangan)
                await session.execute(data_surat_keterangan)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'data': edit_suratketerangan
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

async def delete_suratketerangan(db_session: AsyncSession, id_suratketerangan: int) -> dict:
    async with db_session as session:
        try:
            if id_suratketerangan is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_suratketerangan = '''
                                delete from data_surat_keterangan where id = {0}
                            '''.format(id_suratketerangan)

                await session.execute(delete_suratketerangan)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Succes',
                    'message': 'Data Lembaga Berhasil Dihapus'
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