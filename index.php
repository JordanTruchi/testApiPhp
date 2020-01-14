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

if(preg_match(ROUTER_ONE_TASK, $ressourcesAsk) && $requestMethod === 'POST') {
    $idToSearch = ltrim($ressourcesAsk, '/tasks/');
    updateTask($idToSearch, $_POST['titleTask'], $_POST['dateTask'], $_POST['categTask'], $_POST['contentTask'], $_FILES);
}

if(preg_match(ROUTER_ONE_TASK, $ressourcesAsk) && $requestMethod === 'DELETE') {
    $idToDelete = ltrim($ressourcesAsk, '/tasks/');
    deleteTask($idToDelete);
}

if($ressourcesAsk === ROUTER_TASKS && $requestMethod === 'POST') {
    postTask($_POST['titleTask'], $_POST['dateTask'], $_POST['categTask'], $_POST['contentTask'], $_FILES);
}
?>