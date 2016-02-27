<?php

class Group_model extends CI_Model {

  var $title = '';
	var $description = '';
	var $batch = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }
  
  function get_entries($skip = 0, $condition = array()) {
    $query = $this->db->get_where('group', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($id) {
    $query = $this->db->get_where('group', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('group', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('group', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('group', array('id' => $id));
  }

}