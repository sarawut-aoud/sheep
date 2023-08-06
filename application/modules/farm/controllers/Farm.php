<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Farm extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->pd_id = $this->session->userdata('pd_id');

        $this->load->model('farm/Sheep_type_model', 'sheep');
        $this->load->model('farm/Farm_model', 'farm');
        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => 'active', 'ref' => '#', 'name' => 'ข้อมูลฟาร์ม']);

        //Js
        $this->setJs('/assets/js_modules/farm.js?ft=' . time());

        $this->renderview('farm/view');
    }
    public function create_sheep()
    {
        $this->setJs('/assets/js_modules/createsheep.js?ft=' . time());

        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => 'active', 'ref' => '#', 'name' => 'เพิ่มข้อมูลแพะ']
        );
        $this->renderview('farm/create_sheep');
    }
    public function get_typesheep()
    {
        try {
            $result = $this->sheep->get_type_sheep();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_farmlist()
    {
        try {
            $result = $this->farm->get_farm();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_farm()
    {
        try {
            $result = $this->farm->get_farm();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function savefarm()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->farm->savefarm($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_farmbyid()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->farm->get_farmbyid($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function savesheep()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->farm->savesheep($post);
            $this->setRes($result,['msg'=>''] , 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
}
