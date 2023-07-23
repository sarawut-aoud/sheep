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
                // 'approve_locationSwitch' => array(
                // 	'id' => '0',
                // 'num' => $this->Attendance->count_locationSwitch(), 
                // 'detail' => lang('nav_approveLocationSwitch')
                // ),


            );

            $this->response(['status' => $status, 'result' => $data_result]);
        } else {

            $this->response(['status' => $status, 'result' => array()]);
        }
    }
}
