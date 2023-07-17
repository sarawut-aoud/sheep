<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Dashboard.php ]
 * สำหรับ Front-End
 */
class Home extends MY_Controller
{
	public $data;
	public $per_page;
	public $breadcrumb_data;
	public $left_sidebar_data;
	public $another_js;
	public $another_css;
	public $product_menu;

	public function __construct()
	{
		parent::__construct();

		$data['base_url'] = base_url();
		$data['site_url'] = site_url();

		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);

		$this->data = $data;
		$this->breadcrumb_data = $data;
		$this->left_sidebar_data = $data;
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		redirect('home', 'refresh');
	}

	// ------------------------------------------------------------------------

}
/*---------------------------- END Controller Class --------------------------------*/
