<?php

class Group_post_model extends CI_Model {

  var $uid = '';
	var $gid = '';
	var $text = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }
  
  function get_all_entries($uid, $condition = array()) {
    $query = $this->db->get_where('group_post', $condition);
    return $query->result();
  }

  function get_entries($uid, $skip = 0, $condition = array()) {
    $query = $this->db
      ->select('`gp`.*, `u`.`username`')
      ->join('`user` AS u', '`u`.`id` = `gp`.`uid`')
      ->get_where('group_post AS gp', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($uid, $id) {
    $query = $this->db->get_where('group_post', array('id' => $id));
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function insert_entry($data) {
    return $this->db->insert('group_post', $data);
  }

  function update_entry($condition, $data) {
    return $this->db->update('group_post', $data, $condition);
  }

  function remove_entry($id) {
    return $this->db->delete('group_post', array('id' => $id));
  }

}