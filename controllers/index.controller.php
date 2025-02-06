<?php

$livros = Livro::getAll($_REQUEST['pesquisar'] ?? '');

view('index', compact('livros'));
