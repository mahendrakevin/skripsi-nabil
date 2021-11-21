from sqlalchemy.engine import result
from sqlalchemy.ext.asyncio import AsyncSession
import gevent
from sqlalchemy.exc import SQLAlchemyError
from fastapi.logger import logger
from sqlalchemy.future import select
from sqlalchemy import func
from utils import *
from schemas import ProjectBaseSchema
import logging

logging.basicConfig(level=logging.DEBUG)

async def getSummary(request: ProjectBaseSchema , db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select sum("Total_Favorite") as total_favorite, sum("Total_Retweet") as total_retweet,
                sum("Total_Reaction") as total_reaction,
                sum("Total_Hashtag") as total_hashtag, sum("Total_Mention") as total_mention from socialmediadb.test
                where keyword in ('%(keyword)s')
                
            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'status': 'Failed, Keyword Not Found'
        }


async def getCountDaily(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select SUM("Total_Favorite") as Total_Favorite, \
                       SUM("Total_Retweet") as Total_Retweet, \
                       SUM("Total_Reaction") as Total_Reaction, \
                       SUM("Total_Mention") as Total_Mention, \
                       SUM("Total_Hashtag") as Total_Tweet \
                       FROM socialmediadb.test
                where keyword in ('%(keyword)s')

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }


async def getCountDailySentiment(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select date, sentiment, SUM("Total_Favorite") as Total_Favorite, \
                       SUM("Total_Retweet") as Total_Retweet, \
                       SUM("Total_Reaction") as Total_Reaction, \
                       SUM("Total_Mention") as Total_Mention, \
                       SUM("Total_Hashtag") as Total_Tweet \
                       FROM socialmediadb.test
                where keyword in ('%(keyword)s')
                GROUP BY date, sentiment

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }


async def getCountDay(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select name_day, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test
                where keyword in ('%(keyword)s')
                 GROUP BY name_day

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }


async def getSentimentCount(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select sentiment, SUM("Total_Hashtag") total_tweet \
                       FROM socialmediadb.test
                where keyword in ('%(keyword)s')
                GROUP BY sentiment

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }


async def getCountCompare(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select date, keyword, SUM("Total_Favorite") Total_Favorite, \
                       SUM("Total_Retweet") Total_Retweet, \
                       SUM("Total_Reaction") Total_Reaction, \
                       SUM("Total_Mention") Total_Mention, \
                       SUM("Total_Hashtag") Total_Tweet \
                       FROM socialmediadb.test 
                where keyword in ('%(keyword)s')
                GROUP BY date, keyword

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }


async def getCompare(request: ProjectBaseSchema, db_session: AsyncSession) -> dict:
    async with db_session as session:
        try:
            q_dep = '''
                select keyword, SUM("Total_Favorite") Total_Favorite, \
                       SUM("Total_Retweet") Total_Retweet, \
                       SUM("Total_Reaction") Total_Reaction, \
                       SUM("Total_Mention") Total_Mention, \
                       SUM("Total_Hashtag") Total_Tweet \
                       FROM socialmediadb.test
                where keyword in ('%(keyword)s')
                    GROUP BY keyword

            ''' % {
                'keyword': request.keyword
            }
            proxy_rows = await session.execute(q_dep)
            result = proxy_rows.all()
            print(q_dep)
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
            'data': result
        }
    else:
        return {
            'message_id': '01',
            'status': 'Failed, Keyword Not Found'
        }

'''
summary: 
"select SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test"
                       
count-daily /Trend Social Media 
"select date, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test GROUP BY date"
                       
count-daily-sentiment/Trend Sentiment Analysis
"select date, sentiment, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test GROUP BY date, sentiment"
                       
count-day /Chart Social Media In Day 
"select name_day, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test GROUP BY name_day"
                       
Pie Chart 
"select sentiment, SUM(total_tweet) total_tweet \
                       FROM socialmediadb.test GROUP BY sentiment"
                       
                       
count_compare/Comparison Trend Social Media 
"select date, keyword, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test GROUP BY date, keyword"
                       
compare / Comparison Chart Analysis User
"select keyword, SUM(Total_Favorite) Total_Favorite, \
                       SUM(Total_Retweet) Total_Retweet, \
                       SUM(Total_Reaction) Total_Reaction, \
                       SUM(Total_Mention) Total_Mention, \
                       SUM(Total_Tweet) Total_Tweet \
                       FROM socialmediadb.test GROUP BY keyword"
                       
'''









