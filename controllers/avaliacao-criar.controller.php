<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
  header('location: /');
  exit();
}

$usuario_id = auth()->id;
$livro_id = $_POST['livro_id'];
$avaliacao = $_POST['avaliacao'];
$nota = $_POST['nota'];

$validacao = Validacao::validar([
  'avaliacao' => ['required'],
  'nota' => ['required']
], $_POST);

if ($validacao->naoPassou('avaliacao-criar')) {
  
  header('location: /livro?id='.$livro_id);
  exit();
}

$result = $database->query(
  query: "INSERT INTO avaliacoes (usuario_id, livro_id, avaliacao, nota)
  VALUES (:usuario_id, :livro_id, :avaliacao, :nota);",
  params: [
    'usuario_id' => $usuario_id,
    'livro_id' => $livro_id,
    'avaliacao' => $avaliacao,
    'nota' => $nota
  ]
);


flash()->push('mensagem', 'Avaliação criada com sucesso!');

header('location: /livro?id='.$livro_id);
exit();