<?php

class User {

  private $db;

  public function __construct() {
    $db = new Database();
  }

}