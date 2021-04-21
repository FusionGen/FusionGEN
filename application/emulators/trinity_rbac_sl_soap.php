<?php defined('BASEPATH') OR die('Silence is golden.');

/**
 * @package FusionCMS
 * @version 6.x
 */

/**
 * Abstraction layer for supporting different emulators
 */
class Trinity_rbac_sl_soap implements Emulator
{
    protected $config;

    /**
     * Whether or not this emulator supports remote console
     */
    protected $hasConsole = true;

    /**
     * Whether or not this emulator supports character stats
     */
    protected $hasStats = true;

    /**
     * Console object
     */
    protected $console;

    /**
     * Array of expansion ids and their corresponding names
     */
    protected $expansions = array(
				8 => "Shadowlands",
				7 => "Battle for Azeroth",
				6 => "Legion",
				5 => "Warlords of Draenor",
				4 => "Mists of Pandaria",
				3 => "Cataclysm",
				2 => "WotLK",
				1 => "TBC",
				0 => "None"
		);

    /**
     * Array of table names
     */
    protected $tables = array(
        'account'            => 'account',
        'account_access'     => 'account_access',
        'account_banned'     => 'account_banned',
        'battlenet_accounts' => 'battlenet_accounts',
        'characters'         => 'characters',
        'item_template'      => 'item_template',
        'character_stats'    => 'character_stats',
        'guild_member'       => 'guild_member',
        'guild'              => 'guild',
        'gm_tickets'         => 'gm_bug'
    );

    /**
     * Array of column names
     */
    protected $columns = array(

        'account' => array(
            'id'         => 'id',
            'username'   => 'username',
            'salt'       => 'salt',
            'password'   => 'verifier',
            'email'      => 'email',
            'joindate'   => 'joindate',
            'last_ip'    => 'last_ip',
            'last_login' => 'last_login',
            'expansion'  => 'expansion'
        ),

        'account_access' => array(
            'AccountId'     => 'AccountId',
            'SecurityLevel' => 'SecurityLevel'
        ),

        'account_banned' => array(
            'id'        => 'id',
            'banreason' => 'banreason',
            'active'    => 'active',
            'bandate'   => 'bandate',
            'unbandate' => 'unbandate',
            'bannedby'  => 'bannedby'
        ),
				
        'battlenet_accounts' => array(
            'id' => 'id',
            'email' => 'email',
            'sha_pass_hash' => 'sha_pass_hash',
            'joindate' => 'joindate',
            'last_ip' => 'last_ip',
            'last_login' => 'last_login'
        ),
		
        'characters' => array(
            'guid'             => 'guid',
            'account'          => 'account',
            'name'             => 'name',
            'race'             => 'race',
            'class'            => 'class',
            'gender'           => 'gender',
            'level'            => 'level',
            'zone'             => 'zone',
            'online'           => 'online',
            'money'            => 'money',
            'totalKills'       => 'totalKills',
            'arenaPoints'      => 'arenaPoints',
            'totalHonorPoints' => 'totalHonorPoints',
            'position_x'       => 'position_x',
            'position_y'       => 'position_y',
            'position_z'       => 'position_z',
            'orientation'      => 'orientation',
            'map'              => 'map'
        ),

        'item_template' => array(
            'entry'         => 'entry',
            'name'          => 'name',
            'Quality'       => 'Quality',
            'InventoryType' => 'InventoryType',
            'RequiredLevel' => 'RequiredLevel',
            'ItemLevel'     => 'ItemLevel',
            'class'         => 'class',
            'subclass'      => 'subclass'
        ),

        'character_stats' => array(
            'guid'          => 'guid',
            'maxhealth'     => 'maxhealth',
            'maxpower1'     => 'maxpower1',
            'maxpower2'     => 'maxpower2',
            'maxpower3'     => 'maxpower3',
            'maxpower4'     => 'maxpower4',
            'maxpower5'     => 'maxpower5',
            'maxpower6'     => 'maxpower6',
            'strength'      => 'strength',
            'agility'       => 'agility',
            'stamina'       => 'stamina',
            'intellect'     => 'intellect',
            'armor'         => 'armor',
            'blockPct'      => 'blockPct',
            'dodgePct'      => 'dodgePct',
            'parryPct'      => 'parryPct',
            'critPct'       => 'critPct',
            'rangedCritPct' => 'rangedCritPct',
            'spellCritPct'  => 'spellCritPct',
            'attackPower'   => 'attackPower',
            'spellPower'    => 'spellPower',
            'resilience'    => 'resilience'
        ),

        'guild' => array(
            'guildid'    => 'guildid',
            'name'       => 'name',
            'leaderguid' => 'leaderguid'
        ),

        'guild_member' => array(
            'guildid' => 'guildid',
            'guid'    => 'guid'
        ),

        'gm_tickets' => array(
            'ticketId'   => 'Id',
            'guid'       => 'playerGuid',
            'message'    => 'note',
            'createTime' => 'createTime',
            'completed'  => 'comment',
            'closedBy'   => 'closedBy'
        )
    );

