<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
        $this->date  = date('Y-m-d H:i:s');
    }
    public function getperson($pd_id = NULl)
    {
        $where = '';
        if ($pd_id) {
            $where .= "AND t1.pd_id = {$pd_id}";
        }
        $result =   $this->db->query(
            "SELECT 
            CONCAT(t1.firstname,' ',t1.lastname) as fullname,
            t1.picture,
            t1.pd_id
            FROM db_sheep.personaldocument t1 
            LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id
            WHERE t2.private_profile = 0 AND t2.receive = 1 AND t1.pd_id != {$this->pd_id}  "
        )->result();

        $result = array_map(function ($val) {
            return (object)array_merge((array) $val, [
                'pd_id' => urlencode(encrypt($val->pd_id))
            ]);
        }, $result);

        return $result;
    }
    public function get_messageall()
    {
        $result = $this->db->query(
            "SELECT t1.*,t2.*,
            t1.id as chat_id,
            CONCAT(t3.firstname,' ',t3.lastname) as fullname,
                t3.picture,
                t3.pd_id
                FROM db_sheep.chat_group t1 
                LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
                LEFT JOIN db_sheep.personaldocument t3 ON t3.pd_id = t1.chat_to
                WHERE t1.chat_in = {$this->pd_id} OR t1.chat_to = {$this->pd_id}"
        )->result();

        $result = array_map(function ($val) {
            return (object)array_merge((array) $val, [
                'chat_id' => urlencode(encrypt($val->chat_id))
            ]);
        }, $result);
        return $result;
    }
    public function get_messageid($post)
    {

        $post_pd_id = urldecode(decrypt($post->pd_id));

        $check = $this->db->query("SELECT * FROM db_sheep.chat_group t1 
        LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
        WHERE t1.id = {$post_pd_id}  AND DATE(t2.date_no) = DATE('{$this->date}')
        ")->row();

        if (!$check->id) {
            $last_id = self::create_chat($post_pd_id);
            $result = self::get_chat($last_id);
        } else {
            $result = self::get_chat($check->id);
        }
        $last_message_id = $this->db->query("SELECT MAX(id) AS last_id FROM db_sheep.chat_group WHERE id = $post_pd_id ")->row('last_id');

        $result = array_map(function ($val) {
            return (object)array_merge((array) $val, [
                'content_chat' => json_decode($val->content_chat)
            ]);
        }, $result);
        $obj = [];
        foreach ($result as $key => $val) {
            $obj[$key] = $val;
            $obj[$key]->chat_in = $this->pd_id;
            $obj[$key]->content_chat = self::setchat($val->content_chat);
        }

        $data = [
            'message_id' => urlencode(encrypt($last_message_id)),
            'message'   => $obj,
            'person'    =>  $this->getperson($post_pd_id)[0],
            'time'      => $this->date,
            'today'     => date('H:i', strtotime($this->date))
        ];
        return  $data;
    }
    private function setchat($data)
    {
        $item = [];
        foreach ($data as $key => $value) {
            $item[$key] = $value;
            $item[$key]->text = urldecode($value->text);
            $item[$key]->time = date('H:i', strtotime($value->time));
        }
        return (array)$item;
    }
    private function create_chat($post_pd_id)
    {
        $this->db->insert('db_sheep.chat_content', ['date_no' => $this->date]);

        $data = [
            'chat_in' => $this->pd_id,
            'chat_to'  => $post_pd_id,
            'content_id' => $this->db->insert_id(),
        ];
        $this->db->insert('db_sheep.chat_group', $data);
        return $this->db->insert_id();
    }
    private function get_chat($id)
    {
        $result = $this->db->query("SELECT * FROM db_sheep.chat_group t1 
        LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
        WHERE t1.id = {$id}  AND DATE(t2.date_no) = DATE('{$this->date}') ")->result();
        return $result;
    }
    public function savechat($post)
    {
        $data = [];
        $message_id = urldecode(decrypt($post->message_id));
       
        $row = $this->db->get_where('db_sheep.chat_group', ['id' => $message_id])->row();

        $chat =  $this->db->get_where('db_sheep.chat_content', ['id' => $row->content_id])->row();
        $rawchat = json_decode($chat->content_chat);
        foreach ($rawchat as $key => $value) {
            $data[$key] = [
                'time' => $value->time,
                'text' => $value->text,
                'files' => $value->files,
                'status' => $value->status
            ];
            $last_key = explode('_', $key)[0];
        }

        $item[$last_key + 1 . '_' . $this->pd_id . '_' . $row->content_id] = [
            'time' => $this->date,
            'text' => urlencode($post->data),
            'files' => NULL,
            'status' => 'unread'
        ];
        $obj = array_merge($data, $item);

        $this->db->update('db_sheep.chat_content', ['content_chat' => json_encode($obj)], ['id' => $row->content_id]);
    }
}
