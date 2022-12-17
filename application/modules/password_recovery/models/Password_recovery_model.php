<?php

class Password_recovery_model extends CI_Model
{
    private $connection;

    public function __construct()
    {
        if (empty($this->connection)) {
            $this->connection = $this->load->database("account", true);
        }
    }

    public function getEmail($username)
    {
        if (!$username) {
            return false;
        }

        $query = $this->external_account_model->getConnection()->query(sprintf(
            'SELECT %s FROM %s WHERE %s = ?',
            column('account', 'email'),
            table('account'),
            column('account', 'username')
        ), [$username]);

        if (!$query->num_rows()) {
            return false;
        }

        return $query->row()->email;
    }

    public function existsEmail($email)
    {
        if (!$email) {
            return false;
        } else {
            $query = $this->connection->query("SELECT " . column("account", "id") . " FROM " . table("account") . " WHERE " . column("account", "email") . "= ?", array($email));

            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function changePassword($username, $newPassword)
    {
        if ($username && $newPassword) {
            $this->connection->query("UPDATE " . table("account") . " SET " . column("account", "password") . " = ?, " . column("account", "sessionkey") . " = '', " . column("account", "v") . " = '', " . column("account", "s") . " = '' WHERE " . column("account", "username") . " = ?", array($newPassword, $username));
        } else {
            return false;
        }
    }

    public function changePassword_srp6($username, $newPassword)
    {
        if (!$username || !$newPassword) {
            return false;
        }

        if (column('account', 'v') && column('account', 's') && column('account', 'sessionkey')) {
            $this->external_account_model->getConnection()->set(column('account', 'sessionkey'), '')
                ->set(column('account', 'salt'), '')->set(column('account', 'verifier'), '');
        }

        $bla = $this->external_account_model->getConnection()->set(column('account', 'password'), $newPassword)
            ->where(column('account', 'username'), $username)->update(table('account'));
    }

    public function getKey($key)
    {
        if ($key) {
            $query = $this->db->query("SELECT recoverykey, username FROM password_recovery_key WHERE recoverykey = ?", array($key));
            $result = $query->result_array();
            if (isset($result[0]['recoverykey']) == $key) {
                return $result[0]['username'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insertKey($key, $username, $email, $ip)
    {
        if (!$key || !$ip || !$username) {
            return false;
        }

        $this->db->query("INSERT INTO password_recovery_key VALUES (?, ?, ?, ?, ?)", [$key, $username, $email, $ip, time()]);
        return true;
    }

    public function deleteKey($key)
    {
        if (!$key) {
            return false;
        }

        $this->db->query('DELETE FROM password_recovery_key WHERE recoverykey = ?', [$key]);
        return true;
    }
}
