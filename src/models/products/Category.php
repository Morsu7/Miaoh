<?php

class Category {
    public $id;
    public $description;

    public function __construct($id, $description) {
        $this->id = $id;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }
}