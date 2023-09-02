<?php

use function DusanKasan\Knapsack\replace;

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
        $this->date  = date('Y-m-d H:i:s');
        $this->upload_store_path = './assets/images/messages/';
        $this->load->model('FilesUpload_model', 'FileUpload');
        $this->load->model('Linenoti_model', 'line');
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
                'pd_id' => $val->pd_id
                // 'pd_id' => urlencode(encrypt($val->pd_id))
            ]);
        }, $result);

        return $result;
    }
    public function get_messageall()
    {
        $result = [];
        $row = $this->db->query("SELECT * FROM db_sheep.chat_group WHERE DATE(create_at) = DATE('{$this->date}')")->row();

        if ($row->chat_in != $this->pd_id) {
            $check = 't1.chat_to';
        } else {
            $check = 't1.chat_in';
        }
        

        $get_chat_all = $this->db->query("SELECT count(*) as get_chat_all 
                            FROM db_sheep.chat_group t1
                            WHERE (t1.chat_in = {$this->pd_id} OR t1.chat_to = {$this->pd_id}) ")->row('get_chat_all');
        if ($get_chat_all > 0) {
            $result = $this->db->query(
                "SELECT t1.*,t2.*,
                t1.id as chat_id,
                CONCAT(t3.firstname,' ',t3.lastname) as fullname,
                GROUP_CONCAT(t2.content_chat) as content_chat,
                    t3.picture,
                    t3.pd_id
                    FROM db_sheep.chat_group t1 
                    RIGHT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
                    LEFT JOIN db_sheep.personaldocument t3 ON t3.pd_id =  $check
                    WHERE (t1.chat_in = {$this->pd_id} OR t1.chat_to = {$this->pd_id}) "
            )->result();


            $result = array_map(function ($val) {
                $last_id = $this->db->query("SELECT MAX(content_id) AS last_id FROM db_sheep.chat_group WHERE chat_in = {$val->pd_id} OR chat_to = {$val->pd_id} ")->row('last_id');
                $chat = $this->db->get_where('db_sheep.chat_content', ['id' => $last_id])->row();

                $last_chat = self::setchat(json_decode($chat->content_chat));
                if (end($last_chat)->text) {
                    $last_msg =  end($last_chat);
                } else {
                    $chat = $this->db->get_where('db_sheep.chat_content', ['id' => $last_id - 1])->row();
                    $last_chat = self::setchat(json_decode($chat->content_chat));
                    $last_msg =  end($last_chat);
                }


                return (object)array_merge((array) $val, [
                    // 'chat_id' => urlencode(encrypt($val->chat_id))
                    'chat_id'       => $val->chat_id,
                    'last_message'  =>  $last_msg->text,
                    'read'          =>  $last_msg->status,
                    'last_datetime' => self::settime($chat->date_no),
                ]);
            }, $result);
        }

        return $result;
    }
    public function get_messageid($post)
    {

        $post_pd_id = $post->pd_id;

        $row = $this->db->query("SELECT * FROM db_sheep.chat_group t1 
        WHERE 
        (t1.chat_in = {$post_pd_id} AND t1.chat_to = {$this->pd_id} )
        OR  (t1.chat_to = {$post_pd_id} AND t1.chat_in = {$this->pd_id} )
        ")->row();


        if ($post_pd_id == $this->pd_id) {
            $filter = "t1.chat_in = {$post_pd_id}";
            $check1 = "t1.chat_in = $post_pd_id ";
        } else {
            $filter = " (t1.chat_in = {$post_pd_id} AND t1.chat_to = {$this->pd_id} )
            OR  (t1.chat_to = {$post_pd_id} AND t1.chat_in = {$this->pd_id} )";
            if ($row->chat_in != $this->pd_id) {
                $check1 = "t1.chat_to = $post_pd_id  AND t1.chat_in = {$this->pd_id}";
            }
            if ($row->chat_to != $this->pd_id) {
                $check1 = "t1.chat_in = $post_pd_id  AND t1.chat_to = {$this->pd_id}";
            }
        }

        $check = $this->db->query("SELECT *,t1.id as m_id FROM db_sheep.chat_group t1 
        LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
        WHERE  $filter
        ")->row();

        // AND DATE(t2.date_no) = DATE('{$this->date}')
        $last_message_id = $this->db->query("SELECT MAX(t1.id) AS last_id FROM db_sheep.chat_group t1 WHERE  $check1 ")->row('last_id');

        if (!$check->m_id) {

            $last_id = self::create_chat($post_pd_id);
            $result = self::get_chat($last_id, $post_pd_id);
        } else {
            $result = self::get_chat($last_message_id, $post_pd_id);
        }


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
            $obj[$key]->datetime = self::settime($val->date_no);
        }

        $data = [
            // 'message_id' => urlencode(encrypt($last_message_id)),
            'message_id' => $last_message_id,
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
    private function settime($value)
    {
        $item = '';
        $date = date("Y-m-d", strtotime($this->date));
        $date_chk = date("Y-m-d", strtotime($value));
        if ($date == $date_chk) {
            $item = "Today at " . date('H:i', strtotime($this->date));
        } else {
            $item = date("d-M-Y", strtotime($value));;
        }
        return $item;
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
    private function get_chat($id, $post_pd_id)
    {

        $check_chat = $this->db->query("SELECT * FROM db_sheep.chat_content WHERE id = {$id} AND DATE(date_no) = DATE('{$this->date}') ")->row();

        if ($post_pd_id == $this->pd_id) {
            $filter = "t1.chat_in = {$this->pd_id}";
        } else {
            $filter = "(t1.chat_in = {$post_pd_id} AND t1.chat_to = {$this->pd_id} )
            OR  (t1.chat_to = {$post_pd_id} AND t1.chat_in = {$this->pd_id} )";
        }
        if (!$check_chat->id) {
            self::create_chat($post_pd_id);
            $result = $this->db->query("SELECT * FROM db_sheep.chat_group t1 
            LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
            WHERE  $filter ")->result();
        } else {

            $result = $this->db->query("SELECT * FROM db_sheep.chat_group t1 
            LEFT JOIN db_sheep.chat_content t2 ON t2.id = t1.content_id
            WHERE  $filter ")->result();
        }

        return $result;
    }
    public function savechat($post)
    {
        $data = [];
        // $message_id = urldecode(decrypt($post->message_id));
        $message_id = $post->message_id;
        $upload_error = 0;
        $upload_error_msg = '';
        $file_temp = NULL;

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
        if (!empty($_FILES['file']['name'])) {
            $arr = $this->uploadFile('file', $_FILES);
            if ($arr['result'] == TRUE) {
                $file_temp = $arr['file_path'];
            } else {
                $upload_error++;
                $upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
            }
        }

        $item[$last_key + 1 . '_' . $this->pd_id . '_' . $row->content_id] = [
            'time' => $this->date,
            'text' => urlencode($post->data),
            'files' => $file_temp,
            'status' => 'unread'
        ];
        self::notijs($row->content_id, $post->data, $file_temp);

        // self::lineresponse($this->pd_id, $post->data, $file_temp);
        $obj = array_merge($data, $item);

        $this->db->update('db_sheep.chat_content', ['content_chat' => json_encode($obj)], ['id' => $row->content_id]);
        return $upload_error_msg;
    }
    private function uploadFile($file_name, $file, $dir = '')
    {

        $this->load->library('image_lib');
        if (isset($file["file"]["name"])) {

            if ($dir != '' && substr($dir, 0, 1) != '/') {
                $dir = '/' . $dir;
            }
            $path = $this->upload_store_path . (date('Y') + 543) . $dir;
            //เปิดคอนฟิก Auto ชื่อไฟล์ใหม่ด้วย
            $config['upload_path']          = $path;
            $config['allowed_types']        = "*";
            $config['encrypt_name']        = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($file_name)) {

                $encrypt_name = $this->upload->file_name;
                $orig_name = $this->upload->orig_name;
                $image_data =   $this->upload->data();

                $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
                $this->FileUpload->create($encrypt_name, $orig_name);

                $file_path = $path . '/' . $encrypt_name; //ไม่ต้องใช้ Path เต็ม
                $data = array(
                    'result' => TRUE,
                    'file_path' => $file_path,
                    'error' => ''
                );
            } else {
                $data = array(
                    'result' => FALSE,
                    'error' => $this->upload->display_errors()
                );
            }
        }
        return $data;
    }
    private function lineresponse($pd_id, $message, $picture = null)
    {
        $file = null;
        $result = $this->db->query(
            "SELECT 
            t2.id,
            t2.token_line,
            CONCAT(t1.firstname,' ',t1.lastname) as fullname
            FROM db_sheep.personaldocument t1 
            LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id
            WHERE t2.receive = 1 AND t1.pd_id  = ? 
            ",
            [$pd_id]
        )->row();
        if ($result->id) {
            if ($picture != null) {
                $file = base_url($picture);
            }
            $str =
                $result->fullname . ' ได้ส่งข้อความถึงคุณ' .
                "\n" . 'วันที่/เวลา : ' . setDateToThai(date('Y-m-d H:i'), true, 'full_month') .
                "\n" .  $message;
            $this->line->notify_message($str, $result->token_line,  $file);
        }
    }
    public function typing($post)
    {
        $check = [];
        $row = $this->db->query("SELECT * FROM db_sheep.chat_group WHERE chat_in = ? OR chat_to = ?", [$post->pd_id, $post->pd_id])->row();
        if ($row->chat_in == $post->pd_id) {
            $check = ['typing_to' => $post->type];
        }
        if ($row->chat_to == $post->pd_id) {
            $check = ['typing_in' => $post->type];
        }
        $this->db->update('db_sheep.chat_content',  $check, ['id' => $post->message_id]);
        return ['response' => true];
    }

    private function notijs($id, $text, $file)
    {
        $row = $this->db->query("SELECT * FROM db_sheep.chat_group WHERE content_id", [$id])->row();
        if ($row->chat_in != $this->pd_id) {
            $check = $row->chat_in;
        }
        if ($row->chat_to != $this->pd_id) {
            $check = $row->chat_to;
        }
        $fullname = $this->db->query(
            "SELECT 
            CONCAT(t1.firstname,' ',t1.lastname) as fullname
            FROM db_sheep.personaldocument t1 
            WHERE t1.pd_id  = ? 
            ",
            [$this->pd_id]
        )->row('fullname');
        $this->db->insert('db_sheep.chat_log', [
            'pd_id'         =>  $check,
            'sendname'      => $fullname,
            'message_log'   => json_encode(['text' => $text, 'file' => $file]),
            'status_log'    => 0,
            'date_no'       => $this->date,
        ]);
    }
    public function getnotijs()
    {
        $result = $this->db->query(
            "SELECT *, MIN(id) as id FROM db_sheep.chat_log WHERE pd_id = ? AND status_log = 0",
            [$this->pd_id]
        )->row();
        $message = (object)json_decode($result->message_log);
        $text = '';
        if ($message->text) {
            $text .= $result->sendname . " ได้ส่งข้อความถึงคุณ";
        }
        if ($message->file != null) {
            $text .= "และไฟล์";
        }
        $this->db->update('db_sheep.chat_log', ['status_log' => 1], ['id' => $result->id]);
        return ['topic' => $text, 'content' => $message->text];
    }
    public function get_messageid_after($post)
    {
        $css = '';
        $row = $this->db->query("SELECT * FROM db_sheep.chat_group WHERE content_id", [$post->id])->row();
        if ($row->chat_in != $this->pd_id) {
            $check = "pd_id = $row->chat_to";
        }
        if ($row->chat_to != $this->pd_id) {
            $check = "pd_id = $row->chat_in";
        }
        $result = $this->db->query(
            "SELECT *, MIN(id) as id FROM db_sheep.chat_log WHERE $check AND status_append = 0",
        )->row();
        $message = json_decode($result->message_log);
        if ($message->text) {
            $message->time = date('H:i', strtotime($result->create_at));
        }
        $this->db->update('db_sheep.chat_log', ['status_append' => 1], ['id' => $result->id]);
        return ['content' => $message, 'css' => $css];
    }
}
