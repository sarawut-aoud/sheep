<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->pd_id = $this->session->userdata('pd_id');
        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $this->renderview('reports/view');
    }
    public function virtualization()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => 'active', 'ref' => '#', 'name' => 'Data Virtualization']
        );

        $this->setJs('/assets/js/chart.js');
        $this->setJs('/assets/js_modules/virtuali.js?ft=' . time());
        $this->renderview('reports/virtuali');
    }
}
