<?php

class Group_model extends CI_Model {

  var $title = '';
	var $description = '';
	var $batch = '';
	var $created_at = '';

  function __construct() {
    parent::__construct();
  }

  function get_all_entries($uid, $condition = array()) {
    $query = $this->db
      ->select('`grp`.*,
        IF (`grp_posts`.`total_count` IS NULL, 0, `grp_posts`.`total_count`) AS total_count,
        IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(SELECT COUNT(  `id` ) AS total_count,  `gid` FROM  `group_post` GROUP BY  `gid`) AS grp_posts', '`grp`.`id` =  `grp_posts`.`gid` ', 'left')
      ->join('(SELECT  `count` AS read_count,  `oid` AS gid FROM  `counts` WHERE  `uid` =  '.$uid.') AS cntr', '`cntr`.`gid` =  `grp`.`id` ', 'left')
      ->get_where('group AS grp', $condition);
    return $query->result();
  }
  
  function get_entries($uid, $skip = 0, $condition = array()) {
    $query = $this->db
      ->select('`grp`.*,
        IF (`grp_posts`.`total_count` IS NULL, 0, `grp_posts`.`total_count`) AS total_count,
        IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(SELECT COUNT(  `id` ) AS total_count,  `gid` FROM  `group_post` GROUP BY  `gid`) AS grp_posts', '`grp`.`id` =  `grp_posts`.`gid` ', 'left')
      ->join('(SELECT  `count` AS read_count,  `oid` AS gid FROM  `counts` WHERE  `uid` =  ' . $uid . ') AS cntr', '`cntr`.`gid` =  `grp`.`id` ', 'left')
      ->get_where('group AS grp', $condition, 10, $skip);


/*
SELECT  `g` . * ,  `posts`.`c` ,  `cnt`.`rc` 
FROM  `group` AS g
LEFT JOIN (

SELECT COUNT(  `id` ) AS c,  `gid` 
FROM  `group_post` 
GROUP BY  `gid`
) AS posts ON  `g`.`id` =  `posts`.`gid` 
LEFT JOIN (

SELECT  `count` AS rc,  `oid` AS gid
FROM  `counts` 
WHERE  `uid` =  '1'
) AS cnt ON  `cnt`.`gid` =  `g`.`id` 
LIMIT 0 , 30

*/

    return $query->result();
  }

  function get_entry($uid, $id) {
    $query = $this->db
      ->select('`grp`.*,
        IF (`grp_posts`.`total_count` IS NULL, 0, `grp_posts`.`total_count`) AS total_count,
        IF (`cntr`.`read_count` IS NULL, 0, `cntr`.`read_count`) AS read_count')
      ->join('(SELECT COUNT(  `id` ) AS total_count,  `gid` FROM  `group_post` GROUP BY  `gid`) AS grp_posts', '`grp`.`id` =  `grp_posts`.`gid` ', 'left')
      ->join('(SELECT  `count` AS read_count,  `oid` AS gid FROM  `counts` WHERE  `uid` =  ' . $uid . ') AS cntr', '`cntr`.`gid` =  `grp`.`id` ', 'left')
      ->get_where('group AS grp', array('id' => $id));
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