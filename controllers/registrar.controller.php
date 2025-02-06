<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $validacao = Validacao::validar([
    'nome' => ['required'],
    'email' => ['required', 'email', 'confirmed', 'unique:usuarios'],
    'password' => ['required', 'min:8', 'max:30', 'strong']
  ], $_POST);

  if ($validacao->naoPassou('registrar')) {
    
    header('location: /login');
    exit();
  }


  $database->query(
    query: "INSERT INTO usuarios ( name, email, senha) VALUES (:nome, :email, :senha)",
    params: [
      "nome" => $_POST['nome'],
      "email" => $_POST['email'],
      "senha" => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]
  );

  flash()->push('mensagem', 'Registrado com sucesso! 👍');

  header('location: /login');
  exit();
} 
header('location: /login');
exit();
