<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
       
    }

    public function index()
    {
        $this->render_main('home/login');
    }
    public function preview()
    {
        $this->setJs('/assets/js/chart.js');
        $this->setJs('/assets/js_modules/dashboard.js?ft=' . time());
        $this->setBread(['class' => '', 'ref' => base_url('home/preview'), 'name' => 'Home'], ['class' => 'active', 'ref' => '#', 'name' => 'Dashboard']);
        $this->renderview('home/view');
    }
}
