<?php

class Accounts_model extends CI_Model
{
    private $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = $this->external_account_model->getConnection();
    }

    public function getAllUsers($term)
    {
        $this->connection->select('id, username, email');
        $this->connection->like('username', $term);
        $this->connection->or_like('email', $term);
        $query = $this->connection->get('account');
        return $query->result();
    }

    public function getByEmail($email = "")
    {
        $query = $this->connection->query("SELECT " . allColumns("account") . " FROM " . table("account") . " WHERE " . column("account", "email") . " = ?", array($email));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getByUsername($username = "")
    {
        $query = $this->connection->query("SELECT " . allColumns("account") . " FROM " . table("account") . " WHERE " . column("account", "username") . " = ?", array($username));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getById($id = false)
    {
        if (!$id)
		{
            $query = $this->connection->query("SELECT " . allColumns("account") . " FROM " . table("account") . "");

            return $query->result_array();
        } else {
			if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) // fuck cmangos
			{
				$this->connection->select('a.*, b.ip as last_ip, b.loginTime as last_login');
				$this->connection->from('account a');
				$this->connection->join('account_logons b', 'b.accountId = a.id');
				$this->connection->where('a.id', $id);
				$this->connection->order_by("last_login",'DESC');
				$this->connection->order_by("last_ip",'DESC');
				$query = $this->connection->get();
			} else {
				$query = $this->connection->query("SELECT " . allColumns("account") . " FROM " . table("account") . " WHERE " . column("account", "id") . " = ?", array($id));
			}

			if ($query->num_rows() > 0)
			{
				if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) // fuck cmangos
				{
					$result = $query->result_array();
					return $result[0];
				} else {
					$result = $query->result_array();
					return $result[0];
				}
            } else {
            return false;
        }
        }
    }

    public function getInternalDetails($userId = 0)
    {
        $query = $this->db->query("SELECT * FROM account_data WHERE id = ?", array($userId));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getAccessId($userId = 0)
    {
        if (preg_match("/^trinity/i", get_class($this->realms->getEmulator()))) {
            $query = $this->connection->query("SELECT " . column("account_access", "SecurityLevel", true) . " FROM " . table("account_access") . " WHERE " . column("account_access", "AccountId") . " = ?", array($userId));
        } elseif (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $query = $this->connection->query("SELECT " . column("account", "gmlevel", true) . " FROM " . table("account") . " WHERE " . column("account", "id") . " = ?", array($userId));
        } else {
            $query = $this->connection->query("SELECT " . column("account_access", "gmlevel", true) . " FROM " . table("account_access") . " WHERE " . column("account", "id") . " = ?", array($userId));
        }

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function save($id, $external_account_data, $external_account_access_data, $internal_data)
    {
		$old_external_data = $this->accounts_model->getById($id);
		$old_internal_data = $this->accounts_model->getInternalDetails($id);

		$old_values = array_merge($old_external_data, $old_internal_data);
		$new_values = array_merge($external_account_data, $external_account_access_data, $internal_data);

        // Initialize an empty array to store the changed values
        $changed_values = array();

        // Compare the old and new values and store the changed values in the array
        foreach ($new_values as $key => $value) {
            if (isset($old_values[$key]) && $old_values[$key] != $value) {
                $changed_values[$key] = array(
                    'old' => $old_values[$key],
                    'new' => $value
                );
            }
        }
		
        if ($this->getAccessId($id)) {
            if (preg_match("/^trinity/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $this->connection->where(column('account_access', 'AccountId'), $id);
                $this->connection->update(table('account_access'), $external_account_access_data);
            } elseif (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $this->connection->where(column('account', 'id'), $id);
                $this->connection->update(table('account'), $external_account_access_data);
            } else {
                // Update external access
                $this->connection->where(column('account_access', 'id'), $id);
                $this->connection->update(table('account_access'), $external_account_access_data);
            }
        } else {
            if (preg_match("/^trinity/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $external_account_access_data[column('account_access', 'AccountId')] = $id;
                $this->connection->insert(table('account_access'), $external_account_access_data);
            } elseif (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $external_account_access_data[column('account', 'id')] = $id;
                $this->connection->insert(table('account'), $external_account_access_data);
            } else {
                // Update external access
                $external_account_access_data[column('account_access', 'id')] = $id;
                $this->connection->insert(table('account_access'), $external_account_access_data);
            }
        }

        // Update internal
        $this->db->where('id', $id);
        $this->db->update('account_data', $internal_data);

        $this->logger->createLog("admin", "edit", "Edited account " . $this->user->getUsername($id) . " (" . $id . ")", $changed_values);
    }

    public function getLogs($id, $offset = 0, $limit = 0)
    {
        if (!is_numeric($id) || !is_numeric($limit) || !is_numeric($offset)) {
            return null;
        }

        $this->db->select("*");
        $this->db->where('user_id', $id);
        $this->db->order_by('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $this->db->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $this->db->limit(($offset + $limit), $offset);
        }
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
}
