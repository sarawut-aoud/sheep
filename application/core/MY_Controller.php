<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 class MY_Controller extends CI_Controller {

	public $data;
	
    protected $another_js;
    protected $another_css;

	private $_version = '0.1';

    public function __construct($database = '') {
        parent::__construct();
		$this->data = array();
		
		// keep menu to array session

		$data['base_url'] = base_url();
		$data['site_url'] = site_url();
		$data['footer_js'] = '';
		$data['logged_in'] = '';
		$data['breadcrumb_list'] = '';
		$data['page_title'] = " $this->_version :";
		$data['system_title'] = " [ Ver. $this->_version ]";
		

		$this->data = $data;

		$this->data['footer_js'] 	= '';

		$csrf_token_name = $this->security->get_csrf_token_name();
		$this->data['csrf_token_name'] = $csrf_token_name;
		$this->data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);

		

	}

}
