<?php

class User_model extends CI_Model {

  var $username = '';
	var $email = '';
	var $password = '';
	var $batch = '';
	var $created_at = '';
  
  function __construct() {
    parent::__construct();
  }
  
  function get_all_entries($condition = array()) {
    $query = $this->db->get_where('user', $condition);
    return $query->result();
  }

  function get_entries($skip = 0, $condition = array()) {
    $query = $this->db->get_where('user', $condition, 3, $skip);
    return $query->result();
  }

  function get_entry($id) {
    $query = $this->db->get_where('user', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('user', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('user', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('user', array('id' => $id));
  }

}
