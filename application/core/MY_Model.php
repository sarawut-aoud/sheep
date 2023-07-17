<?php

/**
 * A base model with a series of CI Generator
 * @link http://phpcodemania.blogspot.com
 * @copyright Copyright (c) 2018, SONGCHAI SAETERN
 */
class MY_Model extends CI_Model
{
	private $_table_name;
	private $_select_field;
	private $_where;
	private $_order_by;
	private $_offset;
	private $_limit;
	public $error_message;
	public $log_remark;
	private $admin_level;
	private $is_encrypt_id = false;

	/**
	 * Initialise the model, load database with session or default
	 */
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('use_default_database') == FALSE) {
			// If change new DB
			$session_new_db = $this->session->userdata('session_new_db');
			if ($session_new_db != '') {
				$this->config->load("new_database");
				$db_config = $this->config->item('new_db'); // Load default config
				$db_config['database'] = $session_new_db;   // Set new database name
				$this->db = $this->load->database($db_config, TRUE);    // Connect new database
			}
		}

		$this->set_default();
		$this->log_remark = '';
	}

	/**
	 * Clear parameter
	 */
	private function set_default()
	{
		$this->_select_field = '';
		$this->_where      = '';
		$this->_order_by   = '';
		$this->_offset     = '';
		$this->_limit      = '';
	}

	/**
	 * Count reord
	 * @return Number of record
	 */
	public function count_record()
	{
		$num = 0;
		$this->set_query_parameter();
		if ($query = $this->db->get($this->_table_name)) {
			$num = $query->num_rows();
		}
		return $num;
	}

	/**
	 * List all record with condition
	 * !!DON'T USE $this->db->from('xxxx') while call this Function
	 * Must set table with $this->set_table_name('xxxx');
	 * @return Array multiple record
	 */
	public function list_record()
	{
		$data = array();
		$this->set_query_parameter();
		$this->db->from($this->_table_name);
		if ($query = $this->db->get()) {
			$data = $query->result_array();
		}
		return $data;
	}

	/**
	 * C = Create Record
	 * @param array $data
	 * @return Integer of new id record
	 */
	public function add_record($data = array())
	{
		$this->db->set($data);
		$query = $this->db->insert($this->_table_name);
		return $this->db->insert_id();
	}

	/**
	 * R = Read Record Data
	 * @return Array on record
	 */
	public function load_record()
	{
		if ($this->_where == '') {
			return 'Choose WHERE Clause for load record data';
		} else {
			$this->set_query_parameter();
			$query = $this->db->get_where($this->_table_name);
			return $query->row_array();
		}
	}

	/**
	 * U = Update record data
	 * @param array $data
	 */
	public function update_record($data = array())
	{
		if ($this->_where == '') {
			$this->error_message = 'Choose WHERE Clause for Update / Delet';
			return false;
		} else {
			$this->log_edit_history();

			$this->set_query_parameter();
			$this->db->set($data);
			$results = $this->db->update($this->_table_name);
			return $results;
		}
	}

	/**
	 * D = Delete record
	 */
	public function delete_record()
	{
		if ($this->_where == '') {
			return 'Choose WHERE Clause for Update / Delet';
		} else {
			//Move to LOG
			if ($this->log_delete()) {
				//Delete Record
				$this->set_query_parameter();
				return $this->db->delete($this->_table_name);
			} else {
				$this->error_message = 'Could not create LOG';
			}
		}
	}

	private function log_edit_history()
	{
		$n = 0;
		if ($pk_field = $this->get_primary_key()) {
			//จะทำงานเมื่อพบ PRIMARY Key เท่านั้น
			$pk_field_name = $pk_field;
			$num_pk = 1;
			if (is_array($pk_field)) {
				$num_pk = count($pk_field);
				if ($num_pk > 1) { //if array
					$pk_field_name = implode(',', $pk_field); //ใช้กับ CONCAT_WS(',', {$log_table_pk})
				}
			}

			$log_edit_remark = '';
			if ($this->log_remark != '') {
				$log_edit_remark = $this->log_remark . ' : ';
			}
			$log_edit_remark .= $this->input->post('edit_remark', TRUE);


			$n = 0;
			$this->set_query_parameter();
			$this->db->select($pk_field_name); //หา ID เท่านั้น  ไม่ต้องเก็บข้อมูล
			$query = $this->db->get($this->_table_name);
			foreach ($query->result_array() as $row) {
				if ($num_pk > 1) {
					$pk_value = array();
					foreach ($pk_field as $pk_name) {
						$pk_value[] = isset($row[$pk_name]) ? $row[$pk_name] : '';
					}
					$log_table_id = implode(',', $pk_value);
				} else {
					$log_table_id = isset($row[$pk_field]) ? $row[$pk_field] : '';
				}

				$data = array(
					'log_edit_remark' => mb_substr($log_edit_remark, 0, 50, 'UTF-8'), 'log_edit_table' => $this->_table_name, 'log_edit_table_pk_name' => $pk_field_name, 'log_edit_table_pk_value' => $log_table_id, 'log_edit_condition' => mb_substr($this->_where, 0, 100, 'UTF-8'), 'log_edit_user' => $this->session->userdata('user_id') //App User
					, 'log_edit_datetime' => date('Y-m-d H:i:s'), 'log_login_id' => $this->session->userdata('login_id')
				);
				$this->db->set($data);
				$this->db->insert('tb_ci_log_history');
				$n++;
			}
			return $n;
		}
	}

	private function log_delete()
	{
		//table, del condition, data
		$n = 0;
		if ($pk_field = $this->get_primary_key()) {

			$log_del_remark = $this->input->post('delete_remark', TRUE);

			$pk_field_name = $pk_field;
			$num_pk = 1;
			if (is_array($pk_field)) {
				$num_pk = count($pk_field);
				if ($num_pk > 1) { //if array
					$pk_field_name = implode(',', $pk_field); //ใช้กับ CONCAT_WS(',', {$log_table_pk})
				}
			}

			//จะทำงานเมื่อพบ PRIMARY Key เท่านั้น
			$this->set_query_parameter();
			$query = $this->db->get($this->_table_name);
			foreach ($query->result_array() as $row) {
				if ($num_pk > 1) {
					$pk_value = array();
					foreach ($pk_field as $pk_name) {
						$pk_value[] = isset($row[$pk_name]) ? $row[$pk_name] : '';
					}
					$log_table_id = implode(',', $pk_value);
				} else {
					$log_table_id = isset($row[$pk_field]) ? $row[$pk_field] : '';
				}

				$log_record_data = json_encode($row);

				$data = array(
					'log_del_remark' => mb_substr($log_del_remark, 0, 50, 'UTF-8'), 'log_table_name' => $this->_table_name, 'log_del_condition' => mb_substr($this->_where, 0, 100, 'UTF-8'), 'log_table_pk_name' => $pk_field_name, 'log_table_pk_value' => $log_table_id, 'log_record_data' => $log_record_data, 'create_user_id' => $this->session->userdata('user_id') //App User
					, 'create_datetime' => date('Y-m-d H:i:s'), 'log_login_id' => $this->session->userdata('login_id')
				);
				$this->db->set($data);
				$this->db->insert('tb_ci_log_delete');
				$n++;
			}
		}
		return $n;
	}

	private function get_primary_key()
	{
		$sql = "SHOW KEYS FROM $this->_table_name WHERE Key_name = 'PRIMARY'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 1) {
			$all_field = array();
			foreach ($query->result() as $row) {
				$all_field[] = $row->Column_name;
			}
			return $all_field;
		} else {
			$row = $query->row();
			if (!empty($row)) {
				return $row->Column_name;
			}
		}
	}

	/**
	 * Set table name from model
	 * @param String $table_name
	 */
	public function set_table_name($table_name)
	{
		$this->_table_name = $table_name;
		$this->set_default(); //clear any condition
	}

	/**
	 * Set table name from model
	 * @param String $table_name
	 */
	public function set_select_field($fields_name)
	{
		$this->_select_field = $fields_name;
	}

	/**
	 * Set condition for query
	 * @param string $where_string
	 */
	public function set_where($where_string)
	{
		$this->_where = $where_string;
	}

	public function show_where()
	{
		echo $this->_where;
	}


	/**
	 * Set order by of query
	 * @param string $order_by
	 */
	public function set_order_by($order_by)
	{
		$this->_order_by = $order_by;
	}

	/**
	 * Set start fetch row
	 * @param Integer $start_row
	 */
	public function set_offset($start_row)
	{
		$this->_offset = $start_row;
	}

	/**
	 * Set limit fetch row
	 * @param Integer $limit
	 */
	public function set_limit($limit)
	{
		$this->_limit = $limit;
	}

	/**
	 * Set condition before query
	 */
	public function set_query_parameter()
	{
		if ($this->_select_field != '') {
			$this->db->select($this->_select_field);
		}
		if ($this->_where != '') {
			$this->db->where($this->_where);
		}
		if ($this->_order_by != '') {
			$this->db->order_by($this->_order_by);
		}
		if ($this->_offset != '') {
			$this->db->offset($this->_offset);
		}
		if ($this->_limit != '') {
			$this->db->limit($this->_limit);
		}
	}

	/**
	 * Helper function
	 */
	public function getValueOf($table, $field_select, $where_string = '')
	{
		if ($where_string != '') $where_string = "WHERE " . $where_string;
		$sql = "SELECT $field_select FROM $table $where_string LIMIT 1";

		$this->db->db_debug = FALSE;
		if ($qry = $this->db->query($sql)) {
			if ($row = $qry->row_array()) {
				return $row[$field_select];
			}
		}
	}

	public function getRowOf($table, $field_select = '*', $where_string = '')
	{
		if ($where_string != '') $where_string = "WHERE " . $where_string;
		$sql = "SELECT $field_select FROM $table $where_string LIMIT 1";
		if ($qry = $this->db->query($sql)) {
			return $qry->row_array();
		}
	}


	public function createOptionList($table, $field_value, $field_text, $condition = array())
	{
		$where = '';
		if (isset($condition['where'])) {
			$where = "WHERE " . $condition['where'];
		}
		if (isset($condition['order_by'])) {
			$order_by = $condition['order_by'];
		} else {
			$order_by = $field_text;
		}

		$ret = false;
		if (isset($condition['return'])) {
			$ret = $condition['return'];
		}

		$select_value = '';
		if (isset($condition['active'])) {
			$select_value = $condition['active'];
		}

		$list = '';
		$order_by = 'ORDER BY ' . $order_by;
		$sql = "SELECT $field_value, $field_text FROM $table $where $order_by";
		$qry = $this->db->query($sql);
		foreach ($qry->result_array() as $row) {
			$selected = '';
			if ($select_value == $row[$field_value]) {
				$selected = 'selected="selected"';
			}
			$option = '<option value="' . $row[$field_value] . '" ' . $selected . '>' . $row[$field_text] . '</option>';
			if ($ret == true) {
				$list .= $option;
			} else {
				echo $option;
			}
		}

		if ($ret == true) {
			return $list;
		}
	}

	public function returnOptionList($table, $field_value, $field_text, $condition = array())
	{
		$condition['return'] = true;
		return $this->createOptionList($table, $field_value, $field_text, $condition);
	}

	public function isAdmin()
	{
		if ($this->session->userdata('user_level') == $this->admin_level) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function setEncryptID($status = false)
	{
		$this->is_encrypt_id = $status;
	}

	protected function encrypt($id)
	{
		return $this->is_encrypt_id ? urlencode(encrypt($id)) : (int)$id;
	}

	protected function decrypt($id)
	{
		return $this->is_encrypt_id ? urldecode(decrypt($id)) : (int)$id;
	}

	public function convertID($id)
	{
		return strlen($id) > 11 ? (int)urldecode(decrypt($id)) : urlencode(encrypt($id));
	}

	protected function set_log_create($post) // tbname,
	{
		$post = (object)array(
			'tbname' => $post['tbname']
		);
		$data = array(
			'l_tb_name' => $post->tbname,
			'l_pk_id' 	=> $this->db->insert_id(),
			'str_query'	=> $this->db->last_query(),
			'user_id'	=> $this->session->userdata('admin')['user_admin_id']

		);
		$this->db->insert('geerang_gts.admin_log_create', $data);
	}
	protected function set_log_update($post) // tbname, id 
	{
		$post = (object)array(
			'tbname' => $post['tbname'],
			'pk_id'	 => $post['id'],
		);
		$data = array(
			'l_tb_name' => $post->tbname,
			'l_pk_id' 	=> $post->pk_id,
			'str_query'	=> $this->db->last_query(),
			'user_id'	=> $this->session->userdata('admin')['user_admin_id']
		);
		$this->db->insert('geerang_gts.admin_log_update', $data);
	}

	protected function set_log_delete($post, $str_query)
	{
		$post = (object)array(
			'tbname' => $post['tbname'],
			'pk_id'	 => $post['id'],
			'log_record_data' => $this->db->get_where($post['tbname'], $str_query['where'])->row(),
		);

		$log_record_data = json_encode($post->log_record_data);
		$this->db->delete($str_query['tb'], $str_query['where']);
		$data = array(
			'l_tb_name' 	=> $post->tbname,
			'l_pk_id' 		=> $post->pk_id,
			'str_query'		=> $this->db->last_query(),
			'user_id'		=> $this->session->userdata('admin')['user_admin_id'],
			'record_data'	=> $log_record_data,
		);
		return $this->db->insert('geerang_gts.admin_log_delete', $data);
	}
}
