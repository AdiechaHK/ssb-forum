<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends CI_Controller {

  public function api($model = null) {

    $this->load->helper('file');

    $model = $model == null? $this->input->get('model'): $model;

    $path = '/var/www/html/ssb-forum/application/models/';
    $content = read_file($path . 'sample_model.txt');

    $data = array(
      'model_title' => $model,
      'table' => strtolower($model),
      'variables' => "var $" . implode(" = '';\n\tvar $", explode(",", $this->input->get('cols'))) .  " = '';"
    );
    $content = $this->parse($content, $data);

    $cond = write_file($path . $model . '_model.php', $content);
    echo ($cond ? "Written": "Some problem is there");

    // echo $model . " is to >> \n<br/>" . implode("<br/>", explode("\n", $content));
  }

  private function parse($content, $data) {
    foreach ($data as $key => $value) {
      $content = implode($value, explode("{{".$key."}}", $content));
    }
    return $content;
  }

}