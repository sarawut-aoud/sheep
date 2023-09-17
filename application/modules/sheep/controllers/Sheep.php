<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sheep extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->load->model('Sendmail_model', 'sendmail');
    }

    public function index()
    {
        redirect('/home', 'refresh');
    }
}
