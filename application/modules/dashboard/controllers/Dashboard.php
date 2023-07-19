<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }
    public function index()
    {
        $this->setJs('/assets/js/chart.js');
        $this->setJs('/assets/js_modules/dashboard.js?ft=' . time());
        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => 'active', 'ref' => '#', 'name' => 'Dashboard']);
        $this->renderview('dashboard/view');
    }
}
