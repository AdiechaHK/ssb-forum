<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function index()
  {
    $this->load->model('Group_model', 'group');
    $user = $this->session->userdata('auth_user');
    if($user == null) {
      redirect("/auth/logout");
      exit;
    }
    $groups =  $this->group->get_all_entries($user->id, array(
      'batch' => $user->batch
    ));
    $data = array(
      'tab' => "group",
      'user' => $user,
      'groups' => $groups
    );
    Template::user($this, 'dashboard', $data);
  }

}
