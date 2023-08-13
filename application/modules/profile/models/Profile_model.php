<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Profile_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
        $this->load->model('Users_login_model', 'login');
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
    public function checkpassword($post)
    {
        if ($post->old_password != '') {
            $username = $this->db->get_where('db_sheep.personaldocument', ['pd_id' => $this->pd_id])->row('username');
            $old_password = $this->security->xss_clean($post->old_password);
            $query_users = $this->login->db_changepass_validate($username, $old_password, 'db_sheep.personaldocument');
            $this->status =  $query_users;
        }


        return  $this->status;
    }
    public function updatepassword($post)
    {
        if ($post->password != '') {
            $username = $this->db->get_where('db_sheep.personaldocument', ['pd_id' => $this->pd_id])->row('username');

            $data = array(
                'password' => $this->login->secure_pass($post->password)
            );

            $this->db->where('username', $username);
            $rs = $this->db->update('db_sheep.personaldocument', $data);
            $this->status =  $rs ? true : false;
        }
        return $this->status;
    }
}