    /**
     * Array of queries
     */
    protected $queries = array(
        'get_ip_banned'             => 'SELECT ip, bandate, bannedby, banreason, unbandate FROM ip_banned WHERE ip=? AND unbandate > ?',
        'get_character'             => 'SELECT * FROM characters WHERE guid=?',
        'get_item'                  => 'SELECT entry, Flags, name, Quality, bonding, InventoryType, MaxDurability, armor, RequiredLevel, ItemLevel, class, subclass, dmg_min1, dmg_max1, dmg_type1, holy_res, fire_res, nature_res, frost_res, shadow_res, arcane_res, delay, socketColor_1, socketColor_2, socketColor_3, spellid_1, spellid_2, spellid_3, spellid_4, spellid_5, spelltrigger_1, spelltrigger_2, spelltrigger_3, spelltrigger_4, spelltrigger_5, displayid, stat_type1, stat_value1, stat_type2, stat_value2, stat_type3, stat_value3, stat_type4, stat_value4, stat_type5, stat_value5, stat_type6, stat_value6, stat_type7, stat_value7, stat_type8, stat_value8, stat_type9, stat_value9, stat_type10, stat_value10, stackable FROM item_template WHERE entry=?',
        'get_rank'                  => 'SELECT AccountId AccountId, SecurityLevel SecurityLevel, RealmID RealmID FROM account_access WHERE AccountId=?',
        'get_banned'                => 'SELECT id id, bandate bandate, bannedby bannedby, banreason banreason, active active FROM account_banned WHERE id=? AND active=1',
        'get_account_id'            => 'SELECT id id, username username, verifier password, email email, joindate joindate, last_ip last_ip, last_login last_login, expansion expansion FROM account WHERE id = ?',
        'get_account'               => 'SELECT id id, username username, verifier password, email email, joindate joindate, last_ip last_ip, last_login last_login, expansion expansion FROM account WHERE username = ?',
        'get_charactername_by_guid' => 'SELECT name name FROM characters WHERE guid = ?',
        'find_guilds'               => 'SELECT g.guildid guildid, g.name name, COUNT(g_m.guid) GuildMemberCount, g.leaderguid leaderguid, c.name leaderName FROM guild g, guild_member g_m, characters c WHERE g.leaderguid = c.guid AND g_m.guildid = g.guildid AND g.name LIKE ? GROUP BY g.guildid',
        'get_inventory_item'        => 'SELECT slot slot, item item, itemEntry itemEntry FROM character_inventory, item_instance WHERE character_inventory.item = item_instance.guid AND character_inventory.slot >= 0 AND character_inventory.slot <= 18 AND character_inventory.guid=? AND character_inventory.bag=0',
        'get_guild_members'         => 'SELECT m.guildid guildid, m.guid guid, c.name name, c.race race, c.class class, c.gender gender, c.level level, m.rank rank, r.rname rname, r.rights rights FROM guild_member m, guild_rank r, characters c WHERE m.guildid = r.guildid AND m.rank = r.rid AND c.guid = m.guid AND m.guildid = ? ORDER BY r.rights DESC',
        'get_guild'                 => 'SELECT guildid guildid, name guildName, leaderguid leaderguid, motd motd, createdate createdate FROM guild WHERE guildid = ?'
    );

    public function __construct($config)
    {
        $this->config = $config;

        if(!extension_loaded('gmp')) // make sure it's loaded
            show_error('GMP extension is not enabled.');
    }

    /**
     * Get the name of a table
     * @param String $name
     * @return String
     */
    public function getTable($name)
    {
        if(!isset($this->tables[$name]))
            return null;
        return $this->tables[$name];
    }

    /**
     * Get the name of a column
     * @param String $table
     * @param String $name
     * @return String
     */
    public function getColumn($table, $name)
    {
        if(!isset($this->columns[$table][$name]))
            return null;
        return $this->columns[$table][$name];
    }

    /**
     * Get a set of all columns
     * @param String $name
     * @return String
     */
    public function getAllColumns($table)
    {
        if(!isset($this->columns[$table]))
            return null;
        return $this->columns[$table];
    }

    /**
     * Get a pre-defined query
     * @param String $name
     * @return String
     */
    public function getQuery($name)
    {
        if(!isset($this->queries[$name]))
            return null;
        return $this->queries[$name];
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
        if(!isset($this->expansions[$id]))
            return null;
        return $this->expansions[$id];
    }

