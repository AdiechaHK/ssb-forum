<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

  public function index() {
    redirect('/members/mlist');
  }

  public function mlist($skip = 0) {

    if($skip < 0) {
      redirect('/members/mlist/0');
    }

    $user = $this->session->userdata('auth_user');
    $this->load->model('User_model', 'user');
    $list = $this->user->get_entries($user->id, $skip, array(
      'batch' => $user->batch
    ));
    if(sizeof($list) == 0) {
      $all_list = $this->user->get_all_entries($user->id, $skip, array(
        'batch' => $user->batch
      ));
      if(sizeof($list) != 0)  {
        redirect('/members/mlist/' . ($skip - PAGE_SIZE));
      }
    }

    // echo json_encode($list); exit;

    $data = array(
      'user' => $user,
      'tab' => 'member',
      'memberList' => $list,
      'curr_skip' => $skip
    );
    Template::user($this, 'members', $data);
  }

  public function message($fid, $skip = 0) {
    $user = $this->session->userdata('auth_user');
    $this->load->model('Message_model', 'message');
    $this->load->model('User_model', 'user');
    $this->load->model('Counts_model', 'counts');
    $list = $this->message->conversation($user->id, $fid);
    $friend = $this->user->get_entry($user->id, $fid);
    $this->counts->update_count($user->id, $fid, 'C', $friend->total_count);

    // echo json_encode($list); exit;

    $data = array(
      'user' => $user,
      'tab' => 'member',
      'friend' => $friend,
      'messageList' => $list,
      'curr_skip' => $skip
    );
    Template::user($this, 'message', $data);

  }

  public function post_message() {
    $user = $this->session->userdata('auth_user');

    $this->load->model('Message_model', 'message');
    $data = array_merge($this->input->post(), array('sender' => $user->id));
    $this->message->insert_entry($data);

    redirect('/members/message/' . $this->input->post('reciever'));
  }

}
