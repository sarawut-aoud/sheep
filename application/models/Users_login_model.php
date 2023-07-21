<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Users_login_model extends CI_Model
{
	private $tb_users_login;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ci_utilities_helper');
	}

	public function encrypt_md5_salt($pass)
	{
		// admin
		// 123456 ($2y$11$7E1Dw5fgB1FifW0apMj8meNHQG9janZMxtnaWPC4niyulskCov5sa)
		$key1 = 'RTy4$58/*tdr#t';	//default = RTy4$58/*tdr#t
		$key2 = 'ci@gen#$_sdf';		//default = ci@gen#$_sdf

		$key_md5 = md5($key1 . $pass . $key2);
		$key_md5 = md5($key2 . $key_md5 . $key1);
		$sub1 = substr($key_md5, 0, 7);
		$sub2 = substr($key_md5, 7, 10);
		$sub3 = substr($key_md5, 17, 12);
		$sub4 = substr($key_md5, 29, 3);
		return md5($sub3 . $sub1 . $sub4 . $sub2);
	}

	public function secure_pass($pass)
	{
		$key_encrypt = $this->encrypt_md5_salt($pass);
		$options = array('cost' => 11);
		return password_hash($key_encrypt, PASSWORD_BCRYPT, $options);
	}

	public function db_validate($username, $password, $table)
	{
		$key_encrypt = $this->encrypt_md5_salt($password);
		$query = $this->db->query(
			"SELECT * FROM $table WHERE username = '$username' OR email = '$username' LIMIT 1"
		);

		if ($query->num_rows() == 1) {
			if ($row = $query->row()) {
				//echo $this->secure_pass($password);
				if (password_verify($key_encrypt, $row->password)) {
					return $row;
				}
			}
		}
		return array();
	}

	public function db_changepass_validate($username, $password, $table)
	{
		$key_encrypt = $this->encrypt_md5_salt($password);
		$query = $this->db->query(
			"SELECT * FROM $table WHERE username = '$username' OR email = '$username' LIMIT 1"
		);

		if ($query->num_rows() == 1) {
			if ($row = $query->row()) {
				//echo $this->secure_pass($password);
				if (password_verify($key_encrypt, $row->password)) {
					return true;
				} else {
					return false;
				}
			}
		}
		return  false;;
	}


	public function user_changepass_validate()
	{

		$username = $this->security->xss_clean($this->session->userdata('username'));
		$old_password = $this->security->xss_clean($this->input->post('old_password'));
		$new_password = $this->security->xss_clean($this->input->post('new_password'));


		$query_users = $this->db_changepass_validate($username, $old_password, 'db_sheep.personaldocument');
		if ($query_users) {

			$data = array(
				'password' => $this->secure_pass($new_password)
			);

			$this->db->where('username', $username);
			$this->db->update('db_sheep.personaldocument', $data);

			if ($this->db->affected_rows() > 0) {
				return true;
			}
		}
		return false;
	}

	public function user_validate()
	{
		// Jent edit some variable for mobile api login
		$username = $this->security->xss_clean($this->input->post('input_username') ? $this->input->post('input_username') : $this->input->get('username'));
		$password = $this->security->xss_clean($this->input->post('input_password') ? $this->input->post('input_password') : $this->input->get('password'));

		$query_users = $this->db_validate($username, $password, 'db_sheep.personaldocument');
		$status = false;
		if ($query_users) {
			$status = true;
			self::create_session($query_users);
		}

		// create seesion
		return 	$status;
	}
	private function create_session($data)
	{
		$this->load->config('preallocate');;
		$title = '';
		foreach ($this->config->item('title_option_th') as $key => $val) {
			if ($data->title == $val['value']) {
				$title = $val['label'];
			}
		};

		$date_set = [
			'pd_id'	 			=> $data->pd_id,
			'first_name' 		=> $data->firstname,
			'last_name'			=> $data->lastname,
			'email'				=> $data->email,
			'title'				=> $title,
			'picture'			=> $data->picture,
			'secret'			=> $this->db->get_where('db_sheep.personalsecret', ['pd_id' => $data->pd_id])->row()
		];
		$this->session->set_userdata($date_set);
	}
}
