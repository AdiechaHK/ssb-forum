<?php

class Course_model extends CI_Model {

  var $name = '';

  function __construct() {
    parent::__construct();
  }
  
  function get_all_entries($uid, $condition = array()) {
    $query = $this->db->get_where('course', $condition);
    return $query->result();
  }

  function get_entries($uid, $skip = 0, $condition = array()) {
    $query = $this->db->get_where('course', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($uid, $id) {
    $query = $this->db->get_where('course', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('course', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('course', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('course', array('id' => $id));
  }

}