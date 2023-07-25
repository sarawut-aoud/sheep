<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Sheep_type_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function get_type_sheep()
    {
        $result = $this->db->get_where('db_sheep.sheep_type')->result();
        return $result;
    }
}
