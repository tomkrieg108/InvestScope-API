<?php

class Transactions extends Controller {

  private $transactionsModel;

  public function __construct() {
    //echo 'hello from: ' . __FILE__ . '<br>' ;
    $this->transactionsModel = $this->model('Transaction');
  }

  public function create() {

    //headers
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    if($this->transactionsModel->create($data)) {
      echo json_encode(
        array(
          'message' => 'Transaction created',
          'idCreated' => $this->transactionsModel->lastInsertId()
        )
      );
    }else {
      echo json_encode(
        array('
          message' => 'Transaction not created',
          'idCreated' => -1
        ),
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

    if($this->transactionsModel->update($data, $id)) {
      echo json_encode(
        array(
          'message' => 'Transaction updated',
          'idUpdated' => $id
        )
      );
    }else {
      echo json_encode(
        array(
          'message' => 'Transaction not updated',
          'idUpdated' => -1
        )
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

    if($this->transactionsModel->delete($id)) {
      echo json_encode(
        array('message' => 'Transaction deleted')
      );
    }else {
      echo json_encode(
        array('message' => 'Transaction not deleted')
      );
    }
  }

  public function read() {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->transactionsModel->read();
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }

  public function read_single($id) {
    header('Access-Control-Allow-Origin: *'); //public api
    header('Content-Type: application/json');
    $data = $this->transactionsModel->read_single($id);
    //Convert from associative array to JSON before send
    echo json_encode($data); 
  }
 }