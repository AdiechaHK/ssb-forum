<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

  public function get_list ($model, $skip = 0) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->get_entries($skip, $this->input->get()));
  }

  public function get ($model, $id) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->get_entry($id));

  }

  public function create ($model) {
    
    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->insert_entry($this->input->get()));

  }

  public function update ($model, $id) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->update_entry(array('id' => $id), $this->input->get()));

  }

  public function remove ($model, $id) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->remove_entry(array('id' => $id)));

  }

  public function login () {

    echo json_encode($this->input->post());
    exit;


    $res = array('status' => "fail");
    $this->load->model('User_model', 'user');
    $list = $this->user->get_entries(0, array(
      'email' => $this->input->post('email')
    ));
    switch (sizeof($list)) {
      case 0:
        $res['message'] = "User not found";
        break;
      case 1:
        $user = $list[0];
        if($user->password == md5($this->input->post('password'))) {
          $res['status'] = "success";
        } else {
          $res['message'] = "Invalid password";
        }
        break;
      default:
        $res['message'] = "Multiple users are found for the same email id, please contact technical person.";
        break;
    }
    echo json_encode($res);
    exit;
  }

  public function register () {

    $this->load->model('User_model', 'user');
    $save = $this->user->insert_entry(array(
      "username" => $this->input->post('username'),
      "email" => $this->input->post('email'),
      "password" => md5($this->input->post('password')),
      "batch" => $this->input->post('batch')
    ));

    echo json_encode(array('status' => $save));
    exit;
  }

}