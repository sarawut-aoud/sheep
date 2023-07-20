<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Profile_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function get_userdata()
    {
        $result = $this->db->query("SELECT * 
        FROM db_sheep.personaldocument t1
        LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id
        WHERE t1.pd_id = ?", [$this->pd_id])->result_array();

        foreach ($result as $key => $val) {
            $result[$key] = $val;
            $result[$key]['pd_id'] = encrypt($val['pd_id']);
        }
        return $result;
    }
    public function updatepic($post)
    {

        if (isset($post->pictrue)) {
            $this->db->set('picture', $post->pictrue);
            $this->db->where('pd_id', decrypt($post->pd_id));
            $this->db->update('db_sheep.personaldocument');
            $this->status  = true;
        }
        return $this->status;
    }
    public function updateprofile($post)
    {

        $data_personal = [
            'firstname' => $post->firstname,
            'lastname'  => $post->lastname,
            'email'     => $post->email,
            'phone'     => $post->phone ? $post->phone : NULL,
        ];
        $this->db->set($data_personal);
        $this->db->where('pd_id', decrypt($post->pd_id));
        $this->db->update('db_sheep.personaldocument');

        $data_secret = [
            'line'              => $post->lineid ? $post->lineid : NULL,
            'token_line'         => $post->token ? $post->token : NULL,
            'website'           => $post->website ? $post->website : NULL,
            'private_profile'   => $post->privateprofile,
            'notify'            => $post->notifications,
            'receive'           => $post->receivemessages,
        ];
        $this->db->set($data_secret);
        $this->db->where('pd_id', decrypt($post->pd_id));
        $this->db->update('db_sheep.personalsecret');
        
        return true;
    }
}
