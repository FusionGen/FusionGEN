<?php

class Armory_model extends CI_Model
{
    private $c_connection;
    private $w_connection;

    public function __construct()
    {
        parent::__construct();
    }

    public function findItem($searchString = "", $realmId = 1)
    {
        //Connect to the world database
        $realm = $this->realms->getRealm($realmId);
        $realm->getWorld()->connect();
        $this->w_connection = $realm->getWorld()->getConnection();

        if (!ctype_alnum($searchString))
        {
            die();
        }
        
        $searchString = $this->w_connection->escape_str($searchString);

        //Get the connection and run a query
        $query = $this->w_connection->query("SELECT " . columns("item_template", array("entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"), $realmId) . " FROM " . table("item_template", $realmId) . " WHERE UPPER(" . column("item_template", "name", false, $realmId) . ") LIKE ? ORDER BY " . column("item_template", "ItemLevel", false, $realmId) . " DESC", array('%' . strtoupper($searchString) . '%'));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    public function findGuild($searchString = "", $realmId = 1)
    {
        //Connect to the character database
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        if (!ctype_alnum($searchString))
        {
            die();
        }

        $searchString = $this->c_connection->escape_str($searchString);

        $query = $this->c_connection->query(query("find_guilds", $realmId), array('%' . $searchString . '%'));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function findCharacter($searchString = "", $realmId = 1)
    {
        //Connect to the character database
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        if (!ctype_alnum($searchString))
        {
            die();
        }

        $searchString = $this->c_connection->escape_str($searchString);

        $query = "SELECT " . columns("characters", array("guid", "name", "race", "gender", "class", "level"), $realmId) . " FROM " . table("characters", $realmId) . " WHERE UPPER(" . column("characters", "name", false, $realmId) . ") = '".$searchString."'";
        $result = $this->c_connection->query($query);

        if ($result->num_rows() > 0) {
            $row = $result->result_array();

            return $row;
        } else {
            return false;
        }
    }
}
