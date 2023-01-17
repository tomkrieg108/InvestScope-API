<?php

class Users extends Controller {

  private $usersModel;

  public function __construct() {
    echo 'hello from: ' . __FILE__ . '<br>' ;
    $usersModel = $this->model('User');
  }

  public function Create($id) {
    echo 'called Users->Create(' . $id . ')';
  }
  
 }