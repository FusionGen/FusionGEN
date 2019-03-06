<?php

class Gm_model extends CI_Model
{	
	/**
	 * Get all tickets
	 * @param Object $realm
	 * @return Array
	 */
	public function getTickets($realm)
	{
		if($realm)
		{
			//Connect to the realm
			$realm->getCharacters()->connect();

			//Do the query
			if(column("gm_tickets", "closedBy", $realm->getId()))
			{
				$query = $realm->getCharacters()->getConnection()->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "completed", false, $realm->getId())." = 0 AND ".column("gm_tickets", "closedBy", false, $realm->getId())." = 0");
			}
			elseif(column("gm_tickets", "completed", $realm->getId()))
			{
				$query = $realm->getCharacters()->getConnection()->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "completed", false, $realm->getId())." = 0");
			}
			else
			{
				$query = $realm->getCharacters()->getConnection()->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId()));
			}

			if($realm->getCharacters()->getConnection()->_error_message())
			{
				die($realm->getCharacters()->getConnection()->_error_message());
			}
			
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else 
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}

	/**
	 * Get a specific ticket
	 * @param Object $realm
	 * @param Int $ticketId
	 * @return Array
	 */
	public function getTicket($realm, $ticketId = false)
	{
		if($ticketId && $realm)
		{
			//Connect to the realm
			$realm->getCharacters()->connect();

			//Do the query
			$query = $realm->getCharacters()->getConnection()->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "ticketId", false, $realm->getId())." = ?", array($ticketId));
			
			if($realm->getCharacters()->getConnection()->_error_message())
			{
				die($realm->getCharacters()->getConnection()->_error_message());
			}

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
		else
		{
			return false;
		}
	}

	/**
	 * Check if a character exists and is offline
	 * @param Int $guid
	 * @param Object $realmConnection
	 * @param Int $realmId
	 * @return Boolean
	 */
	public function characterExists($guid, $realmConnection, $realmId)
	{
		$query = $realmConnection->query("SELECT COUNT(*) AS `total` FROM ".table("characters", $realmId)." WHERE ".column("characters", "guid", false, $realmId)." = ? AND ".column("characters", "online", false, $realmId)." = 0", array($guid));

		if($realmConnection->_error_message())
		{
			die($realmConnection->_error_message());
		}

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			if($result[0]['total'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function setLocation($x, $y, $z, $o, $mapId, $characterGuid, $realmConnection, $realmId)
	{
		$realmConnection->query("UPDATE ".table("characters", $realmId)." SET ".column("characters", "position_x", false, $realmId)." = ?, ".column("characters", "position_y", false, $realmId)." = ?, ".column("characters", "position_z", false, $realmId)." = ?, ".column("characters", "orientation", false, $realmId)." = ?, ".column("characters", "map", false, $realmId)." = ? WHERE ".column("characters", "guid", false, $realmId)." = ?", array($x, $y, $z, $o, $mapId, $characterGuid));
	}

	public function deleteTicket($realmConnection, $ticketId, $realmId)
	{
		if($ticketId && $realmConnection)
		{
			$realmConnection->query("DELETE FROM ".table("gm_tickets", $realmId)." WHERE ".column("gm_tickets", "ticketId", false, $realmId)." = ?",array($ticketId));

			return true;
		}
		else
		{
			return false;
		}
	}

	public function setTicketCompleted($realmConnection, $ticketId, $realmId)
	{
		if($ticketId && $realmConnection)
		{
			if(column("gm_tickets", "closedBy", $realmId))
			{
				$realmConnection->query("UPDATE ".table("gm_tickets", $realmId)." SET ".column("gm_tickets", "completed", false, $realmId)." = 1, ".column("gm_tickets", "closedBy", false, $realmId)."=".column("gm_tickets", "guid", false, $realmId)." WHERE ".column("gm_tickets", "ticketId", false, $realmId)." = ?",array($ticketId));
			}
			else
			{
				$realmConnection->query("UPDATE ".table("gm_tickets")." SET ".column("gm_tickets", "completed", false, $realmId)." = 1 WHERE ".column("gm_tickets", "ticketId", false, $realmId)." = ?",array($ticketId));
			}

			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getBan($realmdConnection, $accountId)
	{
		if($realmdConnection && $accountId)
		{
			$query = $realmdConnection->query("SELECT COUNT(*) banCount FROM ".table("account_banned")." WHERE ".column("account_banned", "id")." = ?", array($accountId));
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
		else 
		{
			return false;
		}
	}

	public function setBan($realmdConnection, $accountId, $bannedBy, $banReason, $banTimeInDays)
	{
		if($realmdConnection && $accountId && $bannedBy && $banReason)
		{
			if(column("account_banned", "banreason") && column("account_banned", "bandate"))
			{
				//Check if it go the banreason and bandate
				$realmdConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "bandate")."`, `".column("account_banned", "unbandate")."`, `".column("account_banned", "bannedby")."`, `".column("account_banned", "banreason")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", ".time().", ".(time() + $banTimeInDays).", '".$bannedBy."', '".$banReason."', 1)");
			}
			else if(column("account_banned", "banreason") && !column("account_banned", "bandate"))
			{
				//Check if it got only banreason
				$realmdConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "banreason")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", '".$banReason."', 1)");
			}
			else
			{
				//Else it doesnt got the banreason and bandate
				$realmdConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", 1)");
			}
		}
		else
		{
			return false;
		}
	}
	
	public function updateBan($realmdConnection, $accountId, $bannedBy, $banReason, $banTimeInDays)
	{
		if($realmdConnection && $accountId && $bannedBy && $banReason)
		{
			if(column("account_banned", "banreason") && column("account_banned", "bandate"))
			{
				//Check if it go the banreason and bandate
				$realmdConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "bandate")." = ?, ".column("account_banned", "unbandate")." = ?, ".column("account_banned", "bannedby")." = ?, ".column("account_banned", "banreason")." = ?, ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", array(time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId));			
			}
			else if(column("account_banned", "banreason") && !column("account_banned", "bandate"))
			{
				//Check if it got only banreason
				$realmdConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "banreason")." = ?, ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", array(time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId));			
			}
			else
			{
				//Else it doesnt got the banreason and bandate
				$realmdConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", array(time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId));			
			}
		}
		else
		{
			return false;
		}
	}
}
