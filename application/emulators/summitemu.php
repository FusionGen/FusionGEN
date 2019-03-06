<?php

/**
 * Abstraction layer for supporting different emulators
 */

class Summitemu implements Emulator
{
	private $config;
	
	/**
	 * Whether or not this emulator supports remote console
	 */
	private $hasConsole = false;

	/**
	 * Whether or not this emulator supports character stats
	 */
	private $hasStats = false;

	/**
	 * Array of expansion ids and their corresponding names
	 */
	private $expansions = array(
		8 => "TBC",
		0 => "None"
	);

	/**
	 * Array of table names
	 */
	private $tables = array(
		"account" => "accounts",
		"account_access" => "accounts",
		"account_banned" => "accounts",
		"characters" => "characters",
		"item_template" => "items",
		"character_stats" => "characters",
		"guild_member" => "guild_data",
		"guild" => "guilds",
		"gm_tickets" => "gm_tickets"
	);

	/**
	 * Array of column names
	 */
	private $columns = array(

		"account" => array(
			"id" => "acct",
			"username" => "login",
			"password" => "password",
			"email" => "email",
			"joindate" => "lastlogin",
			"last_ip" => "lastip",
			"last_login" => "lastlogin",
			"expansion" => "flags"
		),

		"account_banned" => array(
			"id" => "acct",
			"banreason" => false,
			"active" => "banned",
			"bandate" => false,
			"unbandate" => false,
			"bannedby" => false
		),

		"account_access" => array(
			"id" => "acct",
			"gmlevel" => "gm"
		),

		"characters" => array(
			"guid" => "guid",
			"account" => "acct",
			"name" => "name",
			"race" => "race",
			"class" => "class",
			"gender" => "gender",
			"level" => "level", 
			"zone" => "zoneId",
			"online" => "online",
			"money" => "gold",
			"totalKills" => "killsLifeTime",
			"arenaPoints" => "arenaPoints",
			"totalHonorPoints" => "honorPoints",
			"position_x" => "positionX",
			"position_y" => "positionY",
			"position_z" => "positionZ",
			"orientation" => "orientation",
			"map" => "mapId"
		),

		"item_template" => array(
			"entry" => "entry",
			"name" => "name1",
			"Quality" => "quality",
			"InventoryType" => "inventorytype",
			"RequiredLevel" => "requiredLevel",
			"ItemLevel" => "itemLevel",
			"class" => "class",
			"subclass" => "subclass"
		),

		"character_stats" => array(),

		"guild" => array(
			"guildid" => "guildId",
			"name" => "guildName",
			"leaderguid" => "leaderGuid"
		),

		"guild_member" => array(
			"guildid" => "guildid",
			"guid" => "playerid"
		),

		"gm_tickets" => array(
			"ticketId" => "guid",
			"guid" => "guid",
			"message" => "message",
			"createTime" => "timestamp"
		)
	);

	/**
	 * Array of queries
	 */
	private $queries = array(
		"get_character" => "SELECT guid guid,acct account,name name,race race,class class,gender gender,level level,zoneId zone,online online,gold money,killsLifeTime totalKills,arenaPoints arenaPoints,honorPoints totalHonorPoints,positionX position_x,positionY position_y,positionZ position_z,orientation orientation,mapId map FROM characters WHERE guid=?",
		"get_item" => "SELECT entry entry, flags Flags, name1 name, quality Quality, bonding bonding, inventorytype InventoryType, MaxDurability MaxDurability, armor armor, requiredLevel RequiredLevel, itemLevel ItemLevel, class class, subclass subclass, dmg_min1 dmg_min1, dmg_max1 dmg_max1, dmg_type1 dmg_type1, holy_res holy_res, fire_res fire_res, nature_res nature_res, frost_res frost_res, shadow_res shadow_res, arcane_res arcane_res, delay delay, socket_color_1 socketColor_1, socket_color_2 socketColor_2, socket_color_3 socketColor_3, spellid_1 spellid_1, spellid_2 spellid_2, spellid_3 spellid_3, spellid_4 spellid_4, spellid_5 spellid_5, spelltrigger_1 spelltrigger_1, spelltrigger_2 spelltrigger_2, spelltrigger_3 spelltrigger_3, spelltrigger_4 spelltrigger_4, spelltrigger_5 spelltrigger_5, displayid displayid, stat_type1 stat_type1, stat_value1 stat_value1, stat_type2 stat_type2, stat_value2 stat_value2, stat_type3 stat_type3, stat_value3 stat_value3, stat_type4 stat_type4, stat_value4 stat_value4, stat_type5 stat_type5, stat_value5 stat_value5, stat_type6 stat_type6, stat_value6 stat_value6, stat_type7 stat_type7, stat_value7 stat_value7, stat_type8 stat_type8, stat_value8 stat_value8, stat_type9 stat_type9, stat_value9 stat_value9, stat_type10 stat_type10, stat_value10 stat_value10 FROM items WHERE entry=?",
		"get_rank" => "SELECT acct id, gm gmlevel FROM accounts WHERE acct=?",
		"get_banned" => "SELECT acct id, banned banned FROM accounts WHERE acct=? AND banned=1",
		"get_account_id" => "SELECT acct id, login username, password password, email email, lastlogin joindate, lastip last_ip, lastlogin last_login, flags expansion FROM accounts WHERE acct = ?",
		"get_account" => "SELECT acct id, login username, password password, email email, lastlogin joindate, lastip last_ip, lastlogin last_login, flags expansion FROM accounts WHERE login = ?",
		"get_charactername_by_guid" => "SELECT name name FROM characters WHERE guid = ?",
		"find_guilds" => "SELECT g.guildId guildid, g.guildName name, COUNT(g_m.playerid) GuildMemberCount, g.leaderGuid leaderguid, c.name leaderName FROM guilds g, guild_data g_m, characters c WHERE g.leaderguid = c.guid AND g_m.guildid = g.guildId AND g.guildName LIKE ? GROUP BY g.guildId",
		"get_inventory_item" => "SELECT slot slot, guid item, entry itemEntry FROM playeritems WHERE slot >= 0 AND slot <= 18 AND containerslot = -1 AND ownerguid = ? ORDER BY guid ASC",
		"get_guild_members" => "SELECT m.guildid guildid, m.playerid guid, c.name name, c.race race, c.class class, c.gender gender, c.level level, m.guildRank rank, r.rankName rname, r.rankRights rights FROM guild_data m, guild_ranks r, characters c WHERE m.guildid = r.guildId AND m.guildRank = r.rankId AND c.guid = m.playerid AND m.guildid = ? ORDER BY r.rankRights DESC",
		"get_guild" => "SELECT guildId guildid, guildName guildName, leaderGuid leaderguid, motd motd, createdate createdate FROM guilds WHERE guildId = ?"
	);

