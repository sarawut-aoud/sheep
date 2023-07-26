<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

class Getlocation extends REST_Controller
{

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
                'province' => self::get_province(),
                'amphoe' => self::amphoe(),
                'district' => self::district(),
                // 'all' => self::get_location(),
            );

            $this->response(['status' => $status, 'result' => $data_result]);
        } else {

            $this->response(['status' => $status, 'result' => array()]);
        }
    }
    private function get_province()
    {
        $result = $this->db->get_where('db_sheep.system_province')->result();

        return $result;
    }
    private function amphoe()
    {
        $result = $this->db->get_where('db_sheep.system_amphoe')->result();

        return $result;
    }
    private function district()
    {
        $result = $this->db->get_where('db_sheep.system_district')->result();

        return $result;
    }
    private function get_location()
    {
        $province = self::get_province();
        foreach ($province as $key => $val) {
            $data[$key] = $val;
            $data[$key]->amphoe = self::setamphoe($val->province_id);
        }
        return $data;
    }
    private function setamphoe($province_id)
    {
        $data = [];
        $amphoe =  $this->db->get_where('db_sheep.system_amphoe', ['province_id' => $province_id])->result();
        foreach ($amphoe as $key => $val) {
            $data[$key] = $val;
            $data[$key]->district = $this->db->get_where('db_sheep.system_district', ['province_id' => $province_id, 'amphoe_id' => $val->amphoe_id])->result();
        }
        return $data;
    }
}
