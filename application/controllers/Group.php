<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {


  public function show($id) {
    // $this->load->view('welcome_message');
    // $this->load->view('page/welcome');
    $this->load->model('Group_model', 'group');
    $this->load->model('Group_post_model', 'group_post');
    $user = $this->session->userdata('auth_user');
    $group = $this->group->get_entry($user->id, $id);
    $groupPostList = $this->group_post->get_entries($user->id, 0, array('gid' => $id));


    $this->load->model('Counts_model', 'counts');
    $this->counts->update_count($user->id, $group->id, 'G', $group->total_count);
    // echo json_encode($group);
    // echo json_encode($user);
    // exit;

    $data = array(
      'tab' => 'group',
      'user' => $user,
      'group' => $group,
      'groupPostList' => $groupPostList
    );
    Template::user($this, 'group', $data);
  }

  public function post() {
    $user = $this->session->userdata('auth_user');
    $gid = $this->input->post('gid');
    $data = array(
      'uid' => $user->id,
      'gid' => $gid,
      'text' => $this->input->post('text'),
    );
    $this->load->model('Group_post_model', 'group_post');
    $this->group_post->insert_entry($data);
    redirect('/group/show/'.$gid);
  }
}
