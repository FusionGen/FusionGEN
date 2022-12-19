<?php

class Session_model extends CI_Model
{
    public function get()
    {
        $time = time() - (60 * 30);
        $query = $this->db->query("SELECT DISTINCT * FROM ci_sessions WHERE timestamp > ?", array($time));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
