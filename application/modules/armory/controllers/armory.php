<?php

class Armory extends MX_Controller
{
	private $weapon_sub;
	private $armor_sub;
	private $slots;

	public function __construct()
	{
		parent::__construct();
	
		requirePermission("view");

		$this->load->model('armory_model');

		$this->load->config('tooltip/tooltip_constants');

		$this->weapon_sub = $this->config->item("weapon_sub");
		$this->armor_sub = $this->config->item("armor_sub");
		$this->slots = $this->config->item("slots");
	}

	public function index()
	{
		// Pass "cant_be_empty" string to the client side language system
		clientLang("cant_be_empty", "armory");

		$this->template->setTitle(lang("search_title", "armory"));

		$page = $this->template->loadPage("search.tpl");

		$data = array(
				"module" => "default",
				"headline" => lang("search_headline", "armory"),
				"content" => $page
			);

		$page = $this->template->loadPage("page.tpl", $data);

		$this->template->view($page, "modules/armory/css/search.css", "modules/armory/js/search.js");
	}

	public function search()
	{
		$string = $this->input->post("search");

		if(!$string || strlen($string) <= 2)
		{
			die(lang("search_too_short", "armory"));
		}
		else
		{
			$string = preg_replace('/%/', '\%', $string);

			$search_id = sha1($string);

			$cache = $this->cache->get("search/".$search_id."_".getLang());

			if($cache === false)
			{
				// Is there item cache available?
				$items = $this->cache->get("search/items_".$search_id);

				$characters = array();
				$guilds = array();

				if($items === false)
				{
					$items = array();
					$cache_items = true;
				}
				else
				{
					$cache_items = false;
				}

				$realms = $this->realms->getRealms();
				
				//Get characters, guilds, items for each realm
				foreach($realms as $realm)
				{
					// Assign the realm ID
					$i = $realm->getId();


					$found_characters = $this->armory_model->findCharacter($string, $i);

					if($found_characters)
					{
						foreach($found_characters as $found_character)
						{
							array_push($characters, array(
													'guid' => $found_character['guid'],
													'name' => $found_character['name'],
													'race' => $found_character['race'],
													'gender' => $found_character['gender'],
													'class' => $found_character['class'],
													'level' => $found_character['level'],
													'className' => $this->realms->getClass($found_character['class']),
													'raceName' => $this->realms->getRace($found_character['race']),
													'avatar' => $this->realms->formatAvatarPath($found_character),
													'realm' => $i,
													'realmName' => $realm->getName()
												)
										);
						}
					}

					if($cache_items)
					{
						//Search for a item
						$found_items = $this->armory_model->findItem($string, $i);
						
						if($found_items)
						{
							foreach($found_items as $found_item)
							{
								array_push($items, array(
														'id' => $found_item['entry'],
														'name' => $found_item['name'],
														'level' => $found_item['ItemLevel'],
														'required' => $found_item['RequiredLevel'],
														'type' => $this->getItemType($found_item['InventoryType'], $found_item['class'], $found_item['subclass']),
														'quality' => $found_item['Quality'],
														'realm' => $i,
														'realmName' =>$realm->getName(),
														'icon' => $this->getIcon($found_item['entry'], $i)
													)
											);
							}
						}
					}

					//Search for a guild
					$found_guilds = $this->armory_model->findGuild($string, $i);

					if($found_guilds)
					{
						foreach($found_guilds as $found_guild)
						{
							array_push($guilds, array(
													'id' => $found_guild['guildid'],
													'name' => $found_guild['name'],
													'members' => $found_guild['GuildMemberCount'],
													'realm' => $i,
													'realmName' =>$realm->getName(),
													'ownerGuid' => $found_guild['leaderguid'],
													'ownerName' => $found_guild['leaderName']
												)
										);
						}
					}
				}

				$show = array(
							'characters' => 'none',
							'guilds' => 'none',
							'items' => 'none'
						);

				if(count($characters) > count($guilds) && count($characters) > count($items))
				{
					$show['characters'] = "block";
				}
				elseif(count($guilds) > count($characters) && count($guilds) > count($items))
				{
					$show['guilds'] = "block";
				}
				elseif(count($items) > count($guilds) && count($items) > count($characters))
				{
					$show['items'] = "block";
				}
				else
				{
					// Default to characters
					$show['characters'] = "block";
				}
				

				$data = array(
					'url' => $this->template->page_url,
					'characters' => $characters,
					'guilds' => $guilds,
					'items' => $items,
					'show' => $show,
					'realms' => $realms
				);

				if($cache_items)
				{
					// Cache items for a week
					$this->cache->save("search/items_".$search_id, $items, 60*60*24*7);
				}

				$page = $this->template->loadPage("result.tpl", $data);

				// Cache full output
				$this->cache->save("search/".$search_id."_".getLang(), $page, 60*60*24);		
			}
			else
			{
				$page = $cache;
			}

			die($page);
		}
	}

	private function getIcon($id, $realm)
	{
		$cache = $this->cache->get("items/item_".$realm."_".$id);

		if($cache !== false)
		{
			$cache2 = $this->cache->get("items/display_".$cache['displayid']);

			if($cache2 != false)
			{
				return '<img src="https://wow.zamimg.com/images/wow/icons/small/'.$cache2.'.jpg" align="absmiddle" />';
			}
			else
			{
				return '<img src="https://wow.zamimg.com/images/wow/icons/small/inv_misc_questionmark.jpg" align="absmiddle" />';
			}
		}
		else
		{
			return $this->template->loadPage("icon_ajax.tpl", array('id' => $id, 'realm' => $realm, 'url' => $this->template->page_url));
		}
	}

	private function getItemType($slot, $class, $subclass)
	{
		// Weapons
		if($class == 2)
		{
			$type = (array_key_exists($subclass, $this->weapon_sub)) ? $this->weapon_sub[$subclass] : "Unknown";
		}

		// Armor
		elseif($class == 4)
		{
			$type = (array_key_exists($subclass, $this->armor_sub)) ? $this->armor_sub[$subclass] : "Unknown";
		}

		// Anything else
		else
		{
			$type = null;
		}

		$slot = $this->slots[$slot];

		if(strlen($slot)
		&& strlen($type))
		{
			return $slot." (".$type.")";
		}
		else
		{
			return lang("misc", "armory");
		}
	}
}