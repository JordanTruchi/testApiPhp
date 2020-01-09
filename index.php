<?php
include_once ('./router/possibleRoute.php');
include_once ('env.php');
include_once ('controllers/taskController.php');
include_once ('./services/validator/validator.php');
include_once ('./services/helper/helper.php');

if($ressourcesAsk === ROUTER_TASKS && $requestMethod === 'GET') {
    listTask();
}

if(preg_match(ROUTER_ONE_TASK, $ressourcesAsk) && $requestMethod === 'GET') {
    $idToSearch = ltrim($ressourcesAsk, '/tasks/');
    oneTask($idToSearch);
}

if(preg_match(ROUTER_ONE_TASK, $ressourcesAsk) && $requestMethod === 'PATCH') {
    $idToSearch = ltrim($ressourcesAsk, '/tasks/');
    $data = file_get_contents('php://input');
    $data = json_decode($data);
    updateTask($idToSearch, $data->name, $data->date, $data->categorie, $data->content, $data->images);
}

if(preg_match(ROUTER_ONE_TASK, $ressourcesAsk) && $requestMethod === 'DELETE') {
    $idToDelete = ltrim($ressourcesAsk, '/tasks/');
    deleteTask($idToDelete);
}

if($ressourcesAsk === ROUTER_TASKS && $requestMethod === 'POST') {
    $data = file_get_contents('php://input');
    $data = json_decode($data);
    postTask($data->name, $data->date, $data->categorie, $data->content, $data->images);
}
?>