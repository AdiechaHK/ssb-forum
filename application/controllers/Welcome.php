<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see http://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    // $this->load->view('welcome_message');
    // $this->load->view('page/welcome');
    $user = $this->session->userdata('auth_user');
    if($user != null) {
      return redirect('/dashboard');
    }
    $this->load->model('Batch_model', 'batch');
    $batches = $this->batch->_get_all_entries();
    $data = array(
      'batches' => $batches,
      'noti_msg' => $this->session->userdata('noti_msg')
    );
    // echo json_encode($data); exit;
    $this->session->unset_userdata('noti_msg');

    Template::guest($this, 'welcome', $data);
  }
}
