<?php
$DB_DSN = 'mysql:host=localhost;dbname=hopital_php';
$DB_USER = 'user1';
$DB_PASS = 'hcetylop';
$OPTIONS = [
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  /*PDO::ATTR_PERSISTENT => true,*/
  PDO::ATTR_EMULATE_PREPARES => false
];
