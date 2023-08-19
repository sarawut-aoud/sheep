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
                    SUM(t1.pricetotal) as pricetotal,
                    t1.id as s_id
            FROM db_sheep.sheep_sale t1
            WHERE 
            t1.id IS NOT NULL
            $where 
            GROUP BY rowscoulumn
            "
        )->result();

        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->rowdata = self::get_typesheep($val);
        }
        return $data;
    }
    private function get_typesheep($post)
    {
        $result = $this->db->query(
            "SELECT 
            t1.typename,
            t1.id
            FROM db_sheep.sheep_type t1
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $row = $this->db->query(
                "SELECT pricetotal ,amount ,price , weight FROM db_sheep.sheep_sale WHERE sheep_type = $val->id AND rowscoulumn = $post->rowscoulumn"
            )->row();
            $data[$key]->totlal =  $row->pricetotal > 0 ? $row->pricetotal  : 0;
            $data[$key]->amount = $row->amount > 0 ? $row->amount  : 0;
            $data[$key]->price = $row->price > 0 ? $row->price  : 0;
            $data[$key]->weight = $row->weight > 0 ? $row->weight  : 0;
        }
        return $data;
    }
    public function get_countsheep($post)
    {
        $post = (object) $post->data;

        $where = '';
        if ($post->date_start || $post->date_end) {
            $start = date('Y-m-d', strtotime($post->date_start));
            $end = date('Y-m-d', strtotime($post->date_end));
            $where .= " AND DATE(create_at) BETWEEN '{$start}' AND '{$end}'";
        }

        $result = $this->db->query(
            "SELECT
            t1.id,
            t1.typename 
            FROM
                db_sheep.sheep_type t1
            WHERE
             t1.is_show = 1
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $count = $this->db->query(
                "SELECT * FROM db_sheep.sheep_keep WHERE pd_id = {$this->pd_id} AND sheep_type = {$val->id} $where"
            )->result();
            $data[$key]->count = count($count);
        }

        return $data;
    }
    public function get_countsheep_gender($post)
    {
        $post = (object) $post->data;

        $where = '';
        if ($post->date_start || $post->date_end) {
            $start = date('Y-m-d', strtotime($post->date_start));
            $end = date('Y-m-d', strtotime($post->date_end));
            $where .= " AND DATE(create_at) BETWEEN '{$start}' AND '{$end}'";
        }
        $result = $this->db->query(
            "SELECT
               IF( SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END)>0,SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END),0) AS Males,
               IF( SUM(CASE WHEN gender = 2  THEN 1 ELSE 0 END)>0,SUM(CASE WHEN gender = 2  THEN 1 ELSE 0 END),0)  AS Females
            FROM
                db_sheep.sheep_keep 
            WHERE
                pd_id = {$this->pd_id}
                $where
            "
        )->row();

        return $result;
    }
    private function get_rangeMonth($post)
    {
        $start    = (new DateTime(date('Y-m-d', strtotime($post->date_start))))->modify('first day of this month');
        $end      = (new DateTime(date('Y-m-d', strtotime($post->date_end))))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $data = [];
        foreach ($period as $dt) {
            $data[] = $dt->format("Y-m-d");
        }
        return $data;
    }
    public function get_sumtotalprice($post)
    {
        $post = (object) $post->data;
        $month = self::get_rangeMonth($post);
        $data = [];
        foreach ($month as $key => $val) {
            $result = $this->db->query(
                "SELECT
                    SUM( pricetotal ) AS totalprice 
                FROM
                    db_sheep.sheep_sale 
                WHERE pd_id = {$this->pd_id} AND MONTH(saledate) = MONTH('{$val}') AND YEAR(saledate) = YEAR('{$val}')
                "
            )->row('totalprice');

            $data[$key]->month = DateThai($val, 'M', TRUE) . ' ' . DateThai($val, 'Y', NULL);
            $data[$key]->sum = $result > 0 ? $result : 0;
        }


        return $data;
    }
    public function get_sumprice($post)
    {
        $post = (object) $post->data;
        $month = self::get_rangeMonth($post);
        $data = [];

        foreach ($month as $key => $val) {
            $data[$key]->x = DateThai($val, 'M', TRUE) . ' ' . DateThai($val, 'Y', NULL);
            $data[$key]->sheep1 =  self::get_sheep_count($val, 1);
            $data[$key]->sheep2 =  self::get_sheep_count($val, 2);
            $data[$key]->sheep3 =  self::get_sheep_count($val, 3);
            $data[$key]->sheep4 =  self::get_sheep_count($val, 4);
            $data[$key]->sheep5 =  self::get_sheep_count($val, 5);
        }
        return $data;
    }
    private function get_sheep_count($post, $type)
    {
        $result = $this->db->query(
            "SELECT   SUM( pricetotal ) AS totalprice  
             FROM
                db_sheep.sheep_sale 
            WHERE pd_id = {$this->pd_id} 
            AND sheep_type= {$type}
            AND MONTH(saledate) = MONTH('{$post}') 
            AND YEAR(saledate) = YEAR('{$post}')
            "
        )->row('totalprice');
        return $result > 0 ? $result : 0;
    }
}
