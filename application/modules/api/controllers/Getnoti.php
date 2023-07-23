<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . 'libraries/REST_Controller.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

class Getnoti extends REST_Controller
{
    private $com_id;
    private $pd_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->pd_id = $this->session->userdata('pd_id');
    }

    public function index_get()
    {

        $status = parent::HTTP_OK;
        $CI = &get_instance();
        $CI->load->helper('language');
        $CI->lang->load('pages', ($CI->session->userdata('language') == 'th' ? 'thai' : 'english'));
        // ini_set('display_errors', 1);
        if ($this->pd_id) {
            $data_result = array(
                'mobile' =>  $this->agent->is_mobile() ? true : false,
                'register' => array(
                    'detail' => self::get_userregister(),
                ),


            );

            $this->response(['status' => $status, 'result' => $data_result]);
        } else {

            $this->response(['status' => $status, 'result' => array()]);
        }
    }
    private function get_userregister()
    {
        $result = $this->db->query(
            "SELECT
                create_at,
                CONCAT( firstname, ' ', lastname ) AS fullname 
            FROM
                db_sheep.personaldocument 
            WHERE
                TIMESTAMPDIFF(
                    MINUTE,
                create_at,
                NOW()) < 1
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->create_at = setDateToThai($val->create_at, true, 'full_month');
        }
        return $data;
    }
}
