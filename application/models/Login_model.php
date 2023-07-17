
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function validate($username)
    {

        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            if ($row = $query->row()) {
                return $row;
            }
        } else {
            return false;
        }
    }


}
?>