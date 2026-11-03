from Tech_Hole import app
from flask import render_template, redirect, url_for, flash
from Tech_Hole.forms import cadastroForm, loginForm, Usuario
from flask_login import login_user, logout_user, current_user

@app.route("/")
def home():
    return render_template('home.html')


@app.route("/produtos")
def produtos():
    return render_template('produtos.html')


@app.route("/sobre")
def sobre():
    return render_template('sobre.html')


@app.route("/dashboard")
def dashboard():
    return render_template('dashboard.html')


@app.route("/cadastrar", methods=['GET', 'POST'])
def cadastrar():
    form1 = cadastroForm()

    erro1 = None

    if form1.validate_on_submit():
        user1 = form1.salvar()

        if isinstance(user1, Usuario):
            login_user(user1, remember=True)
            return redirect(url_for('home'))

        flash(user1, "erro")
        return redirect(url_for('cadastrar'))
    
    return render_template('cadastrar.html',
                           form1 = form1,
                           erro1 = erro1)


@app.route("/login")
def login():
    return render_template('login.html')


@app.route("/contato")
def contato():
    return render_template('contato.html')


