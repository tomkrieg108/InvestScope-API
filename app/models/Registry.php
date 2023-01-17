<?php

class Registry {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function create($data) {
    $this->db->query('INSERT INTO registries (name, url) VALUES(:name, :url)' );
    $this->db->bind(':name', htmlspecialchars(strip_tags($data->name)));
    $this->db->bind(':url', htmlspecialchars(strip_tags($data->url)));
    return ($this->db->execute());
  }

  public function update($data, $id) {
    $this->db->query('UPDATE registries SET
                name = :name,
                url = :url,
                WHERE registryId = :id
              ');
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    $this->db->bind(':name', htmlspecialchars(strip_tags($data->name)));
    $this->db->bind(':url', htmlspecialchars(strip_tags($data->url)));
    return ($this->db->execute());
  }

  public function delete($id) {
    $this->db->query('DELETE FROM registries WHERE registryId = :id'); 
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return ($this->db->execute());
  }

  public function read() {
    $this->db->query('SELECT * FROM registries');
    return $this->db->resultSet();
  }

  public function read_single($id) {
    $this->db->query('SELECT * from registries WHERE registryId = :id');
    $this->db->bind(':id', intval(htmlspecialchars(strip_tags($id))));
    return $this->db->single();
  }

  public function getRegistry($registryName) {
    $this->db->query('SELECT * from registries WHERE name = :registryName' );
    $this->db->bind(':registryName', htmlspecialchars(strip_tags($registryName)));
    return $this->db->single();
  }
}