<?php

class Sectors extends Controller {

  private $sectorsModel;

  public function __construct() {
    $this->sectorsModel = $this->model('Sector');
  }

  public function create() {

    //headers
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    if($this->sectorsModel->create($data)) {
      echo json_encode(
        array('message' => 'Registry created')
      );
    }else {
      echo json_encode(
        array('message' => 'Registry not created')
      );
    }
  }

  public function update($id) {
    //headers
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    if($this->sectorsModel->update($data, $id)) {
      echo json_encode(
        array('message' => 'Registry updated')
      );
    }else {
      echo json_encode(
        array('message' => 'Registry not updated')
      );
    }
  }

  public function delete($id) {
    //headers
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    if($this->sectorsModel->delete($id)) {
      echo json_encode(
        array('message' => 'Registry deleted')
      );
    }else {
      echo json_encode(
        array('message' => 'Registry not deleted')
      );
    }
  }

  public function read() {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->sectorsModel->read();
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }

  public function read_single($id) {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->sectorsModel->read_single($id);
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }
 }