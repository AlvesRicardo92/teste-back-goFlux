<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ERROR);

/* CONSTANTES DO BANCO */
define(HOST, 'localhost');
define(BANCO, 'base_api');
define(USUARIO, 'root');
define(SENHA, '');

/* OUTRAS CONSTANTES */
define(DS, DIRECTORY_SEPARATOR);
define(DIR_APP, __DIR__);
define(DIR_PROJETO, 'api');

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    die('Falha ao carregar autoload!');
}


