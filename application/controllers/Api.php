<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

  public function get_list ($model, $skip = 0) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->get_entries($skip, $this->input->get()));
  }

  public function get_all ($model) {

    $this->load->model($model . "_model", $model);

    echo json_encode($this->$model->get_all_entries($this->input->get()));
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

    $input = json_decode(file_get_contents('php://input'));

    $res = array('status' => "fail");
    $this->load->model('User_model', 'user');
    $list = $this->user->get_entries(0, array(
      'email' => $input->email
    ));
    switch (sizeof($list)) {
      case 0:
        $res['message'] = "User not found";
        break;
      case 1:
        $user = $list[0];
        if($user->password == md5($input->password)) {
          $res['user'] = json_encode($user);
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

    $input = json_decode(file_get_contents('php://input'));

    $this->load->model('User_model', 'user');
    $save = $this->user->insert_entry(array(
      "username" => $input->username,
      "email" => $input->email,
      "password" => md5($input->password),
      "batch" => $input->batch
    ));

    echo json_encode(array('status' => $save));
    exit;
  }

  public function messages ($user, $friend) {
    $this->load->model('Message_model', 'message');
    echo json_encode($this->message->conversation($user, $friend));
  }

}