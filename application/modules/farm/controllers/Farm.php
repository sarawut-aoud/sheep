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
}
