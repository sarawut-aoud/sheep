<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->pd_id = $this->session->userdata('pd_id');
        $this->load->model('admin/Setting_model', 'setting');

        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $this->data['title']   =  $this->config->item('title_option_th');
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'ตั้งค่า'],
            ['class' => 'active', 'ref' => '#', 'name' => ' ตั้งค่า Line Notifications / เพิ่มผู้ใช้งาน']
        );

        //Js
        $this->setJs('/assets/js_modules/admin.js?ft=' . time());

        $this->renderview('admin/view');
    }
    public function get_person()
    {
        try {
            $result = $this->setting->get_person();

            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function updatelevel()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->setting->updatelevel($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function saveuser()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->setting->saveuser($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function showdata()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->setting->showdata($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function delete()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->db->update('db_sheep.personaldocument', ['status' => 0], ['pd_id' => $post->pdid]);

            $this->setRes($result, ['msg' => ""], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function getdata()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $result = $this->db->get_where('db_sheep.personaldocument',  ['pd_id' => $post->pdid])->row();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function update()
    {
        $post = (object)$this->input->post(NULL, false);
        try {
            $data = [
                'title' => $post->title,
                'email' => $post->email,
                'firstname' => $post->firstname,
                'lastname' => $post->lastname,
                'update_at' => date('Y-m-d H:i:s')
            ];
            $where = [
                'pd_id' => $post->pdid
            ];
            $result = $this->db->update('db_sheep.personaldocument', $data, $where);
            $this->setRes($result, ['msg' => ''], 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
}
