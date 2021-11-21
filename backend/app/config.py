import secrets, os
from typing import Any, Dict, List, Optional, Union

from pydantic import (  # noqa: F401
    AnyHttpUrl,
    BaseSettings,
    EmailStr,
    HttpUrl,
    PostgresDsn,
    validator,
)


class Settings(BaseSettings):
    API_V1_STR: str = "/api/v1"
    SECRET_KEY: str = secrets.token_urlsafe(32)
    AES_SECRET_KEY: Optional[str]
    FCM_SERVER_KEY: str
    # 60 minutes * 24 hours * 8 days = 8 days
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 60
    REFRESH_TOKEN_EXPIRE_MINUTES: int = 60 * 24 * 30
    #SERVER_NAME: str
    #SERVER_HOST: AnyHttpUrl
    # BACKEND_CORS_ORIGINS is a JSON-formatted list of origins
    # e.g: '["http://localhost", "http://localhost:4200", "http://localhost:3000", \
    # "http://localhost:8080"]'
    BACKEND_CORS_ORIGINS: List[AnyHttpUrl] = []

    @validator("BACKEND_CORS_ORIGINS", pre=True)
    def assemble_cors_origins(cls, v: Union[str, List[str]]) -> Union[List[str], str]:
        if isinstance(v, str) and not v.startswith("["):
            return [i.strip() for i in v.split(",")]
        elif isinstance(v, (list, str)):
            return v
        raise ValueError(v)

    PROJECT_NAME: str

    #POSTGRES_SERVER: str
    #POSTGRES_USER: str
    #POSTGRES_PASSWORD: str
    #POSTGRES_DB: str
    #POSTGRES_PORT: Optional[str]
    #SQLALCHEMY_DATABASE_URI: Optional[PostgresDsn] = None
    POSTGRES_DB_PROVIDER: str = os.getenv('POSTGRES_DB_DRIVER')
    POSTGRES_DB_DRIVER: str = os.getenv('POSTGRES_DB_DRIVER')
    POSTGRES_DB_SERVER: str = os.getenv('POSTGRES_DB_SERVER')
    POSTGRES_DB_API_USER: str = os.getenv('POSTGRES_DB_API_USER')
    POSTGRES_DB_API_PASSWORD: str = os.getenv('POSTGRES_DB_API_PASSWORD')
    POSTGRES_DB_API_NAME: str = os.getenv('POSTGRES_DB_API_NAME')
    POSTGRES_DB_PORT_EXPOSE: str = os.getenv('POSTGRES_DB_PORT_EXPOSE')
    SQLALCHEMY_DATABASE_URI: Optional[str] = None

    @validator("SQLALCHEMY_DATABASE_URI", pre=True)
    def assemble_db_connection(cls, v: Optional[str], values: Dict[str, Any]) -> Any:
        if isinstance(v, str):
            return v
        # dialect[+driver]://user:password@host/dbname[?key=value..]
        scheme = values.get("POSTGRES_DB_PROVIDER")
        driver = values.get("POSTGRES_DB_DRIVER", '')
        if driver not in ('', None):
            driver = '+' + driver
        user = values.get("POSTGRES_DB_API_USER")
        password = values.get("POSTGRES_DB_API_PASSWORD")
        host = values.get("POSTGRES_DB_SERVER")
        if values.get("POSTGRES_DB_PORT_EXPOSE") not in ('', None):
            host = host + ':' + values.get("POSTGRES_DB_PORT_EXPOSE")
        database = values.get("POSTGRES_DB_API_NAME")
        return "{}{}://{}:{}@{}/{}".format(scheme, driver, user, password, host, database)
    #--

    #def assemble_db_connection(cls, v: Optional[str], values: Dict[str, Any]) -> Any:
    #    if isinstance(v, str):
    #        return v
    #    return PostgresDsn.build(
    #        scheme="postgresql",
    #        user=values.get("POSTGRES_USER"),
    #        password=values.get("POSTGRES_PASSWORD"),
    #        host=values.get("POSTGRES_SERVER"),
    #        port=values.get("POSTGRES_PORT"),
    #        path=f"/{values.get('POSTGRES_DB') or ''}",
    #    )

    SMTP_TLS: bool = True
    SMTP_PORT: Optional[int] = None
    SMTP_HOST: Optional[str] = None
    SMTP_USER: Optional[str] = None
    SMTP_PASSWORD: Optional[str] = None
    EMAILS_FROM_NAME: Optional[str] = None

    @validator("EMAILS_FROM_NAME")
    def get_project_name(cls, v: Optional[str], values: Dict[str, Any]) -> str:
        if not v:
            #return values["PROJECT_NAME"]
            return 'bmsservices'
        return v

    EMAIL_RESET_TOKEN_EXPIRE_HOURS: int = 48
    EMAIL_TEMPLATES_DIR: str = "/app/app/email-templates"
    EMAILS_ENABLED: bool = False

    @validator("EMAILS_ENABLED", pre=True)
    def get_emails_enabled(cls, v: bool, values: Dict[str, Any]) -> bool:
        return bool(
            values.get("SMTP_HOST")
            and values.get("SMTP_PORT")
            and values.get("EMAILS_FROM_EMAIL")
        )

    EMAIL_TEST_USER: EmailStr = "test@example.com"  # type: ignore
    FIRST_SUPERUSER: EmailStr
    FIRST_SUPERUSER_PASSWORD: str
    USERS_OPEN_REGISTRATION: bool = False

    # String Env
    BACKEND_CORS_ORIGINS_STR: str
    AES_SECRET_KEY_STR: str
    SMTP_TLS_STR: str
    SMTP_PORT_STR: str
    USERS_OPEN_REGISTRATION_STR: str
    PGADMIN_LISTEN_PORT: Optional[str]
    PGADMIN_LISTEN_PORT_STR: str

    class Config:
        case_sensitive = True
        env_file = ".env"


settings = Settings()

# str convert
settings.BACKEND_CORS_ORIGINS = settings.BACKEND_CORS_ORIGINS_STR.split(';')
settings.AES_SECRET_KEY = settings.AES_SECRET_KEY_STR

settings.SMTP_PORT = settings.SMTP_PORT_STR
if settings.SMTP_TLS_STR == "True":
    settings.SMTP_TLS = True
else:
    settings.SMTP_TLS = False
# --

if settings.USERS_OPEN_REGISTRATION_STR == "True":
    settings.USERS_OPEN_REGISTRATION = True
else:
    settings.USERS_OPEN_REGISTRATION = False
# --

settings.PGADMIN_LISTEN_PORT = settings.PGADMIN_LISTEN_PORT_STR