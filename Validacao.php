<?php

class Validacao
{

  public $validacoes = [];

  public static function validar($regras, $dados)
  {
    $validacao = new self;
    foreach ($regras as $campo => $regrasDoCampo) {
      foreach ($regrasDoCampo as $regra) {
        $valorDoCampo = $dados[$campo];
        if ($regra == 'confirmed') {
          $validacao->$regra($campo, $valorDoCampo, $dados["{$campo}_confirmacao"]);
        } else if (str_contains($regra, ':')) {
          $temp = explode(':', $regra);
          $regra = $temp[0];
          $regraAr = $temp[1];
          $validacao->$regra($regraAr, $campo, $valorDoCampo);
        } else {
          $validacao->$regra($campo, $valorDoCampo);
        }
      }
    }
    return $validacao;
  }

  private function required($campo, $valor)
  {
    if (strlen($valor) == 0) {
      $this->validacoes[] = "O $campo é obrigatorio";
    }
  }

  private function email($campo, $valor)
  {
    if (! filter_var($valor, FILTER_VALIDATE_EMAIL)) {
      $this->validacoes[] = "O $campo é invalido";
    }
  }

  private function confirmed($campo, $valor, $valorConfirmed)
  {
    if ($valor != $valorConfirmed) {
      $this->validacoes[] = "O $campo não corresponde com o $valorConfirmed";
    }
  }

  private function min($min, $campo, $valor)
  {
    if (strlen($valor) <= $min) {
      $this->validacoes[] = "O $campo precia ter no minimo $min caracteres";
    }
  }
  private function max($max, $campo, $valor)
  {
    if (strlen($valor) > $max) {
      $this->validacoes[] = "O $campo precia ter no maximo $max caracteres";
    }
  }
  private function strong($campo, $valor)
  {
    if (! strpbrk($valor, '*-%$#&^@!')) {
      $this->validacoes[] = "O $campo precisa ter pelo menos 1 caracter especial";
    }
  }

  private function unique($table, $campo, $valor)
  {
    if (strlen($valor) == 0) {
      return;
    }
    $db = new Database(config('database'));

    $result = $db->query(
      query: "SELECT * FROM $table WHERE $campo = :email",
      params: [
        'email' => $valor
      ]
    )->fetch();
      if($result){
        $this->validacoes[] = "Esse $campo ja esta cadastrado no nosso sistema!";
      }
  }

  public function naoPassou($customName = null)
  {
    $key = 'validacoes';
    if($customName){
      $key .= '_'. $customName;
    }
    flash()->push($key, $this->validacoes);
    return sizeof($this->validacoes) > 0;
  }
}
