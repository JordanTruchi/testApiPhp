<?php
const BASE_URL = '/toDoList/back/api/';
const BASE_HOST = 'localhost';
const DB_PORT = '3308';
const DB_NAME = 'interior';
const LOGIN_BDD = 'root';
const MDP_BDD = '';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUrl = $_SERVER['REQUEST_URI'];
$ressourcesAsk = str_replace(BASE_URL, '', $requestUrl);
?>