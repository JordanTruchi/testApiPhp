<?php
include ('./services/bdd.php');
include ('./models/tasks.php');

function listTask() {
	global $dbh;
	$queryTest = "SELECT * from task";
	$req = $dbh->prepare($queryTest);
	$req->execute();
	$res = $req->fetchAll(PDO::FETCH_ASSOC);
	$result = [];
	foreach ($res as $taskResp) {
		$task = new Task($taskResp['id'], $taskResp['name'], $taskResp['date'], $taskResp['categorie'], $taskResp['content'], $taskResp['images']);
		array_push($result, $task);
	}
	$req->closeCursor();
	
	echo json_encode($result);
	
}

function oneTask($id) {
	global $dbh;
	$queryTest = "SELECT * from task WHERE id =".$id;
	$req = $dbh->prepare($queryTest);
	$req->execute();
	$res = $req->fetch(PDO::FETCH_ASSOC);
	$req->closeCursor();
	echo json_encode($res);
	
}

function createTask($name, $date, $categorie, $content, $images) {
	global $dbh;
	$task = new Task('', $name, $date, $categorie, $content, $images);
	$query = 'INSERT INTO task VALUES(:id, :name, :date, :categorie, :content, :images)';
	$req = $dbh->prepare($query);
	$req->execute(array(
		':id' => $task->getId(),
        ':name' => $task->getName(),
        ':date' => $task->getDate(),
		':categorie' => $task->getCategorie(),
		':content' => $task->getContent(),
		':images' => json_encode($task->getImages())
	)) or die(print_r($req->errorInfo()));
	$req->closeCursor();
	echo json_encode($task, true);
}

function patchTask($id, $name, $date, $categorie, $content, $images) {
	global $dbh;
	$task = new Task('', $name, $date, $categorie, $content, $images);
	$query = 'INSERT INTO task VALUES(:id, :name, :date, :categorie, :content, :images)';
	$req = $dbh->prepare($query);
	$req->execute(array(
		':id' => $task->getId(),
        ':name' => $task->getName(),
        ':date' => $task->getDate(),
		':categorie' => $task->getCategorie(),
		':content' => $task->getContent(),
		':images' => json_encode($task->getImages())
	)) or die(print_r($req->errorInfo()));
	$req->closeCursor();
	echo json_encode($task, true);
}
?>