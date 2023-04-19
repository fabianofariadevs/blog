<?php

//Arquivo de configuração do sistema
//define o fuso horario
date_default_timezone_set('America/Sao_Paulo');

//dados de acesso ao banco de dados
define('DB_HOST', 'localhost');
define('DB_PORTA', '3307');
define('DB_NOME', 'db_labconsultoria');
define('DB_USUARIO', 'root');
define('DB_SENHA', '');

//db_labconsultoria

//informações do sistema
define('SITE_NOME', 'LAB - Consultoria e Treinamentos');
define('SITE_DESCRICAO', 'LAB Consultoria');

//urls do sistema
define('URL_PRODUCAO', 'https://labct.com.br');
define('URL_DESENVOLVIMENTO', 'http://localhost/blog');

define('URL_SITE', 'blog/');
define('URL_ADMIN', 'blog/admin/');
