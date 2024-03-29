from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from models import Siswa
from schemas import DataSiswa, PendaftaranSiswa, SiswaNaik
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
                SELECT * FROM data_siswa WHERE status_siswa not in ('Lulus', 'Tidak Aktif') ORDER BY id DESC
                
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
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def get_list_siswa_by_kelas(db_session: AsyncSession, page: int, show: int, id_kelas: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_siswa WHERE status_siswa not in ('Lulus', 'Tidak Aktif') AND id_kelas = {2} ORDER BY id DESC
                
            '''.format(show, offset, id_kelas)
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
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def get_list_siswa_alumni(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_siswa WHERE status_siswa in ('Lulus', 'Tidak Aktif') ORDER BY id DESC
                
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
            'status': 'Sukses',
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
                id_siswa = await session.execute('''select nextval('data_siswa_id') as id''')
                id_siswa = id_siswa.one_or_none()
                new_siswa = {}
                new_siswa['id'] = id_siswa.id
                new_siswa['nisn'] = request.nisn
                new_siswa['nis'] = request.nis
                new_siswa['nama_siswa'] = request.nama_siswa
                new_siswa['tempat_lahir'] = request.tempat_lahir
                new_siswa['tanggal_lahir'] = request.tanggal_lahir
                new_siswa['jenis_kelamin'] = request.jenis_kelamin
                new_siswa['nik'] = request.nik
                new_siswa['id_kelas'] = request.id_kelas
                new_siswa['status_siswa'] = request.status_siswa
                new_siswa['nomor_kip'] = request.nomor_kip
                new_siswa['alamat'] = request.alamat
                new_siswa['nomor_kk'] = request.nomor_kk
                new_siswa['nomor_kks'] = request.nomor_kks
                new_siswa['nomor_pkh'] = request.nomor_pkh
                new_siswa['jenis_wali'] = request.jeniswali
                new_siswa['current_state'] = request.current_state
                data_siswa = generateQuery('data_siswa', new_siswa)
                logging.debug(f'query : {data_siswa}')
                await session.execute(data_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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
                edit_siswa['nis'] = request.nis
                edit_siswa['nama_siswa'] = request.nama_siswa
                edit_siswa['tempat_lahir'] = request.tempat_lahir
                edit_siswa['tanggal_lahir'] = request.tanggal_lahir
                edit_siswa['jenis_kelamin'] = request.jenis_kelamin
                edit_siswa['nik'] = request.nik
                edit_siswa['id_kelas'] = request.id_kelas
                edit_siswa['status_siswa'] = request.status_siswa
                edit_siswa['nomor_kip'] = request.nomor_kip
                edit_siswa['alamat'] = request.alamat
                edit_siswa['nomor_kk'] = request.nomor_kk
                edit_siswa['nomor_kks'] = request.nomor_kks
                edit_siswa['nomor_pkh'] = request.nomor_pkh
                edit_siswa['jenis_wali'] = request.jeniswali
                edit_siswa['current_state'] = request.current_state
                data_siswa = '''
                                update data_siswa set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_siswa), id_siswa)
                await session.execute(data_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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
                    'status': 'Sukses',
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

async def siswa_naik(request: SiswaNaik, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            siswanaik = '''
                            update data_siswa set id_kelas = {0} where id IN {1}
                        '''.format(request.id_kelas, tuple(map(int, request.daftar_siswa)))
            if len(request.daftar_siswa) == 1:
                siswanaik = '''
                            update data_siswa set id_kelas = {0}, 
                            current_state = CONCAT(CAST(split_part(current_state ,'/', 1) AS int) + 1, '/',CAST(split_part(current_state,'/', 2) AS int) + 1)
                            where id = {1}
                        '''.format(request.id_kelas, int(request.daftar_siswa[0]))
            await session.execute(siswanaik)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'message': 'Siswa berhasil naik'
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

async def siswa_lulus(request: SiswaNaik, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            siswanaik = '''
                            update data_siswa set status_siswa = 'Lulus',
                             current_state = CONCAT(CAST(split_part(current_state ,'/', 1) AS int) + 1, '/',CAST(split_part(current_state,'/', 2) AS int) + 1)
                             where id IN {0}
                        '''.format(tuple(map(int, request.daftar_siswa)))
            if len(request.daftar_siswa) == 1:
                siswanaik = '''
                            update data_siswa set status_siswa = 'Lulus',
                             current_state = CONCAT(CAST(split_part(current_state ,'/', 1) AS int) + 1, '/',CAST(split_part(current_state,'/', 2) AS int) + 1)
                             where id = {0}
                        '''.format(int(request.daftar_siswa[0]))
            await session.execute(siswanaik)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'message': 'Siswa berhasil naik'
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

# Pendaftaran Siswa

async def get_list_pendaftaransiswa(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_pendaftaran_siswa
                
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
            'status': 'Gagal, Data Pendaftaran Tidak Ditemukan'
        }

async def get_detail_pendaftaransiswa(db_session: AsyncSession, id_pendaftaransiswa: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_pendaftaran_siswa WHERE id = {0}
            '''.format(id_pendaftaransiswa)
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
            'status': 'Gagal, Data Siswa Tidak Ditemukan'
        }

async def add_pendaftaransiswa(db_session: AsyncSession, request: DataSiswa) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT id, nisn FROM data_siswa
                            where nisn = {0}
                    '''.format(request.nisn)
            proxy_rows = await session.execute(q_dep)
            nisn = proxy_rows.scalar()

            q_dep = '''
                                        SELECT nisn FROM data_pendaftaran_siswa
                                        where nisn = {0}
                                '''.format(request.nisn)
            proxy_rows = await session.execute(q_dep)
            nisn_daftar = proxy_rows.scalar()

            print(nisn)
            if nisn or nisn_daftar is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, NISN Sudah Didaftarkan'
                        }
            else:
                id_pendaftaransiswa = await session.execute('''select nextval('data_pendaftaran_siswa_id_seq') as id''')
                id_pendaftaransiswa = id_pendaftaransiswa.one_or_none()
                new_pendaftaransiswa = {}
                new_pendaftaransiswa['id'] = id_pendaftaransiswa.id
                new_pendaftaransiswa['nisn'] = request.nisn
                new_pendaftaransiswa['nama_siswa'] = request.nama_siswa
                new_pendaftaransiswa['tempat_lahir'] = request.tempat_lahir
                new_pendaftaransiswa['tanggal_lahir'] = request.tanggal_lahir
                new_pendaftaransiswa['jenis_kelamin'] = request.jenis_kelamin
                new_pendaftaransiswa['nik'] = request.nik
                new_pendaftaransiswa['nomor_kip'] = request.nomor_kip
                new_pendaftaransiswa['alamat'] = request.alamat
                new_pendaftaransiswa['nomor_kk'] = request.nomor_kk
                new_pendaftaransiswa['nama_kepalakeluarga'] = request.nama_kepalakeluarga
                new_pendaftaransiswa['status_siswa'] = request.status_siswa
                new_pendaftaransiswa['id_pembayaran'] = request.id_pembayaran
                data_pendaftaran_siswa = generateQuery('data_pendaftaran_siswa', new_pendaftaransiswa)
                logging.debug(f'query : {data_pendaftaran_siswa}')
                await session.execute(data_pendaftaran_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_pendaftaransiswa
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

async def edit_pendaftaransiswa(db_session: AsyncSession, request: DataSiswa, id_pendaftaransiswa: int) -> dict:
    async with db_session as session:
        try:
            if id_pendaftaransiswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_pendaftaransiswa = {}
                edit_pendaftaransiswa['nisn'] = request.nisn
                edit_pendaftaransiswa['nama_siswa'] = request.nama_siswa
                edit_pendaftaransiswa['tempat_lahir'] = request.tempat_lahir
                edit_pendaftaransiswa['tanggal_lahir'] = request.tanggal_lahir
                edit_pendaftaransiswa['jenis_kelamin'] = request.jenis_kelamin
                edit_pendaftaransiswa['nik'] = request.nik
                edit_pendaftaransiswa['nomor_kip'] = request.nomor_kip
                edit_pendaftaransiswa['alamat'] = request.alamat
                edit_pendaftaransiswa['nomor_kk'] = request.nomor_kk
                edit_pendaftaransiswa['nama_kepalakeluarga'] = request.nama_kepalakeluarga
                edit_pendaftaransiswa['status_siswa'] = request.status_siswa
                edit_pendaftaransiswa['id_pembayaran'] = request.id_pembayaran
                data_pendaftaran_siswa = '''
                                update data_pendaftaran_siswa set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_pendaftaransiswa), id_pendaftaransiswa)
                await session.execute(data_pendaftaran_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_pendaftaransiswa
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

async def delete_pendaftaransiswa(db_session: AsyncSession, id_pendaftaransiswa: int) -> dict:
    async with db_session as session:
        try:
            if id_pendaftaransiswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_pendaftaransiswa = '''
                                delete from data_pendaftaran_siswa where id = {0}
                            '''.format(id_pendaftaransiswa)
                await session.execute(delete_pendaftaransiswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
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

