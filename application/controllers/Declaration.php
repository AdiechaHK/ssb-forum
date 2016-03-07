<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Declaration extends CI_Controller {

  public function index()
  {
    $user = $this->session->userdata('auth_user');
    $data = array('tab' => "declaration", 'user' => $user);
    if($user == null) {
      $data['back'] = "/";
      Template::guest($this, 'declaration', $data);
    }
    else {
      $data['back'] = "/dashboard";
      Template::user($this, 'declaration', $data);
    }
  }

}
