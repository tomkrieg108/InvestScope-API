<?php

class Stocks extends Controller {

  private $stocksModel;

  public function __construct() {
    //echo 'hello from: ' . __FILE__ . '<br>' ;
    $this->stocksModel = $this->model('Stock');
  }

  public function create() {

    //headers
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    if($this->stocksModel->create($data)) {
      echo json_encode(
        array('message' => 'Stock created')
      );
    }else {
      echo json_encode(
        array('message' => 'Stock not created')
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

    if($this->stocksModel->update($data, $id)) {
      echo json_encode(
        array('message' => 'Stock updated')
      );
    }else {
      echo json_encode(
        array('message' => 'Stock not updated')
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

    if($this->stocksModel->delete($id)) {
      echo json_encode(
        array('message' => 'Stock deleted')
      );
    }else {
      echo json_encode(
        array('message' => 'Stock not deleted')
      );
    }
  }

  public function read() {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->stocksModel->read();
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }

  public function read_single($id) {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->stocksModel->read_single($id);
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }
 }