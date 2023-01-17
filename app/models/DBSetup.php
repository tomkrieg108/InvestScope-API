<?php

require_once "../app/models/Registry.php";
require_once "../app/models/Sector.php";
require_once "../app/models/Stock.php";
require_once "../app/models/Transaction.php";

class DBSetup {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function createTables() {

    $result = false;

    // Create registries table
    $this->db->query('CREATE TABLE IF NOT EXISTS registries ( 
                      registryId INT(11) NOT NULL AUTO_INCREMENT, 
                      name VARCHAR(255),   
                      url VARCHAR(255),
                      PRIMARY KEY (registryId))'
                    );
    $result = $this->db->execute();                

    // Create Sectors table
    $this->db->query('CREATE TABLE IF NOT EXISTS sectors ( 
                      sectorId INT(11) NOT NULL AUTO_INCREMENT,   
                      name VARCHAR(255), 
                      description TEXT,
                      PRIMARY KEY (sectorId))'
                    );
    $result = $result &&  $this->db->execute();                 
    
    // Create Stocks table
    $this->db->query('CREATE TABLE IF NOT EXISTS stocks ( 
                      stockId INT(11) NOT NULL AUTO_INCREMENT, 
                      sectorId INT(11),
                      registryId INT(11),
                      stockCode VARCHAR(8), 
                      companyName VARCHAR(255), 
                      url VARCHAR(255),
                      bizRisk INT(11),
                      priceRisk INT(11),
                      maxWeight FLOAT,
                      buyBelow FLOAT,
                      sellAbove FLOAT,
                      PRIMARY KEY (stockId) )'
                    );   
    $result = $result &&  $this->db->execute();                    
           
    // Create transactions table
    $this->db->query('CREATE TABLE IF NOT EXISTS transactions ( 
                      transactionId INT(11) NOT NULL AUTO_INCREMENT, 
                      userId INT(11),
                      stockId INT(11),
                      numShares INT(11),
                      price FLOAT UNSIGNED, 
                      transType INT(11),
                      brokerage FLOAT UNSIGNED,
                      transDate DATE,
                      comment TEXT,
                      PRIMARY KEY (transactionId))'
                    );
    $result = $result &&  $this->db->execute();                                 

    // Create users table
    $this->db->query('CREATE TABLE IF NOT EXISTS users ( 
                      userId INT NOT NULL AUTO_INCREMENT, 
                      name VARCHAR(255) NOT NULL, 
                      password VARCHAR(255) NOT NULL, 
                      createdAt DATE DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (userId))'
                    );                
    $result = $result &&  $this->db->execute();    
    return $result;               
  }

  public function destroyTables() {
    $this->db->query('DROP TABLE registries');
    $this->db->execute();  
    $this->db->query('DROP TABLE sectors');
    $this->db->execute();  
    $this->db->query('DROP TABLE stocks');
    $this->db->execute();  
    $this->db->query('DROP TABLE transactions');
    $this->db->execute();  
    $this->db->query('DROP TABLE users');
    $this->db->execute();  
  }

  public function deleteData() {
    $this->db->query('DELETE FROM registries WHERE 1');
    $this->db->execute(); 
    $this->db->query('DELETE FROM sectors WHERE 1');
    $this->db->execute(); 
    $this->db->query('DELETE FROM stocks WHERE 1');
    $this->db->execute(); 
    $this->db->query('DELETE FROM transactions WHERE 1');
    $this->db->execute(); 
    $this->db->query('DELETE FROM users WHERE 1');
    $this->db->execute(); 
  }

  private function process_str($str) {
    return str_replace('$','',trim($str));
  }


  private function importRegistries() {
    $file = fopen("files/registries.csv", "r") or die("Unable to open registries file!");
    
    $registryModel = new Registry();
    while(!feof($file)){
      $data = fgets($file);
      $data_arr = explode(',',$data);
      $data_obj = (object)Array(
        'name' => $this->process_str($data_arr[0]),
        'url' => $this->process_str($data_arr[1]),
      );
      $registryModel->create($data_obj);
    }
  }

  private function importSectors() {
    $file = fopen("files/sectors.csv", "r") or die("Unable to open sectors file!");
    $sectorModel = new Sector();
    while(!feof($file)){
      $data = fgets($file);
      $data_arr = explode(',',$data);
      $data_obj = (object)Array(
        'name' => $this->process_str($data_arr[0]),
        'description' => $this->process_str($data_arr[1]),
      );
      $sectorModel->create($data_obj);
    }
  }

  // Can do this as a query
  private function getSectorId($sectorName, $sectors) {
    $sectorName = $this->process_str($sectorName);
    for($i =0; $i<count($sectors); $i++) {
      if($sectors[$i]->name == $sectorName) {
        return strval($sectors[$i]->sectorId);
      }
    }
    return '-1';
  }

  //  Can do as a query
  private function getRegistryId($registryName, $registry) {
    $registryName = $this->process_str($registryName);
    for($i =0; $i<count($registry); $i++) {
      if($registry[$i]->name == $registryName) {
        return strval($registry[$i]->registryId);
      }
    }
    return '-1';
 }

 private function getRiskAsInt($riskRating) {
  $riskRating = strtoupper($riskRating);
  switch($riskRating) {
      case 'L':   return 1;
      case 'ML':  return 2;
      case 'M' : return 3;
      case 'MH' : return 4;
      case 'H' : return 5;
      case 'VH' : return 6;
      default: return 0;
    }
 }

  private function importStocks() {
    $registryModel = new Registry();
    $sectorModel = new Sector();
    $stocksModel = new Stock();

    $registries = $registryModel->read();
    $sectors = $sectorModel->read();
   
    $file = fopen("files/stocks.csv", "r") or die("Unable to open stocks file!");
    while(!feof($file)) {
      $data = fgets($file);
      $data_arr = explode(',',$data);
      $data_obj = (object)Array(
        'sectorId' => $this->getSectorId($data_arr[7], $sectors),
        'registryId' => $this->getRegistryId($data_arr[8], $registries),
        'stockCode' => $this->process_str($data_arr[0]),
        'companyName' => $this->process_str($data_arr[6]),
        'url' => '',
        'bizRisk' => $this->getRiskAsInt($this->process_str($data_arr[4])),
        'priceRisk' => $this->getRiskAsInt($this->process_str($data_arr[5])),
        'maxWeight' => $this->process_str($data_arr[3]),
        'buyBelow' => $this->process_str($data_arr[1]),
        'sellAbove' => $this->process_str($data_arr[2]),
      );   
      $stocksModel->create($data_obj);
    }
    
  }

  private function importTransactions() {
    $stocksModel = new Stock();
    $transactionModel = new Transaction();
    // $stocks = $stocksModel->read();
    // $stock = $stocksModel->getStock("NCM");
    // var_dump($stock->stockId);
    $file = fopen("files/transactions.csv", "r") or die("Unable to open transactions file!");
    while(!feof($file)) {
      $data = fgets($file);
      $data_arr = explode(',',$data);

      $stockCode = $this->process_str($data_arr[1]);
      $stock = $stocksModel->getStock($stockCode);
      if(!$stock) {
        // var_dump($stock);
        $stocksModel->createEmpty($stockCode);
        $stock = $stocksModel->getStock($stockCode);
        // var_dump($stock);
        // break;
      }

      $data_obj = (object)Array(
        'userId' => 1,
        'stockId' =>  $stock->stockId,
        'numShares' => $this->process_str($data_arr[4]),
        'price' => $this->process_str($data_arr[3]),
        'transType' => strtoupper($this->process_str($data_arr[2])) == 'BUY' ? 0 : 1,
        'brokerage' => $this->process_str($data_arr[5]),
        'transDate' => date('y/m/d', strtotime($this->process_str($data_arr[0]))),  
        'comment' => 'No comments'
      );
      // var_dump($data_obj);
      // break;
      $transactionModel->create($data_obj);
    }

    // var_dump($stock);
  }

  private function importUsers() {

  }

  public function importData() {
    // $this->importRegistries();
    // $this->importSectors();
    // $this->importStocks();
    $this->importTransactions();
  }

}



