from Personalize import app
from flask import render_template, redirect, url_for, flash
from Personalize.forms import cadastroForm, loginForm, Usuario
from flask_login import login_user, logout_user, current_user, login_required

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
@login_required
def dashboard():
    return render_template('dashboard.html')


@app.route("/cadastrar", methods=['GET', 'POST'])
def cadastrar():
    form = cadastroForm()

    erro = None

    if form.validate_on_submit():
        user = form.salvar()

        if isinstance(user, Usuario):
            login_user(user, remember=True)
            return redirect(url_for('home'))

        flash(user, "erro")
        return redirect(url_for('cadastrar'))
    
    return render_template('cadastrar.html',
                           form = form,
                           erro = erro)


@app.route("/login", methods=['GET', 'POST'])
def login():
    if current_user.is_authenticated:
        return redirect(url_for('home'))
    
    form = loginForm()

    erro = None

    if form.validate_on_submit():
        user = form.login()

        if isinstance(user, Usuario):
            login_user(user, remember=True)
            return redirect(url_for('home'))

        flash(user, "erro")
        return redirect(url_for('cadastrar'))
    
    return render_template('login.html',
                           form = form,
                           erro = erro)



@app.route("/contato")
def contato():
    return render_template('contato.html')


