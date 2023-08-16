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
        $result = $this->db->query(
            "SELECT t1.saledate,
                    t1.rowscoulumn,
                    SUM(t1.pricetotal) as pricetotal
            FROM db_sheep.sheep_sale t1
            WHERE 
            $where 
            GROUP BY rowscoulumn
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->rowdata = $this->db->query(
                "SELECT *
                FROM db_sheep.sheep_sale t1
                LEFT JOIN db_sheep.sheep_type t2 ON t2.id = t1.sheep_type
                WHERE 
                pd_id = {$this->pd_id} AND
                rowscoulumn = '{$val->rowscoulumn}'
                "
            )->result();
        }
        return $data;
    }
}
