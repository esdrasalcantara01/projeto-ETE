from flask_wtf import FlaskForm
from wtforms.validators import DataRequired, Email
from wtforms import StringField, PasswordField, SubmitField, SelectField, FileField
from Personalize.models import Usuario
from Personalize import bcrypt, db, app
from flask_login import current_user

import os
from werkzeug.utils import secure_filename

class cadastroForm(FlaskForm):
    nome = StringField('nome: ', validators=[DataRequired()])
    email = StringField('E-mail: ', validators=[DataRequired(), Email()])
    senha = PasswordField('senha', validators=[DataRequired()])
    imagemPerfil = FileField('foto')
    enviar = SubmitField('Cadastrar')

    def salvar(self):
          
       senha = bcrypt.generate_password_hash(
            self.senha.data.encode('utf-8')
         ).decode("utf-8")
       
       usuário = Usuario.query.filter(Usuario.email == self.email.data).first()
       
       if usuário: 
          erro = f'Esse E-mail já existe!'
          return erro

       imagemPerfil = self.imagemPerfil.data
       
       nome_seguro = "login, cadastro.jpeg"
       caminho = None

       if imagemPerfil and imagemPerfil.filename:
          nome_seguro = secure_filename(imagemPerfil.filename)
          caminho = os.path.join(
             os.path.abspath(os.path.dirname(__file__)),
             app.config['UPLOAD_PROFILE'],
             'perfil',
             nome_seguro
          )

          os.makedirs(os.path.dirname(caminho), exist_ok=True)
          
       usuário = Usuario(
          nome = self.nome.data,
          email = self.email.data,
          imagemPerfil = nome_seguro,
          senha = senha
       )

       if caminho:
        print("Nome:", imagemPerfil.filename)
        print("Caminho:", caminho)
        print("Tipo:", imagemPerfil.mimetype)
        print("Posição do arquivo:", imagemPerfil.stream.tell())
        imagemPerfil.save(caminho)
        db.session.add(usuário)
        db.session.commit()
        return usuário


   
class loginForm(FlaskForm):
  email = StringField('E-mail: ', validators=[DataRequired(), Email()])
  senha = PasswordField('senha: ', validators=[DataRequired()])
  enviar = SubmitField('Login')

  def login(self):
     usuário = Usuario.query.filter_by(nome = self.email.data).first()
     
     if usuário:
     
      if bcrypt.check_password_hash(
           usuário.senha, 
           self.senha.data
      ):

           return usuário
      else:
           erro = f'senha incorreta!'
           return erro
     else:
      erro = f'usuário inexistente!'
      return erro
