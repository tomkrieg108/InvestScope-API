<?php

class Setup extends Controller {

  private $dbSetup;

  public function __construct() {
    $this->dbSetup = $this->model('DBSetup');
  }

  public function create() {
    $this->dbSetup->createTables();
  }

  public function delete() {
    $this->dbSetup->deleteData();
  }

  public function destroy() {
    $this->dbSetup->destroyTables();
  }

  public function import() {
    $this->dbSetup->importData();
  }

}