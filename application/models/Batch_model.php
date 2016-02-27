<?php

class Batch_model extends CI_Model {

  var $name = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }
  
  function get_entries($skip = 0, $condition = array()) {
    $query = $this->db->get_where('batch', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($id) {
    $query = $this->db->get_where('batch', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('batch', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('batch', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('batch', array('id' => $id));
  }

}