<?php

/**
 * Note to module developers:
 * 	Keeping a module specific language file like this
 *	in this external folder is not a good practise for
 *	portability - I do not advice you to do this for
 *	your own modules since they are non-default.
 *	Instead, simply put your language files in
 *	application/modules/yourModule/language/
 *	You do not need to change any code, the system
 *	will automatically look in that folder too.
 */

// UCP
$lang['user_panel'] = "Användarpanel";
$lang['change_avatar'] = "Ändra bild";
$lang['nickname'] = "Smeknamn";
$lang['location'] = "Plats";
$lang['expansion'] = "Expansion";
$lang['account_rank'] = "Kontorank";
$lang['voting_points'] = "Röstningspoäng";
$lang['donation_points'] = "Donationspoäng";
$lang['account_status'] = "Kontostatus";
$lang['member_since'] = "Medlem sedan";

// Avatar
$lang['change_avatar'] = "Ändra visningsbild";
$lang['make_use'] = "Vi använder oss utav";
$lang['provides_way'] = "vilket gör det möjligt att använda samma visningsbild på många olika hemsidor.";
$lang['to_change'] = "För att ändra din visningsbild behöver du antingen";
$lang['sign_up_for'] = "registrera dig";
$lang['or'] = "eller";
$lang['log_into'] = "logga in på";
$lang['using_email'] = "med hjälp av följande e-post:";

// Settings
$lang['settings'] = "Kontoinställningar";

$lang['nickname_error'] = "Smeknamnet måste vara mellan 4 och 16 tecken långt och kan endast innehålla bokstäver och siffror";
$lang['location_error'] = "Platsen får endast vara upp till 32 bokstäver lång och får endast innehålla bokstäver";
$lang['pw_doesnt_match'] = "Lösenorden matchar inte!";
$lang['changes_saved'] = "Ändringar har sparats!";
$lang['invalid_pw'] = "Ogiltigt lösenord!";
$lang['nickname_taken'] = "Smeknamn är redan taget";
$lang['invalid_language'] = "Ogiltigt språk";

// Change expansion
$lang['change_expansion'] = "Byt expansion";
$lang['expansion_changed'] = "Din expansion har blivit ändrad.";
$lang['back_to_ucp'] = "Klicka här för att gå tillbaka till användarpanelen!";
$lang['invalid_expansion'] = "Expansionen du har valt finns inte!";
$lang['expansion'] = "Expansion";
$lang['none'] = "Ingen";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";