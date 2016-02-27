<?php

class Message_model extends CI_Model {

  var $sender = '';
	var $reciever = '';
	var $message = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }
  
  function get_entries($skip = 0, $condition = array()) {
    $query = $this->db->get_where('message', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($id) {
    $query = $this->db->get_where('message', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('message', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('message', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('message', array('id' => $id));
  }

}