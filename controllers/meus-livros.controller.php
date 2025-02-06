<?php

if(!auth()){
  header('location: /');
  exit();
}

$livros = Livro::meusLivros(auth()->id);

view('meus-livros', compact('livros'));