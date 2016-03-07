<?php

class Counts_model extends CI_Model {

  var $uid = '';
	var $oid = '';
	var $count = '';
	var $type = '';
  
  function __construct() {
    parent::__construct();
  }

  public function update_count($user, $opponent, $type, $count) {
    $data = array(
      'uid' => $user,
      'oid' => $opponent,
      'type' => $type
    );
    if($this->get_entry($data) == null) {
      return $this->db->insert('counts', array_merge($data, array('count' => $count)));
    } else {
      return $this->db->update('counts', array('count' => $count), $data);
    }
  }


  public function get_entry($condition) {
    $query = $this->db->get_where('counts', $condition);
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }
  
}