	public function __construct($config)
	{
		$this->config = $config;
	}
	
	/**
	 * Get the name of a table
	 * @param String $name
	 * @return String
	 */
	public function getTable($name)
	{
		if(array_key_exists($name, $this->tables))
		{
			return $this->tables[$name];
		}
	}

	/**
	 * Get the name of a column
	 * @param String $table
	 * @param String $name
	 * @return String
	 */
	public function getColumn($table, $name)
	{
		if(array_key_exists($table, $this->columns) && array_key_exists($name, $this->columns[$table]))
		{
			return $this->columns[$table][$name];
		}
	}

	/**
	 * Get a set of all columns
	 * @param String $name
	 * @return String
	 */
	public function getAllColumns($table)
	{
		if(array_key_exists($table, $this->columns))
		{
			return $this->columns[$table];
		}
	}

	/**
	 * Get a pre-defined query
	 * @param String $name
	 * @return String
	 */
	public function getQuery($name)
	{
		if(array_key_exists($name, $this->queries))
		{
			return $this->queries[$name];
		}
	}

	/**
	 * Password encryption
	 */
	public function encrypt($username, $password)
	{
		return $password;
	}

	/**
	 * Expansion getter
	 * @return Array
	 */
	public function getExpansions()
	{
		return $this->expansions;
	}

	/**
	 * Get the name of an expansion by the id
	 * @param Int $id
	 * @return String
	 */
	public function getExpansionName($id)
	{
		if(array_key_exists($id, $this->expansions))
		{
			return $this->expansions[$id];
		}
	}

	/**
	 * Get the name of an expansion by the name
	 * @param String $name
	 * @return Int
	 */
	public function getExpansionId($name)
	{
		if(in_array($name, $this->expansions))
		{
			return array_search($name, $this->expansions);
		}
	}

	/**
	 * Send console command
	 * @param String $command
	 */
	public function sendCommand($command)
	{
		$this->send($command);
	}

	/**
	 * Whether or not console actions are enabled for this emulator
	 * @return Boolean
	 */
	public function hasConsole()
	{
		return $this->hasConsole;
	}

	/**
	 * Whether or not character stats are logged in the database
	 * @return Boolean
	 */
	public function hasStats()
	{
		return $this->hasStats;
	}

	/**
	 * Send items via ingame mail to a specific character
	 * @param String $character
	 * @param String $subject
	 * @param String $body
	 * @param Array $items
	 */
	public function sendItems($character, $subject, $body, $items)
	{
		$character = get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getGuidByName($character);

		// Loop through all items
		foreach($items as $item)
		{
			$data = array(
				"stationary" => "61",
				"sender_guid" => 0,
				"receiver_guid" => $character,
				"subject" => $subject,
				"body" => $body,
				"item_id" => $item['id'],
				"item_stack" => 1
			);

			get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getConnection()->insert("mailbox_insert_queue", $data);
		}
	}

	/**
	 * Send mail via ingame mail to a specific character
	 * @param String $character
	 * @param String $subject
	 * @param String $body
	 */
	public function sendMail($character, $subject, $body)
	{
		$data = array(
				"stationary" => "61",
				"sender_guid" => 0,
				"receiver_guid" => get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getGuidByName($character),
				"subject" => $subject,
				"body" => $body
			);

		get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getConnection()->insert("mailbox_insert_queue", $data);
	}
}