<?php
abstract class User
{
  protected $name;
  public function __construct($name=null)
  {
    $this->name =$name;
  }
  public function getName()
  {
    return $this->name;
  }

  public function setName(string $name)
  {
    $this->name = $name;
    return $this;
  }
  abstract public function login($user, $pass);
  abstract public function logout();
}
