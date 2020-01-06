<?php
require_once ('env.php');
include ('controllers/taskController.php');

if($routeUrl === 'tasks' && $requestMethod === 'GET') {
    listTask();
}

$routeOneTask = '/^tasks\/[0-9]+$/';
if(preg_match($routeOneTask, $routeUrl) && $requestMethod === 'GET') {
    $idToSearch = ltrim($routeUrl, '/tasks/');
    oneTask($idToSearch);
}
if($routeUrl === 'tasks' && $requestMethod === 'POST') {
    createTask($_POST['name'], $_POST['date'], $_POST['categorie'], $_POST['content'], $_POST['images']);
}
?>