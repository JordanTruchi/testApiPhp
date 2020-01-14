<?php 
include_once ('./services/bdd.php');

class Task implements JsonSerializable {
    private $id;
    private $name;
    private $date;
    private $categorie;
    private $content;
    private $images;

    function __construct($id, $name, $date, $categorie, $content, $images) {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->categorie = $categorie;
        $this->content = $content;
        $this->images = $images;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'date' => $this->getDate(),
            'categorie' => $this->getCategorie(),
            'content' => $this->getContent(), 
            'images' => $this->getImages()
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        return $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        return $this->name = $name;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        return $this->date = $date;
    }
    
    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie) {
        return $this->categorie = $categorie;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        return $this->content = $content;
    }

    public function getImages() {
        return $this->images;
    }

    public function setImages($images) {
        if(gettype($images) === 'string')
            return $this->images = json_decode($images);
        else 
            return $this->images = $images;
    }

    public function allTask() {
        global $dbh;
        $queryTest = "SELECT * from task";
        $req = $dbh->prepare($queryTest);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        if(!$res) throw new Exception('Ressource non existante');
        foreach ($res as $key => $value) {
            $res[$key]['images'] = json_decode($value['images']);
        }
        $req->closeCursor();

        return $res;
    }

    public function getOne($id) {
        global $dbh;
        $queryTest = "SELECT * from task WHERE id =".$id;
	    $req = $dbh->prepare($queryTest);
	    $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if(!$result) throw new Exception('Ressource non existante');
	    $req->closeCursor();
        return $result;
    }

    public function create($task) {
        global $dbh;
        if(!isEmpty($task->name) || !isEmpty($task->date) || !isEmpty($task->categorie) || !isEmpty($task->content) || !isEmpty($task->images)) throw new Exception('Tous les champs ne sont pas remplis');
        
        $goodFormatImages = [];
        foreach ($task->images as $key => $image) {
            $target_file = TARGET_DIR . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            move_uploaded_file($image["tmp_name"], $target_file);
            $tempObject = new stdClass();
            $tempObject->url = '/todoList/back/api'.str_replace('.', '', TARGET_DIR).$image['name'];
            $tempObject->name = str_replace('.'.$imageFileType, '', $image['name']);
            array_push($goodFormatImages, $tempObject);
        }
        $task->setImages($goodFormatImages);
        $query = "INSERT INTO task (name, date, categorie, content, images) VALUES (:name, :date, :categorie, :content, :images)";
        $req = $dbh->prepare($query);
        $req->execute(array(
            ':name' => $task->getName(),
            ':date' => $task->getDate(),
            ':categorie' => $task->getCategorie(),
            ':content' => $task->getContent(),
            ':images' => json_encode($task->getImages())
        )) or die(print_r($req->errorInfo()));
        $req->closeCursor();
        $query = "SELECT LAST_INSERT_ID()";
        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $res = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $task->setId($res['LAST_INSERT_ID()']);
        $task->date = reverseDate8($task->date);
        return $task;
    }

    public function patch($id, $task) {
        global $dbh;
        
        $query = "UPDATE task SET";   
        if(!isEmpty($task->getName())) {
            $query .= " name = '".$task->getName()."'";
        }
        if(!isEmpty($task->getDate())) {
-            $query .= ", date = '".$task->getDate()."'";
        } 
        if(!isEmpty($task->getCategorie())) {
            $query .= ", categorie = '".$task->getCategorie()."'";
        } 
        if(!isEmpty($task->getContent())) {
            $query .= ", content = '".$task->getContent()."'";
        } 
        if(!isEmpty($task->getImages())) {
            $goodFormatImages = [];
            foreach ($task->images as $key => $image) {
                $target_file = TARGET_DIR . basename($image["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                move_uploaded_file($image["tmp_name"], $target_file);
                $tempObject = new stdClass();
                $tempObject->url = '/todoList/back/api'.str_replace('.', '', TARGET_DIR).$image['name'];
                $tempObject->name = str_replace('.'.$imageFileType, '', $image['name']);
                array_push($goodFormatImages, $tempObject);
            }
            $task->setImages($goodFormatImages);
            $query .= ", images = '".json_encode($task->getImages())."'";
        } 
        $query .= " WHERE id = ".$id;

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return $task;
    }

    public function delete($id) {
        global $dbh;
        
        $query = "DELETE FROM task WHERE id =".$id;   

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return 'La tâche a bien été supprimée';
    }
}