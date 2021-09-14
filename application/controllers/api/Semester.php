<?php

require APPPATH . 'libraries/REST_Controller.php';
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
        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        try {
            $stdent_data = authorization::validateToken($token);
            if ($stdent_data === false) {
                $this->response(array(
                    "status" => 0,
                    "message" => "unotherized token ",
                        ), parent::HTTP_UNAUTHORIZED);
            } else {

                $stdent_id = $stdent_data->data->id;
                if (isset($data->title) && isset($data->level) && isset($data->complate_days) && isset($data->semester)) {
                    $project_arr_data = array(
                        "student_id" => $stdent_id,
                        "title" => $data->title,
                        "level" => $data->level,
                        "description" => $data->description,
                        "complate_days" => $data->complate_days,
                        "semester" => $data->semester
                    );


                    if ($this->Semester_model->create_project($project_arr_data)) {
                        $this->response(array(
                            "status" => 1,
                            "message" => " succefully insert in semester model",
                                ), parent::HTTP_OK);
                    } else {
                        $this->response(array(
                            "status" => 0,
                            "message" => "data not insert of database",
                                ), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array(
                        "status" => 0,
                        "message" => " all data needed",
                            ), parent::HTTP_NOT_FOUND);
                }
            }
        } catch (Exception $ex) {
            $this->response(array(
                "status" => 0,
                "message" => $ex->getMessage(),
                    ), parent::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function project_list_get() {
        $emester_list = $this->Semester_model->get_all_project();
        if (count($emester_list)) {
            $this->response(array(
                "status" => 1,
                "message" => "all project list",
                "data_list" => $emester_list
                    ), parent::HTTP_OK);
        } else {
            $this->response(array(
                "status" => 0,
                "message" => "No project list"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

}
?>

