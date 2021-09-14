<?php

require APPPATH . "libraries/REST_Controller";
//header

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET");

class Semester extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("api/Semester_model");
        $this->load->helper(array("authorization", "jwt"));
    }

    public function create_project_post() {
        $data = json_decode(file_get_contents("php://input"));
    }

    public function project_list_get() {
        
    }

}
?>

