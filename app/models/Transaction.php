<?php

class Transaction {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function lastInsertId() {
    return $this->db->lastInsertId();
  }

  public function create($data) {

    // $data needs to be a php obj
    // var_dump($data);

    //when accessed via javascript fetch call, a second
    //spirious record is created with all fields 0
    //this hack stops it!
    if($data->numShares == 0) {
      exit();
    }

    $this->db->query('INSERT INTO transactions (userId, stockId, numShares, price, transType, brokerage, comment, transDate) VALUES(:userId, :stockId, :numShares, :price, :transType, :brokerage, :comment, :transDate)' );

    $this->db->bind(':userId', htmlspecialchars(strip_tags($data->userId)));
    $this->db->bind(':stockId', htmlspecialchars(strip_tags($data->stockId)));
    $this->db->bind(':numShares', htmlspecialchars(strip_tags($data->numShares)));
    $this->db->bind(':price', htmlspecialchars(strip_tags($data->price)));
    $this->db->bind(':transType', htmlspecialchars(strip_tags($data->transType)));
    $this->db->bind(':brokerage', htmlspecialchars(strip_tags($data->brokerage)));
    $this->db->bind(':comment', htmlspecialchars(strip_tags($data->comment)));
    $this->db->bind(':transDate', htmlspecialchars(strip_tags($data->transDate)));

    return ($this->db->execute());
  }

  public function update($data, $id) {
    
    $this->db->query('UPDATE transactions SET
                userId = :userId,
                stockId = :stockId, 
                numShares = :numShares,
                price = :price,
                transType = :transType,
                brokerage = :brokerage,
                comment = :comment,
                transDate = :transDate
                WHERE transactionId = :id
      ');

    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    $this->db->bind(':userId', htmlspecialchars(strip_tags($data->userId)));
    $this->db->bind(':stockId', htmlspecialchars(strip_tags($data->stockId)));
    $this->db->bind(':numShares', htmlspecialchars(strip_tags($data->numShares)));
    $this->db->bind(':price', htmlspecialchars(strip_tags($data->price)));
    $this->db->bind(':transType', htmlspecialchars(strip_tags($data->transType)));
    $this->db->bind(':brokerage', htmlspecialchars(strip_tags($data->brokerage)));
    $this->db->bind(':comment', htmlspecialchars(strip_tags($data->comment)));
    $this->db->bind(':transDate', htmlspecialchars(strip_tags($data->transDate)));

    return ($this->db->execute());
  }

  public function delete($id) {
    $this->db->query('DELETE FROM transactions WHERE transactionId = :id'); 
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return ($this->db->execute());
  }

  public function read() {
  
    // $this->db->query('SELECT * from transactions ORDER BY transactions.created_at DESC');

    $this->db->query('SELECT 
                        transactions.transactionId,
                        transactions.transDate,
                        stocks.stockCode AS stockCode,
                        stocks.stockId AS stockId,
                        stocks.companyName AS companyName,
                        sectors.name AS sectorName,
                        transactions.transType,
                        transactions.numShares,
                        transactions.price,
                        transactions.brokerage,
                        transactions.comment
                      FROM transactions
                      INNER JOIN stocks
                        ON transactions.stockId = stocks.stockId
                      INNER JOIN sectors
                        ON stocks.sectorId = sectors.sectorId  
                      ORDER BY transactions.transDate DESC   
                  ');

    return $this->db->resultSet();
    //Return type is an accociative array
  }

  public function read_single($id) {
    
    $this->db->query('SELECT 
                        transactions.transactionId,
                        transactions.transDate,
                        stocks.stockCode AS stockCode,
                        transactions.transType,
                        transactions.numShares,
                        transactions.price,
                        transactions.brokerage,
                        transactions.comment
                      FROM transactions
                      INNER JOIN stocks
                        ON transactions.stockId = stocks.stockId
                      WHERE transactions.transactionId = :id
                  ');

    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return $this->db->single();
  }

}

/*
https://dev.to/dudeastronaut/import-a-csv-file-into-a-mysql-database-using-php-pdo-jn1

https://www.theserverside.com/blog/Coffee-Talk-Java-News-Stories-and-Opinions/Ajax-JavaScript-file-upload-example

https://javascript.info/formdata

https://www.javascripttutorial.net/web-apis/javascript-formdata/

https://www.codexworld.com/ajax-file-upload-with-form-data-jquery-php-mysql/

https://usefulangle.com/post/67/pure-javascript-ajax-file-upload-showing-progess-percent
*/