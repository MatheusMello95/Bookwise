<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
  header('location: /meus-livros');
  exit();
}
if(!auth()){
  abort(403);
}
$usuario_id = auth()->id;
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$descricao = $_POST['descricao'];
$ano_de_lancamento = $_POST['ano_de_lancamento'];

$validacao = Validacao::validar([
  'titulo' => ['required', 'min:3'],
  'autor' => ['required'],
  'descricao' => ['required'],
  'ano_de_lancamento' => ['required']
], $_POST);

if ($validacao->naoPassou('livro-criar')) {
  
  header('location: /meus-livros');
  exit();
}

$newName = md5(rand());
$extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
$imagem = "images/$newName.$extensao";

move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__. '/../public/'.$imagem);

$database->query(
  query: "INSERT INTO livros (titulo, autor, descricao, ano_de_lancamento, usuario_id, imagem)
            VALUES (:titulo, :autor, :descricao, :ano_de_lancamento, :usuario_id, :imagem)",
  params: [
    'titulo' => $titulo,
    'autor' => $autor,
    'descricao' => $descricao,
    'ano_de_lancamento' => $ano_de_lancamento,
    'usuario_id' => $usuario_id,
    'imagem' => $imagem
  ]
);

flash()->push('mensagem', 'Livro Cadastrado com sucesso!');

header('location: /meus-livros');
exit();