<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->load->model('Message/Message_model', 'message');
        $this->pd_id = $this->session->userdata('pd_id');

        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $this->another_js .= '<script type="module" src="' . base_url('assets/js_modules/messages/main.js?ft=' . time()) . '"></script>';
        $this->setCss('assets/css/messages/main.css?ft=' . time());
        $this->renderview('message/view');
    }
    public function getperson()
    {
        try {
            $result = $this->message->getperson();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_messageall()
    {
        try {
            $result = $this->message->get_messageall();
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_messageid()
    {
        $post = (object)$this->input->post();

        try {
            $result = $this->message->get_messageid($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function savechat()
    {
        $post = (object)$this->input->post();
        try {
            $result = $this->message->savechat($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
}
