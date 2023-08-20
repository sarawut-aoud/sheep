<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function getperson()
    {
        $result =   $this->db->query(
            "SELECT 
            CONCAT(t1.firstname,' ',t1.lastname) as fullname,
            t1.picture,
            t1.pd_id
            
            FROM db_sheep.personaldocument t1 
            LEFT JOIN db_sheep.personalsecret t2 ON t2.pd_id = t1.pd_id
            WHERE t2.private_profile = 0 AND t2.receive = 1"
        )->result();
        return $result;
    }
}
