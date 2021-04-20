<?php

/**
 * @package FusionCMS
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class External_account_model extends CI_Model
{
	private $connection;
	private $id;
	private $username;
	private $sha_pass_hash;
	private $email;
	private $joindate;
	private $last_ip;
	private $last_login;
	private $expansion;
	private $account_cache;

	public function __construct()
	{
		parent::__construct();
		
		$this->account_cache = array();

		if($this->user->getOnline())
		{
			$this->initialize();
		}
		else
		{
			$this->id = 0;
			$this->username = "Guest";
			$this->sha_pass_hash = "";
			$this->email = ""; 
			$this->joindate =  "";
			$this->last_ip =  "";
			$this->last_login = "";
			$this->expansion = 0;
		}
	}

	public function getConnection()
	{
		$this->connect();

		return $this->connection;
	}
	
	public function connect()
	{
		if(empty($this->connection))
		{
			$this->connection = $this->load->database("account", true);
		}
	}
	
	public function initialize($where = false)
	{
		$this->connect();

		if(!$where)
		{
			$query = $this->connection->query(query("get_account_id"), array($this->session->userdata('id')));
		}
		else 
		{
			$query = $this->connection->query(query("get_account"), array($where));
		}
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			$result = $result[0];
	
			$this->id = $result["id"];
			$this->username = $result["username"];
			$this->sha_pass_hash = $result["password"];
			$this->email = $result["email"];
			$this->joindate = $result["joindate"];
			$this->last_ip = $result["last_ip"];
			$this->last_login = $result["last_login"];
			$this->expansion = $result["expansion"];

			return true;
		}
		else 
		{
			$this->id = 0;
			$this->username = "Guest";
			$this->sha_pass_hash = "";
			$this->email = ""; 
			$this->joindate =  "";
			$this->last_ip =  "";
			$this->last_login = "";
			$this->expansion = 0;

			return false;
		}
	}

	/**
	 * Create a new account
	 * @param String $username
	 * @param String $password
	 * @param String $email
	 */
	public function createAccount($username, $password, $email, $expansion, $isHashed = false) 
	{
		$this->connect();

		$sha_pass_hash = $this->user->createHash($username, $password);

		$data = array(
			column("account", "username") => $username,
			column("account", "password") => ($isHashed) ? $password : $sha_pass_hash,
			column("account", "email") => $email,
			column("account", "expansion") => $expansion,
			column("account", "last_ip") => $this->input->ip_address(),
			column("account", "joindate") => date("Y-m-d")
		);

		// Fix for ArcEmu & AscEmu
		if((get_class($this->realms->getEmulator()) == "Arcemu") || (get_class($this->realms->getEmulator()) == "AscEmu"))
		{
			$data['banned'] = 0;
		}

		$this->connection->insert(table("account"), $data);

		// Fix for TrinityCore Battlenet accounts
		if($expansion > 4)
		{
			$userId = $this->user->getId($username);
		    $sha_pass_hash = $this->user->createHash2($email, $password);

		    $battleData = array(
		    	column("battlenet_accounts", "id") => $userId,
		    	column("battlenet_accounts", "email") => $email,
		    	column("battlenet_accounts", "sha_pass_hash") => $sha_pass_hash,
		    	column("battlenet_accounts", "last_ip") => $this->input->ip_address(),
		    	column("battlenet_accounts", "joindate") => date("Y-m-d")
		    );

		    $this->connection->insert(table("battlenet_accounts"), $battleData);

            //$this->connection->update(table("account"), array(column("account", "battlenet_account") => $userId, column("account", "battlenet_index") => 1));
			$this->connection->query("UPDATE account SET battlenet_account = $userId, battlenet_index = 1 WHERE id = $userId", array($userId));
		}

		// Fix for TrinityCore RBAC (or any emulator with 'rbac' in it's emulator filename)
		if(preg_match("/rbac/i", get_class($this->realms->getEmulator())))
		{
			$userId = $this->user->getId($username);
			$this->connection->query("INSERT INTO rbac_account_permissions(`accountId`, `permissionId`, `granted`, `realmId`) values (?, 195, 1, -1)", array($userId));
		}

		$this->updateDailySignUps();
	}

	private function updateDailySignUps()
	{
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM daily_signups WHERE `date`=?", array(date("Y-m-d")));

		$row = $query->result_array();

		if($row[0]['total'])
		{
			$this->db->query("UPDATE daily_signups SET amount = amount + 1 WHERE `date`=?", array(date("Y-m-d")));
		}
		else
		{
			$this->db->query("INSERT INTO daily_signups(`date`, amount) VALUES(?, ?)", array(date("Y-m-d"), 1));
		}
	}

	/**
	 * Get the banned status
	 * @param Int $id
	 * @return Boolean
	 */
	public function getBannedStatus($id)
	{
		$this->connect();

		$query = $this->connection->query(query("get_banned"), array($id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0];
		}
		elseif(query('get_ip_banned'))
		{
			//check if the ip is banned
			$query = $this->connection->query(query("get_ip_banned"), array($this->input->ip_address(), time()));
			
			if($query->num_rows() > 0)
			{
				$row = $query->result_array();

				return $row[0];
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * Get the rank
	 * @param String $value
	 * @param Boolean $isUsername
	 * @return int
	 */
	public function getRank($value = false, $isUsername = false)
	{
		$this->connect();

		if(!$value)
		{
			$value = $this->getId();
		}
		elseif($isUsername)
		{
			$value = $this->getId($value);
		}
		
		$query = $this->connection->query(query("get_rank"), array($value));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			if($row[0]["gmlevel"] == "")
			{
				$row[0]["gmlevel"] = 0;
			}
			
			return $row[0]["gmlevel"];
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Check if an username exists
	 * @param String $username
	 * @return Boolean
	 */
	public function usernameExists($username)
	{
		$this->connect();

		$count = $this->connection->from(table("account"))->where(array(column("account", "username") => $username))->count_all_results();
		
		if($count)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get total amount of accounts
	 * @return Int
	 */
	public function getAccountCount()
	{
		$this->connect();

		$query = $this->connection->query("SELECT COUNT(*) as `total` FROM ".table("account"));
		$row = $query->result_array();

		return $row[0]['total'];
	}

	/**
	 * Check if an user id exists
	 * @param Int $id
	 * @return Boolean
	 */
	public function userExists($id)
	{
		$this->connect();

		$count = $this->connection->from(table("account"))->where(array(column("account", "id") => $id))->count_all_results();
		
		if($count)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check if an email exists
	 * @param String $email
	 * @return Boolean
	 */
	public function emailExists($email)
	{
		$this->connect();

		$count = $this->connection->from(table("account"))->where(array(column("account", "email") => $email))->count_all_results();
		
		if($count)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	| -------------------------------------------------------------------
	|  Setters
	| -------------------------------------------------------------------
	*/
	public function setUsername($oldUsername, $newUsername)
	{
		$this->connect();

		$this->connection->where(column("account", "username"), $oldUsername);
		$this->connection->update(table("account"), array(column("account", "username") => $newUsername));
	}
	
	public function setPassword($username, $newPassword)
	{
		$this->connect();

		$this->connection->where(column("account", "username"), $username);

		if(column("account", "v") && column("account", "s") && column("account", "sessionkey"))
		{
			$this->connection->update(table("account"), array(
				column("account", "v") => "", 
				column("account", "s")  => "", 
				column("account", "sessionkey") => "", 
				column("account", "password") => $newPassword
				)
			);
		}
		else
		{
			$this->connection->update(table("account"), array(column("account", "password") => $newPassword));
		}
	}
	
	public function setEmail($username, $newEmail)
	{
		$this->connect();

		$this->connection->where(column("account", "username"), $username);
		$this->connection->update(table("account"), array(column("account", "email") => $newEmail));
	}
	
	public function setExpansion($username, $newExpansion)
	{
		$this->connect();

		$this->connection->where(column("account", "username"), $username);
		$this->connection->update(table("account"), array(column("account", "expansion") => $newExpansion));
	}
	
	public function setRank($userId, $newRank)
	{
		$this->connect();

		$this->connection->where(column("account", "id"), $userId);
		$this->connection->update(table("account_access"), array(column("account_access", "gmlevel") => $newRank));
	}
	
	/*
	| -------------------------------------------------------------------
	|  Getters
	| -------------------------------------------------------------------
	*/
	public function getId($username = false)
	{
		if(!$username)
		{
			return $this->id;
		}
		else 
		{
			$this->connect();
			
			$this->connection->select(column("account", "id", true))->from(table("account"))->where(column("account", "username"), $username);
			$query = $this->connection->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();
			
				return $result[0]["id"];
			}
			else 
			{
				//Return id 0
				return false;
			}
				
		}
	}
	
	/**
	 * Get the username
	 * @param Int $id
	 * @return String
	 */
	public function getUsername($id = false)
	{
		if(!$id)
		{
			return $this->username;
		}
		else
		{
			$this->connect();
			
			$this->connection->select(column("account", "username", true))->from(table("account"))->where(array(column("account", "id") => $id));
			$query = $this->connection->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();
			
				return $result[0]["username"];
			}
			else 
			{
				return "Unknown";
			}
		}
	}

	/**
	 * Get the username
	 * @param Int $id
	 * @return String
	 */
	public function getInfo($id = false, $fields = "*")
	{
		if(!$id)
		{
			$id = $this->id;
		}

		if($fields != "*" && !is_array($fields))
		{
			$fields = preg_replace("/ /", "", $fields);
			$fields = explode(",", $fields);
			$fields = columns("account", $fields);
		}
	
		$this->connect();
		
		$this->connection->select($fields)->from(table("account"))->where(array(column("account", "id") => $id));
		$query = $this->connection->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
		
			return $result[0];
		}
		else 
		{
			return false;
		}
		
	}
	
	public function getShaPassHash()
	{
		return $this->sha_pass_hash;	
	}
	
	public function getEmail($id = false)
	{
		if($id == false)
		{
			return $this->email;
		}
		else
		{
			// Check if it has been loaded already
			if(array_key_exists($id, $this->account_cache))
			{
				return $this->account_cache[$id]['email'];
			}
			else
			{
				$this->connect();
				
				$this->connection->select(column("account", "username", true).','.column("account", "email").','.column("account", "joindate"))->from(table("account"))->where(array(column("account", "id") => $id));
				$query = $this->connection->get();
				
				if($query->num_rows() > 0)
				{
					$result = $query->result_array();
					$this->account_cache[$id] = $result[0];

					return $result[0]["email"];
				}
				else
				{
					$this->account_cache[$id]["email"] = false;
					
					return false;
				}
			}
		}
	}
	
	public function getJoinDate()
	{
		return $this->joindate;
	}
	
	public function getLastIp()
	{
		return $this->last_ip;
	}

	public function getExpansion()
	{
		return $this->expansion;
	}
}