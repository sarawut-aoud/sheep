<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Profile_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
    }
    public function get_userdata()
    {
        $result = $this->db->query("SELECT * FROM db_sheep.personaldocument WHERE pd_id = ?", [$this->pd_id])->result_array();
        return $result;
    }
}
