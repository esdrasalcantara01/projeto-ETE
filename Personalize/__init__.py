from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate
from flask_login import LoginManager
from flask_bcrypt import Bcrypt
from dotenv import load_dotenv
import os

load_dotenv('.env')

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = os.getenv('DATABASE_URI')
app.config['SECRET_KEY'] = os.getenv('SECRET_KEY')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['UPLOAD_PROFILE'] = r'static/img_perfil'


db = SQLAlchemy(app)
migrate = Migrate(app, db)
login_manager = LoginManager(app)
bcrypt = Bcrypt(app)

from Personalize import models
from Personalize import views