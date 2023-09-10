<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class CRUD_Controller extends CI_Controller
{

	public $data;
	public $top_navbar_data;
	public $breadcrumb_data;
	public $left_sidebar_data;
	private $response;


	public function __construct($database = '')
	{
		parent::__construct();
		$this->breadcrumb_data = [];


		$data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$data['user_fullname']		= $this->session->userdata('user_fullname');
		$data['user_lastname']		= $this->session->userdata('user_lastname');
		$data['title_html'] = 'Real-time Data Management Application for  Goat Collecting Stall';
		$data['application_name'] = 'แอปพลิเคชันบริหารจัดการ';
		$data['application_sub_name'] = 'ข้อมูลแพะคอกกลาง';
		$data['application_varsion_mobile'] = 'แอปพลิเคชันบริหารจัดการข้อมูลแพะคอกกลาง';
		$data['application_varsion'] = 'Real-time Data Management Application for  Goat Collecting Stall ' . date('Y') . '  Version 1.0 ';
		$data['text_loading'] =  'L O A D I N G . . .';

		$data['base_url'] = base_url();
		$data['site_url'] = site_url();
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);

		$this->data = $data;
		$this->top_navbar_data = $data;
		$this->breadcrumb_data = $data;
		$this->left_sidebar_data = $data;
		$this->check_online =  in_array(explode('.', $_SERVER['HTTP_HOST'])[0], ['gts']);

		// create session mobile
		if ($this->agent->is_mobile()) {
			$this->session->set_userdata(
				[
					'is_mobile' => 1,
				]
			);
		} else {
			unset($_SESSION['is_mobile']);
		}
	}



	protected function getRes($status, $data = '', $code = '')
	{
		$response['status'] = $status ? $status : null;
		$response['data'] = $data ? $data : null;
		$response['code'] = $code ? $code : null;

		echo json_encode($response);
	}

	protected function setRes($status, $data, $code, $option = '')
	{
		$this->response['status'] = $status ? $status : false;
		$this->response['data'] = $data ? $data : null;
		$this->response['code'] = $code ? $code : null;

		if ($option) {
			$this->response['options'] = $option;
		}

		throw new Exception();
	}

	protected function setErr($code, $message = '')
	{
		$this->response['status'] = false;
		$this->response['message'] = $message ? $message : self::errorCode($code);
		$this->response['code'] = $code;
		throw new Exception();
	}

	protected function response($method)
	{
		echo json_encode($this->response);
	}
	private function errorCode($code): string
	{
		switch ($code) {
			case 400:
				return 'BAD REQUEST';
			case 401:
				return 'NO AUTHENRIZATION';
			case 402:
				return 'INPUT ERROR';
			case 404;
				return 'NOT FOUND';
			default:
				return 'ERROR';
		}
	}
	protected function setBread(...$list)
	{
		$this->breadcrumb_data['breadcrumb'] = $list;
	}

	protected function renderview($path)
	{
		$this->data['menu_list'] = $this->get_menu();
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;

		if ($this->agent->is_mobile()) {
			$this->data['top_navbar'] = $this->parser->parse('template/mobile/top_navbar_view', $this->top_navbar_data, TRUE);
			$this->data['menu'] = $this->parser->parse('template/mobile/menu_list_view', $this->top_navbar_data, TRUE);
			$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			$this->parser->parse('template/mobile/homepage_view', $this->data);
		} else {
			$this->data['top_navbar'] = $this->parser->parse('template/master/top_navbar_view', $this->top_navbar_data, TRUE);
			$this->data['left_sidebar'] = $this->parser->parse('template/master/left_sidebar_view', $this->left_sidebar_data, TRUE);
			$this->data['breadcrumb_list'] = $this->parser->parse('template/master/breadcrumb_view', $this->breadcrumb_data, TRUE);
			$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			$this->parser->parse('template/master/homepage_view', $this->data);
		}
	}
	public function get_menu()
	{
		$login = $this->session->userdata('loginby');
		$where = [];
		$menuadmin = [];
		$menumember = [];
		if ($login == 'admin') {
			$menuadmin = $this->db->get_where('db_sheep.application', ['menu_show' => 1, 'menu_level' => 5])->result();
			$menumember = $this->db->get_where('db_sheep.application',  ['menu_show' => 1, 'menu_level' => 1])->result();
		} else {
			$where = [
				'menu_show' => 1,
				'menu_level' => self::get_loginby($this->session->userdata('pd_id'))
			];
			$menumember = $this->db->get_where('db_sheep.application', $where)->result();
		}
		return  (array)[
			'menu_admin' 	=> $menuadmin ?  $menuadmin : NULL,
			'progamelist'	=> $menumember ?  $menumember : NULL,
		];
	}
	private function get_loginby($pd_id)
	{
		$result = $this->db->query(
			"SELECT user_rate FROM db_sheep.user_status t1 LEFT JOIN db_sheep.personalsecret t2 ON t2.status_level = t1.id WHERE t2.pd_id = ?",
			[$pd_id]
		)->row('user_rate');

		return $result;
	}
	protected function render_main($path)
	{
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('master_view', $this->data);
	}
	protected function setJs($path)
	{
		$this->another_js .= '<script src="' . base_url($path) . '"></script>' . "\n\t";
	}
	protected function setCss($path)
	{
		$this->another_css .= '<link rel="stylesheet" href="' . base_url($path) . '">' . "\n\t";
	}
}
