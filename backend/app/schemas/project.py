from datetime import datetime, date
from sys import modules
from pydantic import BaseModel
from typing import Optional, List, Text

from pydantic.fields import Field
from sqlalchemy.orm import selectinload
from sqlalchemy.sql.sqltypes import String


class ProjectBaseSchema(BaseModel):
    keyword: Optional[str] = "BUMN"
    start_date: Optional[str] = "2011-11-19"
    end_date: Optional[str] = "2021-11-19"
    sentiment: Optional[str] = "1"

