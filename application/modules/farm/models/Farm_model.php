<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Farm_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pd_id = $this->session->userdata('pd_id');
        $this->status = false;
    }
    public function savefarm($post)
    {
        $data = [
            'pd_id'         => $this->pd_id,
            'farmname'      => $post->farmname,
            'farmer'        => $post->farmername,
            'address'       => $post->address,
            'distirct_id '  => $post->district,
            'amphoe_id'     => $post->amphoe,
            'province_id '  => $post->province,
        ];
        $this->db->insert('db_sheep.farms', $data);
    }
    public function updatefarm($post)
    {
        $data = [

            'farmname'      => $post->farmname,
            'farmer'        => $post->farmername,
            'address'       => $post->address,
            'distirct_id '  => $post->district,
            'amphoe_id'     => $post->amphoe,
            'province_id '  => $post->province,
        ];
        $where = [
            'pd_id'         => $this->pd_id,
            'id'            => $post->farmid
        ];


        return $this->db->update('db_sheep.farms', $data, $where);
    }
    public function get_farm()
    {
        $result = $this->db->get_where('db_sheep.farms', ['pd_id' => $this->pd_id])->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->location = $this->get_location($val->province_id, $val->amphoe_id, $val->distirct_id);
            $data[$key]->sheep = $this->db->query(
                "SELECT
                sheep_type,
                typename,
                COUNT(*) AS sheep_count
            FROM
                db_sheep.sheep_keep  t1
                LEFT JOIN db_sheep.sheep_type t2 ON t2.id = t1.sheep_type
            WHERE
                pd_id = ?
                AND farm_id = ?
                AND is_active = 1
            GROUP BY
                t1.sheep_type",
                [$this->pd_id, $val->id]
            )->result();
        }
        return $data;
    }
    public function get_farmbyid($post)
    {
        return $this->db->get_where('db_sheep.farms', ['id' => $post->id])->row();
    }
    public function get_location($province = 0, $district = 0, $subdistrict = 0)

    {
        $address = array();
        if ($subdistrict > 0) {
            $this->db->from("db_sheep.system_district");
            $this->db->where("system_district.district_id", $subdistrict);
            $this->db->limit(1);
            $querys = $this->db->get();
            $sub = $querys->row();
            $address[]  = 'ตำบล/แขวง ' . $sub->district_name_local;
        }
        if ($district > 0) {
            $this->db->from("db_sheep.system_amphoe");
            $this->db->where("system_amphoe.amphoe_id", $district);
            $this->db->limit(1);
            $queryd = $this->db->get();
            $dis = $queryd->row();
            $address[]  = 'อำเภอ/เขต ' . $dis->nameTh;
        }
        if ($province > 0) {
            $this->db->from("db_sheep.system_province");
            $this->db->where("system_province.province_id", $province);
            $this->db->limit(1);
            $queryp = $this->db->get();
            $pro = $queryp->row();
            $address[]  = 'จังหวัด ' . $pro->nameTh;
        }
        return (!empty($address) ? implode(' ', $address) : '');
    }
    public function savesheep($post)
    {
        $post = $post->data;

        foreach ($post as $key => $val) {
            $data = [
                'sheepcode'     => $val['sheepcode'],
                'sheepname'     => $val['sheepname'],
                'sheep_type'    => $val['sheeptype'],
                'gender'        => $val['gender'],
                'old'           => $val['old'],
                'weight'        => $val['weight'],
                'height'        => $val['height'],
                'farm_id'       => $val['farm'],
                'pd_id'         => $this->pd_id,

            ];

            $this->db->insert('db_sheep.sheep_keep', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $this->status = true;
        }
        return $this->status;
    }
    public function get_datasale($post)
    {
        $post = (object) $post->data;

        $where = '';
        if ($post->date_start || $post->date_end) {
            $start = date('Y-m-d', strtotime($post->date_start));
            $end = date('Y-m-d', strtotime($post->date_end));
            $where .= " AND DATE(t1.saledate) BETWEEN '{$start}' AND '{$end}'";
        }
        $result = $this->db->query(
            "SELECT t1.saledate,
                    t1.rowscoulumn,
                    SUM(t1.pricetotal) as pricetotal
            FROM db_sheep.sheep_sale t1
            WHERE 
            pd_id = {$this->pd_id}
            $where 
            GROUP BY rowscoulumn
            "
        )->result();
        $data = [];
        foreach ($result as $key => $val) {
            $data[$key] = $val;
            $data[$key]->rowdata = $this->db->query(
                "SELECT *
                FROM db_sheep.sheep_sale t1
                LEFT JOIN db_sheep.sheep_type t2 ON t2.id = t1.sheep_type
                WHERE 
                pd_id = {$this->pd_id} AND
                rowscoulumn = '{$val->rowscoulumn}'
                "
            )->result();
        }
        return $data;
    }
    public function save_sale($post)
    {
        $row = $this->db->query(
            "SELECT MAX(rowscoulumn) as rowscoulumn FROM db_sheep.sheep_sale WHERE pd_id = {$this->pd_id}"
        )->row('rowscoulumn');

        $rowdata = $post->data;
        foreach ($rowdata as $key => $val) {
            if ($val['amount'] != '') {

                $data = [
                    'rowscoulumn'   => $row ? $row + 1 : 1,
                    'pd_id'         => $this->pd_id,
                    'sheep_type'    => $val['type_id'],
                    'weight'        => $val['weight'] ? $val['weight'] : 0,
                    'price'         => $val['price'],
                    'amount'        => $val['amount'],
                    'saledate'      => date('Y-m-d', strtotime($val['date'])),
                    'pricetotal'    =>  str_replace(',', '', $val['total']),
                ];
                $this->db->insert('db_sheep.sheep_sale', $data);
            }
        }
        return true;
    }

    public function savesheep_import($post)
    {
        $post = (object)$post->data;

        foreach ($post as $key => $val) {
            $data = [
                'sheepcode'     => $val['sheepcode'],
                'sheepname'     => $val['sheepname'],
                'sheep_type'    => $val['sheep_type'],
                'gender'        => $val['gender'],
                'old'           => $val['old'],
                'weight'        => $val['weight'],
                'height'        => $val['height'],
                'farm_id'       => $val['farm_id'],
                'pd_id'         => $this->pd_id,
            ];

            $this->db->insert('db_sheep.sheep_keep', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $this->status = true;
        }
        return $this->status;
    }
    public function getall()
    {
        $result = $this->db->query("SELECT  * ,t1.id as s_id 
        FROM db_sheep.sheep_keep t1 
        LEFT JOIN db_sheep.sheep_type t2 ON t2.id = t1.sheep_type 
        LEFT JOIN db_sheep.farms t3 ON t3.id = t1.farm_id
        WHERE t1.pd_id = ? AND t1.is_active = 1 ", [$this->pd_id])->result();
        return $result;
    }
    public function deletesheep($post)
    {
        $result = $this->db->update('db_sheep.sheep_keep', ['is_active' => 0], ['id' => $post->sid, 'pd_id' => $this->pd_id]);
        return $result;
    }
    public function getsheepid($post)
    {
        $result = $this->db->query("SELECT  * ,t1.id as s_id 
        FROM db_sheep.sheep_keep t1 
        LEFT JOIN db_sheep.sheep_type t2 ON t2.id = t1.sheep_type 
        LEFT JOIN db_sheep.farms t3 ON t3.id = t1.farm_id
        WHERE t1.pd_id = ? AND t1.is_active = 1 AND t1.id = ? ", [$this->pd_id, $post->sid])->row();

        return $result;
    }
    public function sheepupdate($post)
    {
        $data = [
            'sheepcode'     => $post->sheepcode,
            'sheepname'     => $post->sheepname,
            'sheep_type'    => $post->sheeptype,
            'gender'        => $post->gender,
            'old'           => $post->old,
            'weight'        => $post->weight,
            'height'        => $post->height,
            'farm_id'       => $post->farm,
        ];
        $where = [
            'pd_id' => $this->pd_id,
            'id'    => $post->sid,
        ];
        $result = $this->db->update('db_sheep.sheep_keep', $data, $where);
        return $result;
    }
}
