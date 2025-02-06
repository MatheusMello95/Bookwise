<?php

class Livro
{
  public $id;
  public $titulo;
  public $autor;
  public $descricao;
  public $ano_de_lancamento;
  public $usuario_id;
  public $imagem;
  public $sumNota;
  public $numeroAvaliacoes;
  
  public function query($where, $params)
  {
    $database = new Database(config('database'));
    return $database->query(
      query: "SELECT
      l.id, l.titulo, l.autor, l.descricao, l.ano_de_lancamento, l.imagem,
      ifnull(round(sum(a.nota) / count(a.id)), 0) as sumNota, ifnull(count(a.id), 0) as numeroAvaliacoes
    FROM
      livros l
      LEFT JOIN avaliacoes a on a.livro_id = l.id
    WHERE
      $where
    GROUP BY
      l.id, l.titulo, l.autor, l.descricao, l.ano_de_lancamento, l.imagem",
      class: Livro::class,
      params: $params
    );
  }

  public static function getBook($id)
  {
    return (new self)->query('l.id = :id',['id' => $id])->fetch();
  }

  public static function getAll($filtro)
  {
    return (new self)->query('l.titulo like :filtro',['filtro' => "%$filtro%"])->fetchAll();
  }

  public static function meusLivros($id)
  {
    return (new self)->query('l.usuario_id = :id',['id' => $id])->fetchAll();
  }
}
