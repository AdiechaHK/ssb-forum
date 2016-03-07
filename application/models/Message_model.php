<?php

class Message_model extends CI_Model {

  var $sender = '';
	var $reciever = '';
	var $message = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }

  function get_all_entries($uid, $condition = array()) {
    $query = $this->db->get_where('message', $condition);
    return $query->result();
  }
  
  function get_entries($uid, $skip = 0, $condition = array()) {
    $query = $this->db->get_where('message', $condition, 10, $skip);
    return $query->result();
  }

  function get_entry($uid, $id) {
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

  function conversation($user, $friend, $skip = null) {
    $condition = "(sender = '$user' AND reciever = '$friend') OR (sender = '$friend' AND reciever = '$user')";
    $this->db
      ->select('`message`.*, `user`.`username` AS sender')
      ->join('`user` AS user', '`user`.`id` = `message`.`sender`', 'left')
      ->where($condition)
      ->order_by("create_at", "asc"); 
    if($skip == null) {
      $query = $this->db->get('message');
      return $query->result();
    } else {
      $query = $this->db->get('message', 10, $skip);
      return $query->result();
    }
  }

}