<?php

class Activation_model extends CI_Model
{
    public function add($username, $password, $email, $expansion)
    {
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'expansion' => $expansion,
            'timestamp' => time(),
            'ip' => $this->input->ip_address(),
            'key' => sha1($username . $email . $password . time())
        ];

        $this->db->insert("pending_accounts", $data);

        return $data['key'];
    }

    public function getAccount($key)
    {
        $query = $this->db->query("SELECT * FROM pending_accounts WHERE `key`=?", [$key]);

        if ($query->num_rows()) {
            $row = $query->result_array();
            return $row[0];
        }

        return false;
    }

    public function remove($id, $username, $email)
    {
        $this->db->query(
            "DELETE FROM pending_accounts WHERE id=? OR username=? OR email=?",
            [$id, $username, $email]
        );
    }
}
