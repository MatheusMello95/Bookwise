<?php

function dd(...$dump)
{
  echo "<pre>";
  var_dump($dump);
  echo "</pre>";
  die();
}

function abort( $code)  {
  http_response_code(404);
    view($code);
    die();
}

function view($view, $data =[]) {
  foreach($data as $key => $value){
    $$key = $value;
  }
  require "views/template/app.php";
}

function flash(){
  return new Flash;
}
function config($key = null){
  $config = require 'config.php';

  if(strlen($key) > 0){
    return $config[$key];
  }
  return $config;
}

function auth(){
  if(! isset($_SESSION['auth'])){
    return null;
  }

  return $_SESSION['auth'];
}