<?php

class User
{
  protected $id;
  protected $username;
  protected $email;
  protected $password_hash;
  protected $name;
  protected $surname;
  protected $imageExtension;

  function __construct($id, $username, $email, $password_hash, $name, $surname, $imageExtension) {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password_hash = $password_hash;
    $this->name = $name;
    $this->surname = $surname;
    $this->imageExtension = $imageExtension;
  }

  // GET METHODS
  public function getId()
  {
    return $this->id;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getPassword()
  {
    return $this->password_hash;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getSurname()
  {
    return $this->surname;
  }

  public function getImageExtension(){
    return $this->imageExtension;
  }
}