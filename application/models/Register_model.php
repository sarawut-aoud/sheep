<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Register_model extends CI_Model
{
	private $tb_users_login;

	function __construct()
	{
		parent::__construct();
		$this->tb_users_login = 'users';
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
		$options = array('cost' => 10);
		return password_hash($key_encrypt, PASSWORD_BCRYPT, $options);
	}

	public function savepd($post)
	{
		$data = array(
			'title' 			=> $post['title'],
			'first_name' 		=> $post['first_name'],
			'last_name' 		=> $post['last_name'],
			'email' 			=> $post['email'],
			'id_card' 			=> str_replace('-', '', $post['id_card']),
			'username' 			=> $post['username'],
			'password' 			=> $this->secure_pass($post['password']),
			'phone_number' 		=> str_replace('-', '', $post['phone_number']),
			'birthday' 			=> date("Y-m-d", strtotime(str_replace('/', '-', $post['birthday']))),
			'lineid' 			=> $post['lineid'],
			'facebook' 			=> $post['facebook'],
			'id_passport'   	=> $post['id_passport'],
			'id_non_thai'   	=> $post['driver_license'],
			'id_driver_license' => $post['non_id_card'],
		);
		$this->db->insert('geerang_gts.personaldocument', $data);
		$insert_id = $this->db->insert_id();
	}
}
