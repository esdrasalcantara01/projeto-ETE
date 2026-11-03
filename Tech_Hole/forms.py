from flask_wtf import FlaskForm
from wtforms.validators import DataRequired, Email
from wtforms import StringField, PasswordField, SubmitField, SelectField
from Tech_Hole.models import Usuario
from Tech_Hole import bcrypt, db



class cadastroForm(FlaskForm):
    nome = StringField('nome: ', validators=[DataRequired()])
    email = StringField('E-mail: ', validators=[DataRequired(), Email()])
    senha = PasswordField('senha', validators=[DataRequired()])
    tipo = SelectField('você é: ', 
                       choices=[
                          ('cliente', 'Cliente'),
                          ('vendedor', 'Vendedor')
                       ],
                       validators=[DataRequired()])
    enviar = SubmitField('Cadastrar')

    def salvar(self):
          
       senha = bcrypt.generate_password_hash(
            self.senha.data.encode('utf-8')
         ).decode("utf-8")
       
       usuário = Usuario.query.filter(Usuario.email == self.email.data).first()
       
       if usuário: 
          erro = f'Esse E-mail já existe!'
          return erro
       
       usuário = Usuario(
          nome = self.nome.data,
          email = self.email.data,
          tipo = self.tipo.data,
          senha = senha
       )

       db.session.add(usuário)
       db.session.commit()
       return usuário


   
class loginForm(FlaskForm):
  nome = StringField('nome: ', validators=[DataRequired()])
  senha = PasswordField('senha: ', validators=[DataRequired()])
  enviar = SubmitField('Login')

  def login(self):
     usuário = Usuario.query.filter_by(nome = self.nome.data).first()
     
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
