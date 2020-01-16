<?php
include ('./models/tasks.php');

function listTask() {
	try {
		$list = task::allTask();
		header('Content-Type: application/json');
		echo json_encode($list);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function oneTask($id) {
	try {
		$task = task::getOne($id);
		header('Content-Type: application/json');
		echo json_encode($task);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function postTask($name, $date, $categorie, $content, $images) {
	try {
		$task = new Task('', $name, $date, $categorie, $content, $images);
		$postedTask = $task->create($task);
 		header('Content-Type: application/json');
		echo json_encode($postedTask, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function updateTask($id, $name, $date, $categorie, $content, $images) {
	try {
		$task = new Task('', $name, $date, $categorie, $content, $images);
		$isTaskExist = $task->getOne($id);
		$task = $task->patch($id, $task);
		$task->setId($id);
		if(isEmpty($task->getName())) $task->setName($isTaskExist['name']);
		if(isEmpty($task->getDate())) $task->setDate($isTaskExist['date']);
		if(isEmpty($task->getCategorie())) $task->setCategorie($isTaskExist['categorie']);
		if(isEmpty($task->getContent())) $task->setContent($isTaskExist['content']);
		if(isEmpty($task->getImages())) $task->setImages($isTaskExist['images']);
		header('Content-Type: application/json');
		echo json_encode($task, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function deleteTask($id) {
	try {
		$task = new Task('', '', '', '', '', '');
		$isTaskExist = $task->getOne($id);
		$messageIfDeleted = $task->delete($id);
		header('Content-Type: application/json');
		echo json_encode($messageIfDeleted, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}
?>