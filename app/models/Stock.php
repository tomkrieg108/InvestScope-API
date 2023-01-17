<?php

require_once "../app/models/Registry.php";
require_once "../app/models/Sector.php";

class Stock {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function create($data) {
    $this->db->query('INSERT INTO stocks (sectorId, registryId, stockCode, companyName, url, bizRisk, priceRisk, maxWeight, buyBelow, sellAbove) VALUES(:sectorId, :registryId, :stockCode, :companyName, :url, :bizRisk, :priceRisk, :maxWeight, :buyBelow, :sellAbove)' );

    $this->db->bind(':sectorId', htmlspecialchars(strip_tags($data->sectorId)));
    $this->db->bind(':registryId', htmlspecialchars(strip_tags($data->registryId)));
    $this->db->bind(':stockCode', htmlspecialchars(strip_tags($data->stockCode)));
    $this->db->bind(':companyName', htmlspecialchars(strip_tags($data->companyName)));
    $this->db->bind(':url', htmlspecialchars(strip_tags($data->url)));
    $this->db->bind(':bizRisk', htmlspecialchars(strip_tags($data->bizRisk)));
    $this->db->bind(':priceRisk', htmlspecialchars(strip_tags($data->priceRisk)));
    $this->db->bind(':maxWeight', htmlspecialchars(strip_tags($data->maxWeight)));
    $this->db->bind(':buyBelow', htmlspecialchars(strip_tags($data->buyBelow)));
    $this->db->bind(':sellAbove', htmlspecialchars(strip_tags($data->sellAbove)));
    
    return ($this->db->execute());
  }

  // sector id and registry id should be the values for 'unknown'
  public function createEmpty($stockCode) {
    $registry = new Registry();
    $sector = new Sector();

    // $reg = $registry->getRegistry('Unknown');
    // var_dump($reg);
    // return;

    $data = (object)array( 
      'sectorId' => $sector->getSector('Unknown')->sectorId,
      'registryId' => $registry->getRegistry('Unknown')->registryId,
      'stockCode' => $stockCode,
      'companyName' => 'Unknown',
      'url' => '',
      'bizRisk' => 0,
      'priceRisk' => 0,
      'maxWeight' => 0,
      'buyBelow' => 0,
      'sellAbove' => 0
    );

    $this->create($data);
  }

  public function update($data, $id) {
    $this->db->query('UPDATE stocks SET
                sectorId = :sectorId,
                registryId = :registryId,
                stockCode = :stockCode, 
                companyName = :companyName,
                url = :url,
                bizRisk = :bizRisk,
                priceRisk = :priceRisk,
                maxWeight = :maxWeight,
                buyBelow = :buyBelow,
                sellAbove = :sellAbove,
                WHERE stockId = :id
      ');

    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    $this->db->bind(':sectorId', htmlspecialchars(strip_tags($data->sectorId)));
    $this->db->bind(':registryId', htmlspecialchars(strip_tags($data->registryId)));
    $this->db->bind(':stockCode', htmlspecialchars(strip_tags($data->stockCode)));
    $this->db->bind(':companyName', htmlspecialchars(strip_tags($data->companyName)));
    $this->db->bind(':url', htmlspecialchars(strip_tags($data->url)));
    $this->db->bind(':bizRisk', htmlspecialchars(strip_tags($data->bizRisk)));
    $this->db->bind(':priceRisk', htmlspecialchars(strip_tags($data->priceRisk)));
    $this->db->bind(':maxWeight', htmlspecialchars(strip_tags($data->maxWeight)));
    $this->db->bind(':buyBelow', htmlspecialchars(strip_tags($data->buyBelow)));
    $this->db->bind(':sellAbove', htmlspecialchars(strip_tags($data->sellAbove)));

    return ($this->db->execute());
  }

  public function delete($id) {
    $this->db->query('DELETE FROM stocks WHERE stockId = :id'); 
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return ($this->db->execute());
  }

  public function read() {

    $this->db->query('SELECT 
                        stocks.stockId,
                        stocks.stockCode,
                        stocks.companyName,
                        stocks.url,
                        stocks.maxWeight,
                        stocks.buyBelow,
                        stocks.sellAbove,
                        stocks.bizRisk,
                        stocks.priceRisk,
                        sectors.name AS sectorName,
                        registries.name AS registry
                      FROM stocks
                      INNER JOIN sectors
                        ON stocks.sectorId = sectors.sectorId
                      INNER JOIN registries
                        ON stocks.registryId = registries.registryId
                      ORDER BY stocks.stockCode ASC   
                  ');

    return $this->db->resultSet();
    //Return type is an accociative array
  }

  public function read_single($id) {
    // $this->db->query('SELECT * from stocks WHERE id = :id');

    $this->db->query('SELECT 
                        stocks.stockId,
                        stocks.stockCode,
                        stocks.companyName,
                        stocks.url,
                        stocks.maxWeight,
                        stocks.buyBelow,
                        stocks.sellAbove,
                        stocks.bizRisk,
                        stocks.priceRisk,
                        sectors.name AS sectorName,
                        registries.name AS registry
                      FROM stocks
                      INNER JOIN sectors
                        ON stocks.sectorId = sectors.sectorId
                      INNER JOIN registries
                        ON stocks.registryId = registries.registryId
                      WHERE stocks.stockId = :id   
                  ');

    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return $this->db->single();
  }

  public function getStock($stockCode) {
    $this->db->query('SELECT * from stocks where stocks.stockCode = :stockCode' );
    $this->db->bind(':stockCode', htmlspecialchars(strip_tags($stockCode)));
    return $this->db->single();
  }
}
