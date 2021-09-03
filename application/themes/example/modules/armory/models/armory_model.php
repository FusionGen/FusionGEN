<?php

class Armory_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function findItem($searchString = "", $realmId = 1)
	{
		//Connect to the world database
		$world_database = $this->realms->getRealm($realmId)->getWorld();
		$world_database->connect();
		
		//Get the connection and run a query
		$query = $world_database->getConnection()->query("SELECT ".columns("item_template", array("entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"), $realmId)." FROM ".table("item_template", $realmId)." WHERE UPPER(".column("item_template", "name", false, $realmId).") LIKE ? ORDER BY ".column("item_template", "ItemLevel", false, $realmId)." DESC", array('%'.strtoupper($searchString).'%'));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();
			return $row;
		}
		else
		{
			return false;
		}
	}
	
	public function findGuild($searchString = "", $realmId = 1)
	{
		//Connect to the character database		
		$character_database = $this->realms->getRealm($realmId)->getCharacters();
		$character_database->connect();
		
		//Get the connection and run a query
		$query = $character_database->getConnection()->query(query("find_guilds", $realmId), array('%'.$searchString.'%'));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();
			
			return $row;
		}
		else
		{
			return false;
		}
	}
	
	public function findCharacter($searchString = "", $realmId = 1)
	{
		//Connect to the character database		
		$character_database = $this->realms->getRealm($realmId)->getCharacters();
		$character_database->connect();
		
		//Get the connection and run a query
		$query = $character_database->getConnection()->query("SELECT ".columns("characters", array("guid", "name", "race", "gender", "class", "level"), $realmId)." FROM ".table("characters", $realmId)." WHERE UPPER(".column("characters", "name", false, $realmId).") LIKE ? ORDER BY ".column("characters", "level", false, $realmId)." DESC", array('%'.strtoupper($searchString).'%'));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row;
		}
		else
		{
			return false;
		}
	}
}
