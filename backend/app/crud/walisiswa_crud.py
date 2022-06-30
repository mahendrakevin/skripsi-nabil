from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from schemas import WaliSiswa, JenisWali, JenisPembayaran, LaporanPembayaran
from typing import List, Tuple, Union, Dict, Any
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
import logging
from datetime import datetime

logging.basicConfig(level=logging.DEBUG)

async def get_list_walisiswa(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_wali_siswa
                
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
            'status': 'Gagal, Data Wali Tidak Ditemukan'
        }

async def get_detail_walisiswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_wali_siswa WHERE id_siswa = {0}
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
            'status': 'Gagal, Data Wali Tidak Ditemukan'
        }

async def add_walisiswa(db_session: AsyncSession, request: WaliSiswa) -> dict:
    async with db_session as session:
        try:
            id_walisiswa = await session.execute('''select nextval('data_wali_siswa_id_seq') as id''')
            id_walisiswa = id_walisiswa.one_or_none()
            new_walisiswa = {}
            new_walisiswa['id'] = id_walisiswa.id
            new_walisiswa['nama_ayah'] = request.nama_ayah
            new_walisiswa['nik_ayah'] = request.nik_ayah
            new_walisiswa['file_kk_ayah'] = request.file_kk_ayah
            new_walisiswa['file_kk_ibu'] = request.file_kk_ibu
            new_walisiswa['tempat_lahir_ayah'] = request.tempat_lahir_ayah
            new_walisiswa['tanggal_lahir_ayah'] = request.tanggal_lahir_ayah
            new_walisiswa['alamat_ayah'] = request.alamat_ayah
            new_walisiswa['status_keluarga_ayah'] = request.status_keluarga_ayah
            new_walisiswa['status_hidup_ayah'] = request.status_hidup_ayah
            new_walisiswa['no_hp_ayah'] = request.no_hp_ayah
            new_walisiswa['pendidikan_ayah'] = request.pendidikan_ayah
            new_walisiswa['pekerjaan_ayah'] = request.pekerjaan_ayah
            new_walisiswa['penghasilan_ayah'] = request.penghasilan_ayah
            new_walisiswa['nama_ibu'] = request.nama_ibu
            new_walisiswa['nik_ibu'] = request.nik_ibu
            new_walisiswa['tempat_lahir_ibu'] = request.tempat_lahir_ibu
            new_walisiswa['tanggal_lahir_ibu'] = request.tanggal_lahir_ibu
            new_walisiswa['alamat_ibu'] = request.alamat_ibu
            new_walisiswa['status_keluarga_ibu'] = request.status_keluarga_ibu
            new_walisiswa['status_hidup_ibu'] = request.status_hidup_ibu
            new_walisiswa['no_hp_ibu'] = request.no_hp_ibu
            new_walisiswa['pendidikan_ibu'] = request.pendidikan_ibu
            new_walisiswa['pekerjaan_ibu'] = request.pekerjaan_ibu
            new_walisiswa['penghasilan_ibu'] = request.penghasilan_ibu
            new_walisiswa['nama_wali'] = request.nama_wali
            new_walisiswa['alamat_wali'] = request.alamat_wali
            new_walisiswa['no_hp_wali'] = request.no_hp_wali
            new_walisiswa['keterangan'] = request.keterangan
            new_walisiswa['id_siswa'] = request.id_siswa
            data_wali_siswa = generateQuery('data_wali_siswa', new_walisiswa)
            logging.debug(f'query : {data_wali_siswa}')
            await session.execute(data_wali_siswa)
            await session.commit()
            return {
                'message_id': '00',
                'status': 'Sukses',
                'data': new_walisiswa
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

async def edit_walisiswa(db_session: AsyncSession, request: WaliSiswa, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_walisiswa = {}
                edit_walisiswa['nama_ayah'] = request.nama_ayah
                edit_walisiswa['nik_ayah'] = request.nik_ayah
                edit_walisiswa['file_kk_ayah'] = request.file_kk_ayah
                edit_walisiswa['file_kk_ibu'] = request.file_kk_ibu
                edit_walisiswa['tempat_lahir_ayah'] = request.tempat_lahir_ayah
                edit_walisiswa['tanggal_lahir_ayah'] = request.tanggal_lahir_ayah
                edit_walisiswa['alamat_ayah'] = request.alamat_ayah
                edit_walisiswa['status_keluarga_ayah'] = request.status_keluarga_ayah
                edit_walisiswa['status_hidup_ayah'] = request.status_hidup_ayah
                edit_walisiswa['no_hp_ayah'] = request.no_hp_ayah
                edit_walisiswa['pendidikan_ayah'] = request.pendidikan_ayah
                edit_walisiswa['pekerjaan_ayah'] = request.pekerjaan_ayah
                edit_walisiswa['penghasilan_ayah'] = request.penghasilan_ayah
                edit_walisiswa['nama_ibu'] = request.nama_ibu
                edit_walisiswa['nik_ibu'] = request.nik_ibu
                edit_walisiswa['tempat_lahir_ibu'] = request.tempat_lahir_ibu
                edit_walisiswa['tanggal_lahir_ibu'] = request.tanggal_lahir_ibu
                edit_walisiswa['alamat_ibu'] = request.alamat_ibu
                edit_walisiswa['status_keluarga_ibu'] = request.status_keluarga_ibu
                edit_walisiswa['status_hidup_ibu'] = request.status_hidup_ibu
                edit_walisiswa['no_hp_ibu'] = request.no_hp_ibu
                edit_walisiswa['pendidikan_ibu'] = request.pendidikan_ibu
                edit_walisiswa['pekerjaan_ibu'] = request.pekerjaan_ibu
                edit_walisiswa['penghasilan_ibu'] = request.penghasilan_ibu
                edit_walisiswa['nama_wali'] = request.nama_wali
                edit_walisiswa['alamat_wali'] = request.alamat_wali
                edit_walisiswa['no_hp_wali'] = request.no_hp_wali
                edit_walisiswa['keterangan'] = request.keterangan
                data_wali_siswa = '''
                                update data_wali_siswa set {0} where id_siswa = {1}
                            '''.format(generateQueryUpdate(edit_walisiswa), id_siswa)
                await session.execute(data_wali_siswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_walisiswa
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

async def delete_walisiswa(db_session: AsyncSession, id_siswa: int) -> dict:
    async with db_session as session:
        try:
            if id_siswa is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_walisiswa = '''
                                delete from data_wali_siswa where id_siswa = {0}
                            '''.format(id_siswa)

                await session.execute(delete_walisiswa)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Wali Berhasil Dihapus'
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

# Jenis Wali

async def get_list_jeniswali(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM data_jenis_wali
                
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
            'status': 'Gagal, Data JenisWali Tidak Ditemukan'
        }

async def get_detail_jeniswali(db_session: AsyncSession, id_jeniswali: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM data_jenis_wali WHERE id = {0}
            '''.format(id_jeniswali)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Gagal, Data Wali Tidak Ditemukan'
        }

async def add_jeniswali(db_session: AsyncSession, request: JenisWali) -> dict:
    async with db_session as session:
        try:
            jeniswali_id = """
                            SELECT jenis_wali FROM data_jenis_wali where LOWER(jenis_wali) = LOWER('{0}')
                    """.format(request.jenis_wali)
            proxy_rows = await session.execute(jeniswali_id)
            nama_jeniswali = proxy_rows.scalar()

            if nama_jeniswali is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Jenis Wali Sudah Ada'
                        }
            else:
                id_jeniswali = await session.execute('''select nextval('data_jenis_wali_id_seq') as id''')
                id_jeniswali = id_jeniswali.one_or_none()
                new_jeniswali = {}
                new_jeniswali['id'] = id_jeniswali.id
                new_jeniswali['jenis_wali'] = request.jenis_wali
                data_jeniswali = generateQuery('data_jenis_wali', new_jeniswali)
                logging.debug(f'query : {data_jeniswali}')
                await session.execute(data_jeniswali)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_jeniswali
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

async def edit_jeniswali(db_session: AsyncSession, request: JenisWali, id_jeniswali: int) -> dict:
    async with db_session as session:
        try:
            if id_jeniswali is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_jeniswali = {}
                edit_jeniswali['jenis_wali'] = request.jenis_wali
                data_jeniswali = '''
                                update data_jenis_wali set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_jeniswali), id_jeniswali)
                await session.execute(data_jeniswali)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_jeniswali
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

async def delete_jeniswali(db_session: AsyncSession, id_jeniswali: int) -> dict:
    async with db_session as session:
        try:
            if id_jeniswali is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_jeniswali = '''
                                delete from data_jenis_wali where id = {0}
                            '''.format(id_jeniswali)
                await session.execute(delete_jeniswali)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Jenis Wali Berhasil Dihapus'
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

# Laporan Pembayaran
async def get_list_laporanpembayaran(db_session: AsyncSession, page: int, show: int) -> dict:
    async with db_session as session:
        try:
            offset = (page - 1) * show
            q_dep = '''
                SELECT * FROM laporan_pembayaran
                
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
            'status': 'Gagal, Data Laporan Pembayaran Tidak Ditemukan'
        }

async def get_detail_laporanpembayaran(db_session: AsyncSession, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                SELECT * FROM laporan_pembayaran WHERE id = {0}
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
            'status': 'Gagal, Data Laporan Pembayaran Tidak Ditemukan'
        }

async def add_laporanpembayaran(db_session: AsyncSession, request: LaporanPembayaran) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                            SELECT id, id_jeniswali FROM laporan_pembayaran
                            where id_jeniswali = {0}
                    '''.format(request.id_jeniswali)
            proxy_rows = await session.execute(q_dep)
            jenis_wali = proxy_rows.scalar()
            print(jenis_wali)
            if jenis_wali is not None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Jenis Wali Tidak Boleh Lebih Dari Satu'
                        }
            else:
                id_laporanpembayaran = await session.execute('''select nextval('laporan_pembayaran_id_seq') as id''')
                id_laporanpembayaran = id_laporanpembayaran.one_or_none()
                new_laporanpembayaran = {}
                new_laporanpembayaran['id'] = id_laporanpembayaran.id
                new_laporanpembayaran['id_jeniswali'] = request.id_jeniswali
                new_laporanpembayaran['file_kk'] = request.file_kk
                new_laporanpembayaran['tempat_lahir'] = request.tempat_lahir
                new_laporanpembayaran['tanggal_lahir'] = request.tanggal_lahir
                new_laporanpembayaran['alamat'] = request.alamat
                new_laporanpembayaran['no_hp'] = request.no_hp
                new_laporanpembayaran['id_pendidikan'] = request.id_pendidikan
                new_laporanpembayaran['pekerjaan'] = request.pekerjaan
                new_laporanpembayaran['penghasilan'] = request.penghasilan
                new_laporanpembayaran['nomor_kks'] = request.nomor_kks
                new_laporanpembayaran['nomor_pkh'] = request.nomor_pkh
                laporan_pembayaran = generateQuery('laporan_pembayaran', new_laporanpembayaran)
                logging.debug(f'query : {laporan_pembayaran}')
                await session.execute(laporan_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': new_laporanpembayaran
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

async def edit_laporanpembayaran(db_session: AsyncSession, request: LaporanPembayaran, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_laporanpembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                edit_laporanpembayaran = {}
                edit_laporanpembayaran['id_jeniswali'] = request.id_jeniswali
                edit_laporanpembayaran['file_kk'] = request.file_kk
                edit_laporanpembayaran['tempat_lahir'] = request.tempat_lahir
                edit_laporanpembayaran['tanggal_lahir'] = request.tanggal_lahir
                edit_laporanpembayaran['alamat'] = request.alamat
                edit_laporanpembayaran['no_hp'] = request.no_hp
                edit_laporanpembayaran['id_pendidikan'] = request.id_pendidikan
                edit_laporanpembayaran['pekerjaan'] = request.pekerjaan
                edit_laporanpembayaran['penghasilan'] = request.penghasilan
                edit_laporanpembayaran['nomor_kks'] = request.nomor_kks
                edit_laporanpembayaran['nomor_pkh'] = request.nomor_pkh
                laporan_pembayaran = '''
                                update laporan_pembayaran set {0} where id = {1}
                            '''.format(generateQueryUpdate(edit_laporanpembayaran), id_laporanpembayaran)
                await session.execute(laporan_pembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'data': edit_laporanpembayaran
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

async def delete_laporanpembayaran(db_session: AsyncSession, id_laporanpembayaran: int) -> dict:
    async with db_session as session:
        try:
            if id_laporanpembayaran is None:
                return {
                            'message_id': '01',
                            'status': 'Gagal, Data Tidak Ditemukan'
                        }
            else:
                delete_laporanpembayaran = '''
                                delete from laporan_pembayaran where id = {0}
                            '''.format(id_laporanpembayaran)

                await session.execute(delete_laporanpembayaran)
                await session.commit()
                return {
                    'message_id': '00',
                    'status': 'Sukses',
                    'message': 'Data Wali Berhasil Dihapus'
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
