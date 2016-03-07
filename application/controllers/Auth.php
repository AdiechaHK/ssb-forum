<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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

  public function login() {

    $this->load->model('User_model', 'user');
    $user = $this->user->get_conditional_entry(array(
      'email' => $this->input->post('email')
    ));

    if($user == null) {
      $this->session->userdata('noti_msg', "User not found !");
      return redirect('/');
    } else {
      if($user->password == md5($this->input->post('password'))) {
        $this->session->set_userdata('auth_user', $user);
        return redirect('/dashboard');
      } else {
        $this->session->set_userdata('noti_msg', "Invalid password");
        return redirect('/');
      }
    }
  }

  public function register() {
    $this->load->model('User_model', 'user');
    $save = $this->user->insert_entry(array(
      "username" => $this->input->post('username'),
      "email" => $this->input->post('email'),
      "password" => md5($this->input->post('password')),
      "batch" => $this->input->post('batch')
    ));
    $this->session->set_userdata('noti_msg', "Registration done, proceed with login.");
    return redirect('/');
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('/');
  }
}