    /**
     * Get the name of an expansion by the name
     * @param String $name
     * @return Int
     */
    public function getExpansionId($name)
    {
        return array_search($name, $this->expansions) ?: null;
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
     * Password encryption
     */
    public function encrypt($username, $password, $salt = null)
    {
        static::forge(); // once only

        is_string($username) || $username = '';
        is_string($password) || $password = '';
        is_string($salt) || $salt = $this->salt($username);

        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

        // calculate first then calculate the second hash; at last convert to integer (little-endian)
        $h = gmp_import(sha1($salt . sha1(strtoupper($username . ':' . $password), true), true), 1, GMP_LSW_FIRST);
        
        // convert back to byte array, within a 32 pad; remember zeros go on the end in little-endian
        $verifier = str_pad(gmp_export(gmp_powm($g, $h, $N), 1, GMP_LSW_FIRST), 32, chr(0), STR_PAD_RIGHT);

        return $verifier;
    }


		/**
		* Password encryption for battlenet
		*/
		public function encrypt2($email, $password)
		{
			if(!is_string($email)) { $email = ""; }
			if(!is_string($password)) { $password = ""; }
			$sha_pass_hash = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($password)))))))); 

			return $sha_pass_hash;
		}

    /**
     * Fetches salt for the user or generates a new salt one and
     * set it for them automatically if there is none.
     * 
     * @param  string $username [description]
     * @return string           [description]
     */
    public function salt($username)
    {
        static $salt;

        $salt = $salt ?: current(\CI::$APP->external_account_model->getConnection()->query(sprintf('SELECT TRIM("\0" FROM %s) FROM %s WHERE username = ?',
            column('account', 'salt'), table('account')), [$username])->row_array()); // get the stored salt

        if($salt) // if it exists
            return $salt;

        $salt = random_bytes(32);

        register_shutdown_function(function() use($salt, $username) {
            \CI::$APP->external_account_model->getConnection()->query(sprintf('UPDATE %s SET %s = ? WHERE username = ?',
                table('account'), column('account', 'salt')), [$salt, $username]);
        }); // ..saves the salt for the user before finishing the scripts

        return $salt;
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
     * Send mail via ingame mail to a specific character
     * @param String $character
     * @param String $subject
     * @param String $body
     */
    public function sendMail($character, $subject, $body)
    {
        $this->send(".send mail ".$character." \"".$subject."\" \"".$body."\"");
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
        $item_command = array();
        $mail_id = 0;
        $item_count = 0;
        $item_stacks = array();

        foreach($items as $i)
        {
            // Check if item has been added
            if(!isset($item_stacks[$i['id']]))
            {
                // Load the item row
                $item_row = \CI::$APP->realms->getRealm($this->config['id'])->getWorld()->getItem($i['id']);

                // Add the item to the stacks array
                $item_stacks[$i['id']] = array(
                    'id'        => $i['id'],
                    'count'     => array(1),
                    'stack_id'  => 0,
                    'max_count' => $item_row['stackable'],
                );

                continue;
            }

            // If stack is full
            if($item_stacks[$i['id']]['max_count'] == $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']])
            {
                // Create a new stack
                $item_stacks[$i['id']]['stack_id']++;
                $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']] = 0;
            }

            // Add one to the currently active stack
            $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]++;
        }

        // Loop through all items
        foreach($item_stacks as $item)
        {
            foreach($item['count'] as $count)
            {
                // Limit to 8 items per mail
                if($item_count > 8)
                {
                    // Reset item count
                    $item_count = 0;

                    // Queue a new mail
                    $mail_id++;
                }

                // Increase the item count
                $item_count++;

                if(!isset($item_command[$mail_id]))
                {
                    $item_command[$mail_id] = '';
                }

                // Append the command
                $item_command[$mail_id] .= ' '.$item['id'].':'.$count;
            }
        }

        // Send all the queued mails
        for($i = 0; $i <= $mail_id; $i++)
        {
            // .send item
            $this->send("send items ".$character." \"".$subject."\" \"".$body."\"".$item_command[$i]);
        }
    }

    /**
     * Send a console command
     * @param String $command
     * @return Array
     */
    public function send($command)
    {
        $client = new SoapClient(NULL, array(
            'location' => 'http://'.$this->config['hostname'].':'.$this->config['console_port'],
            'uri'      => 'urn:TC',
            'login'    => $this->config['console_username'],
            'password' => $this->config['console_password'],
        )); // ..opens a new socket to the server using the initial configs

        try
        {
            $client->executeCommand(new SoapParam($command, 'command'));
        }
        catch (Exception $e)
        {
            die('Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br/><br/>
                <b>Error:</b> <br/>' . $e->getMessage()); // @note this isn't dev friendly and make impossible to catch errors
        }
    }

    /**
     * Forges and patches everything that this emulator needs
     * in order to work properly.
     * 
     * @return [type] [description]
     */
    private static function forge()
    {
        if(file_exists(APPPATH . 'cache/data/srp6_account_model.cache'))
            return; // already applied everything

        \CI::$APP->external_account_model->getConnection()->query(sprintf('ALTER TABLE %s MODIFY %s binary(32) NULL',
            table('account'), column('account', 'salt'))); // let the salt temporary be empty

        if(!strpos($temp = file_get_contents(APPPATH . 'third_party/MX/Controller.php'), 'verifier'))
        {
            $temp = preg_replace('~^((\s+).+cookie\([\'"]fcms_password[\'"]\).+)~m', "$1

$2if($password && column('account', 'password') == 'verifier' && column('account', 'salt')) // emulator uses srp6 encryption
$2    \$password = urldecode(preg_replace('%.(?:fcms_password=([^;]+))?%', '\\$1', @\$_SERVER['HTTP_COOKIE']));", $temp);

            @file_put_contents(APPPATH . 'third_party/MX/Controller.php', $temp);
        }

        file_put_contents(APPPATH . 'cache/data/srp6_account_model.cache', null);
    }
}
