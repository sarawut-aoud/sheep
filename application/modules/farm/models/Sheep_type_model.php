<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Sheep_type_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function get_type_sheep($post)
    {
        $where = ['is_show' => 1];
        if ($post->data) {
            $where = [];
        }
        $result = $this->db->order_by('id','asc')->get_where('db_sheep.sheep_type', $where)->result();
        return $result;
    }
}
