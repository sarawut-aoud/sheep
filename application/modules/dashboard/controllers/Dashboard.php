<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');


        $this->setCss('/assets/css/dashboard.css?ft=' . time());
        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }
    public function index()
    {

        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => 'active', 'ref' => '#', 'name' => 'Dashboard']);

        $this->renderview('dashboard/view');
    }
}
