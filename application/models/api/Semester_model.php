<?php

class Semester_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_project($data) {
        return $this->db->insert("tbl_semester_project", $data);
    }

    public function get_all_project() {
        $this->db->select("*");
        $this->db->from("tbl_semester_project");
        $query = $this->db->get();
        return $query->result();
    }

}
?>

