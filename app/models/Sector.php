<?php

class Sector {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function create($data) {
    $this->db->query('INSERT INTO sectors (name, description) VALUES(:name, :description)' );
    $this->db->bind(':name', htmlspecialchars(strip_tags($data->name)));
    $this->db->bind(':description', htmlspecialchars(strip_tags($data->description)));
    return ($this->db->execute());
  }

  public function update($data, $id) {
    $this->db->query('UPDATE sectors SET
                name = :name,
                description = :description,
                WHERE sectorId = :id
      ');
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    $this->db->bind(':name', htmlspecialchars(strip_tags($data->name)));
    $this->db->bind(':description', htmlspecialchars(strip_tags($data->description)));
    return ($this->db->execute());
  }

  public function delete($id) {
    $this->db->query('DELETE FROM sectors WHERE sectorId = :id'); 
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return ($this->db->execute());
  }

  public function read() {
    $this->db->query('SELECT * FROM sectors');
    return $this->db->resultSet();
  }

  public function read_single($id) {
    $this->db->query('SELECT * from sectors WHERE sectorId = :id');
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return $this->db->single();
  }

  public function getSector($sectorName) {
    $this->db->query('SELECT * from sectors where name = :sectorName' );
    $this->db->bind(':sectorName', htmlspecialchars(strip_tags($sectorName)));
    return $this->db->single();
  }
}