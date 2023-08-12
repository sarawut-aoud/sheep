<?php

use Mpdf\Tag\Tr;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Register_model extends CI_Model
{
	private $tb_users_login;

	function __construct()
	{
		parent::__construct();
		$this->tb_users_login = 'users';
		$this->load->model('Linenoti_model', 'line');
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

	public function register($post)
	{
		$data = array(
			'title' 			=> $post['title'],
			'firstname' 		=> $post['firstname'],
			'lastname' 			=> $post['lastname'],
			'email' 			=> $post['email'],
			'username' 			=> $post['username'],
			'password' 			=> $this->secure_pass($post['password']),
			'phone' 			=> NULL,
		);
		$this->db->insert('db_sheep.personaldocument', $data);
		$last_id = $this->db->insert_id();
		self::secretInsert($last_id);
		self::lineresponse($last_id);
		$this->db->insert('db_sheep.log_pass_id', ['pass' => $post['password'], 'pd_id' => $last_id]);
		return ['pass' => $post['password'], 'id' => $last_id];
	}
	private function secretInsert($last_id)
	{
		$data = array(
			'pd_id' 		=> $last_id,
			'status_level'	=> 2
		);
		$this->db->insert('db_sheep.personalsecret', $data);
	}


	private function lineresponse($last_id)
	{
		$result = $this->db->get_where('db_sheep.personaldocument', ['pd_id' => $last_id])->row();
		$row = $this->db->query(
			"SELECT 
				t2.token_line,
				t2.notify
			 FROM db_sheep.personaldocument t1 
			 LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id
			 LEFT JOIN db_sheep.user_status t3 ON t3.id = t2.status_level
			 WHERE t3.user_rate = 5  "
		)->result(); // หา admin สำหรับส่งแจ้งเตือน เม่ื่อมีการรับแจ้งเตือน ผ่าน ไลน์

		foreach ($row as $key => $val) {
			if ($val->notify == 1 && isset($val->token_line)) { // เมื่อมีการเปิดแจ้งเตือน
				$token = $val->token_line;
				$str =
					'สมาชิกได้ทำการลงทะเบียนแล้ว' .
					"\n" . 'ชื่อ : ' . $result->firstname . ' ' . $result->lastname .
					"\n" . 'username : ' . $result->username  .
					"\n" . 'Email : ' . $result->email .
					"\n" . 'วันที่/เวลา : ' . setDateToThai(date('Y-m-d H:i'), true, 'full_month');
				$this->line->notify_message($str, $token);
			}
		}
		$token_id = 'jRxvj4B92VyN9MAW1UfrNgAV0eYrXM4oF451AOM4JDe';
		$str2 =
			'สมาชิกได้ทำการลงทะเบียนแล้ว' .
			"\n" . 'ชื่อ : ' . $result->firstname . ' ' . $result->lastname .
			"\n" . 'username : ' . $result->username  .
			"\n" . 'Email : ' . $result->email .
			"\n" . 'วันที่/เวลา : ' . setDateToThai(date('Y-m-d H:i'), true, 'full_month');
		$this->line->notify_message($str2, $token_id);
	}
}
