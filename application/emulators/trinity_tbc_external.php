<?php

require_once(dirname(__FILE__).'/trinity_tbc_soap.php');

/**
 * Abstraction layer for supporting different emulators
 */

class Trinity_tbc_external extends Trinity_tbc_soap implements Emulator
{	
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
				"receiver" => $character,
				"subject" => $subject,
				"message" => $body,
				"item" => $item['id'],
				"item_count" => 1
			);

			get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getConnection()->insert("mail_external", $data);
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
			"receiver" => get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getGuidByName($character),
			"subject" => $subject,
			"message" => $body
		);

		get_instance()->realms->getRealm($this->config['id'])->getCharacters()->getConnection()->insert("mail_external", $data);
	}
}