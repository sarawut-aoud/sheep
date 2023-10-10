<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function get_person()
    {
        $result = $this->db->query(
            "SELECT * 
            FROM db_sheep.personaldocument t1
            LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id 
            WHERE  t1.status = 1
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->picture = $val->picture ? $val->picture : '/assets/images/blank_person.jpg';
            $data[$key]->fullname = $val->firstname . ' ' . $val->lastname;
        }

        $json = [
            'data' => $data,
            'count' => count($data),
        ];
        return $json;
    }
    public function updatelevel($post)
    {
        $set = [
            'status_level' => 1
        ];
        $where = [
            'pd_id' => $post->pdid
        ];
        $this->db->update('db_sheep.personalsecret', $set, $where);
        return true;
    }
    public function showdata($post)
    {
        $result = $this->db->query(
            "SELECT * 
            FROM db_sheep.personaldocument t1
            LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id 
            WHERE t1.pd_id = ? AND t1.status = 1
            ",
            [$post->pdid]
        )->row();

        $data =  $result;
        $data->picture = $result->picture ? $result->picture : '/assets/images/blank_person.jpg';
        $data->fullname = $result->firstname . ' ' . $result->lastname;

        return $data;
    }
}
