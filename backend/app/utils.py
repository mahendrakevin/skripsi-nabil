import logging

#logging.config.fileConfig('logging.conf', disable_existing_loggers=False)

# logger file
#fileHandler = logging.FileHandler(f'logs/{datetime.strftime(datetime.now(), "%Y-%m-%d")}.log', 'a')
#logFormatter = logging.Formatter('%(asctime)s loglevel=%(levelname)-6s logger=%(name)s %(funcName)s() L%(lineno)-4d %(message)s')
#fileHandler.setFormatter(logFormatter)
#fileHandler.setLevel(logging.DEBUG)

logger = logging.getLogger(__name__)
#logger.addHandler(fileHandler)

def cekDict(key, subkey, dictionary, value):
    if subkey in dictionary[key]:
        data = dictionary[key][subkey][value]
    else:
        if value == 'refdata_id':
            data = 0
        else :
            data = ''

    return data
#--

def queryVal(x):
  if type(x) == list: return x[0]
  elif type(x) == str: return repr(x.replace('\'','\'\''))
  elif type(x) == None: return 'null'
  else: return str(x)
#--

def utfDictToString(data):
    return dict([(str(k), v) for k, v in data.items()])
#--

def unpackDictForQuery(params):
    columns = ', '.join(params.keys())
    values  = ', '.join([queryVal(x) for x in params.values()])
    
    return columns, values
#--

def makeDate(dateVal, dateFmt):
  return 'to_date({0!r}, {1!r})'.format(dateVal[:14], dateFmt)
#--

def generateQuery(table, params):
    pars = utfDictToString(params)
    columns, values = unpackDictForQuery(pars)
    s = '''
        insert into {0} ({1}) values ({2})
    '''.format(table, columns, values)
    s = s.replace('"','\'')
    logger.info(s)
    return s
#--

def generateQueryUpdate(params):
  setval  = ', '.join(['{0} = {1}'.format(x, queryVal(params[x])) for x in params.keys()])
  
  return setval
#--