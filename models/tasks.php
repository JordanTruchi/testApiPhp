<?php 

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
        $this->date = date('d-m-y', strtotime($date));
        $this->categorie = $categorie;
        $this->content = $content;
        $this->images = json_decode($images);
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
        return $this->date = date('d-m-y', strtotime($date));
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
        return $this->images = json_decode($images);
    }
}