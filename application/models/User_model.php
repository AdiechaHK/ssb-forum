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
  
  function get_all_entries($uid, $condition = array()) {
    $query = $this->db
      ->select('`member`.*,
          IF (`msgs`.`total_count` IS NULL, 0, `msgs`.`total_count`) AS total_count,
          IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(
          SELECT
            COUNT(`id`) AS total_count,
            IF (`message`.`sender` = '. $uid . ', `message`.`reciever`, `message`.`sender`) AS opid
          FROM  `message`
          WHERE sender = '.$uid.' OR reciever = '. $uid. '
          GROUP BY  opid) AS msgs',
          '`member`.`id` =  `msgs`.`opid` ', 'left')
      ->join('(
          SELECT
            `count` AS read_count,
            `oid` AS oid
          FROM  `counts` WHERE  `uid` =  '.$uid.') AS cntr',
          '`cntr`.`oid` =  `member`.`id` ', 'left')
      ->where('id <>', $uid)
      ->get_where('user AS member', $condition);
    return $query->result();
  }

  function get_entries($uid, $skip = 0, $condition = array()) {
    $query = $this->db
      ->select('`member`.*,
          IF (`msgs`.`total_count` IS NULL, 0, `msgs`.`total_count`) AS total_count,
          IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(
          SELECT
            COUNT(`id`) AS total_count,
            IF (`message`.`sender` = '. $uid . ', `message`.`reciever`, `message`.`sender`) AS opid
          FROM  `message`
          WHERE sender = '.$uid.' OR reciever = '. $uid. '
          GROUP BY  opid) AS msgs',
          '`member`.`id` =  `msgs`.`opid` ', 'left')
      ->join('(
          SELECT
            `count` AS read_count,
            `oid` AS oid
          FROM  `counts` WHERE  `uid` =  '.$uid.') AS cntr',
          '`cntr`.`oid` =  `member`.`id` ', 'left')
      ->where('id <>', $uid)
      ->get_where('user AS member', $condition, PAGE_SIZE, $skip);
    return $query->result();

  }

  function get_conditional_entry($condition = array()) {
    $query = $this->db->get_where('user', $condition, 1, 0);
    foreach ($query->result() as $record) {
      return $record;
    };
    return null;
  }

  function get_entry($uid, $id) {
    $query = $this->db
      ->select('`member`.*,
          IF (`msgs`.`total_count` IS NULL, 0, `msgs`.`total_count`) AS total_count,
          IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(
          SELECT
            COUNT(`id`) AS total_count,
            IF (`message`.`sender` = '. $uid . ', `message`.`reciever`, `message`.`sender`) AS opid
          FROM  `message`
          WHERE sender = '.$uid.' OR reciever = '. $uid. '
          GROUP BY  opid) AS msgs',
          '`member`.`id` =  `msgs`.`opid` ', 'left')
      ->join('(
          SELECT
            `count` AS read_count,
            `oid` AS oid
          FROM  `counts` WHERE  `uid` =  '.$uid.') AS cntr',
          '`cntr`.`oid` =  `member`.`id` ', 'left')
      ->get_where('user AS member', array('id' => $id));
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
