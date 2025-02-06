<?php

class Database
{
  private $db;

  public function __construct($config)
  {
    $this->db = new PDO($this->getDsn($config));
  }

  private function getDsn($config)
  {
    $driver = $config['driver'];

    unset($config['driver']);

    $dsn = $driver . ':' . http_build_query($config, '', ';');
    if ($driver == 'sqlite') {
      $dsn = $driver . ':' . $config['database'];
    }
    return $dsn;
  }

  public function query($query, $class = null, $params = [])
  {
    $prepare = $this->db->prepare($query);
    if ($class) {
      $prepare->setFetchMode(PDO::FETCH_CLASS, $class);
    }
    $prepare->execute($params);

    return $prepare;
  }

  // public function livros($pesquisa = '')
  // {

  //   $prepare = $this->db->prepare("SELECT * 
  //           FROM livros 
  //           where 
  //             titulo like :pesquisa 
  //             or autor like :pesquisa 
  //             or descricao like :pesquisa
  //   ");
  //   $prepare->bindValue(':pesquisa', "%$pesquisa%");
  //   $prepare->setFetchMode(PDO::FETCH_CLASS, Livro::class);
  //   $prepare->execute();
  //   return $prepare->fetchAll();
  // }

  // public function livro($id)
  // {

  //   $prepare = $this->db->prepare("SELECT * 
  //           FROM livros 
  //           where 
  //             id = :id
  //   ");
  //   $prepare->bindValue(':id', $id);
  //   $prepare->setFetchMode(PDO::FETCH_CLASS, Livro::class);
  //   $prepare->execute();

  //   return $prepare->fetch();
  // }
}

$database = new Database(config('database'));
