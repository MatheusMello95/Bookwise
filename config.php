<?php
return [
  'database' => [
    'driver' => 'sqlite',
    'database' => '../database.sqlite'
  ]
];

/**
 * Exemplo de conexão com Mysql
 */
// $config = [
//   'driver' => 'mysql',
//   'host' => '127.0.0.1',
//   'port' => 3306,
//   'dbname' => 'bookwise',
//   'user' => 'root',
//   'charset' => 'utf8mb4'
// ];

// $driver = $config['driver'];

// unset($config['driver']);

// $dsn = $driver.':'. http_build_query($config, '',';');

// $this->db = new PDO($dsn);