from Tech_Hole import db, login_manager
from flask_login import UserMixin


@login_manager.user_loader
def load_user(usuario_id):
    return Usuario.query.get(usuario_id)


class Usuario(db.Model, UserMixin):
    id = db.Column(db.Integer, primary_key=True)
    nome = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    senha = db.Column(db.String(255), nullable=False)
    tipo = db.Column(db.String(20), default="cliente", nullable=False)