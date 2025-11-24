<?php

class Armory_model extends CI_Model
{
    private $c_connection;
    private $w_connection;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_items($searchString = "", $limit, $offset, $realmId = 1)
    {
        // Connect to the world database
        $realm = $this->realms->getRealm($realmId);
        $realm->getWorld()->connect();
        $this->w_connection = $realm->getWorld()->getConnection();

        // Build the query using Query Builder
        $this->w_connection->select(columns("item_template", ["entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"], $realmId));
        $this->w_connection->from(table("item_template", $realmId));
        $this->w_connection->like('UPPER(' . column("item_template", "name", false, $realmId) . ')', mb_strtoupper($searchString));
        $this->w_connection->order_by(column("item_template", "ItemLevel", false, $realmId), 'DESC');
        $this->w_connection->limit($limit, $offset);

        $query = $this->w_connection->get();

        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    public function get_items_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getWorld()->connect();
        $this->w_connection = $realm->getWorld()->getConnection();

        // Build the query using Query Builder
        $this->w_connection->like('UPPER(' . column("item_template", "name", false, $realmId) . ')', mb_strtoupper($string));
        $this->w_connection->from(table("item_template", $realmId));

        return $this->w_connection->count_all_results();
    }

    public function get_guilds($searchString = "", $limit, $offset, $realmId = 1)
    {
        //Connect to the character database
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        $searchString = $this->c_connection->escape_str($searchString);

        $query = $this->c_connection->query(query("find_guilds", $realmId), ['%' . $searchString . '%']);

        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    public function get_guilds_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        // Build the query using Query Builder
        $this->c_connection->like(column("guild", "name", false, $realmId), $string);
        $this->c_connection->from(table("guild", $realmId));

        return $this->c_connection->count_all_results();
    }

    public function get_characters($searchString = "", $limit, $offset, $realmId = 1)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        // Build the query using Query Builder
        $this->c_connection->select(columns("characters", ["guid", "name", "race", "gender", "class", "level"], $realmId));
        $this->c_connection->from(table("characters", $realmId));
        $this->c_connection->like('UPPER(' . column("characters", "name", false, $realmId) . ')', mb_strtoupper($searchString));
        $this->c_connection->order_by(column("characters", "level", false, $realmId), 'DESC');
        $this->c_connection->limit($limit, $offset);

        $result = $this->c_connection->get();

        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }

    public function get_characters_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        // Build the query using Query Builder
        $this->c_connection->like('UPPER(' . column("characters", "name", false, $realmId) . ')', mb_strtoupper($string));
        $this->c_connection->from(table("characters", $realmId));

        return $this->c_connection->count_all_results();
    }
}
