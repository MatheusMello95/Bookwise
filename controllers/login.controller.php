<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];

  $validacao = Validacao::validar([
    'email' => ['required', 'email'],
    'password' => ['required']
  ], $_POST);

  if ($validacao->naoPassou('login')) {
    
    header('location: /login');
    exit();
  }

  $usuario = $database->query(
    query: "SELECT * FROM usuarios WHERE email = :email",
    class: Usuario::class,
    params: compact('email'),
  )->fetch();
  if ($usuario) {

    if(! password_verify($_POST['password'], $usuario->senha)){
      flash()->push('validacoes_login', ['Usuario ou senha invalidos!']);
      header('location: /login');
      exit();
    }

    $_SESSION['auth'] = $usuario;
    flash()->push('mensagem', 'Seja Bem vindo ' . $usuario->name . '!');
    header('location: /');
    exit();
  }
}

view('login');
