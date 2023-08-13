<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Report_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->loginby = $this->session->userdata('loginby');
        $this->status = false;
    }
    public function get_data($post)
    {
        $post = (object) $post->data;

        $where = '';
        if ($post->date_start || $post->date_end) {
            $start = date('Y-m-d', strtotime($post->date_start));
            $end = date('Y-m-d', strtotime($post->date_end));
            $where .= " AND DATE(t1.saledate) BETWEEN '{$start}' AND '{$end}'";
        }
        if ($this->loginby == 'member') {
            $where .= "AND t1.pd_id = {$this->pd_id}";
        }
    }
}
