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
$lang['user_panel'] = "Bruker panel";
$lang['change_avatar'] = "Bytt avatar";
$lang['nickname'] = "Kallenavn";
$lang['location'] = "Plassering";
$lang['expansion'] = "Ekspansjon";
$lang['account_rank'] = "Konto rang";
$lang['voting_points'] = "Voting points";
$lang['donation_points'] = "Donation points";
$lang['account_status'] = "Konto status";
$lang['member_since'] = "Medlem siden";

// Avatar
$lang['change_avatar'] = "Bytt avatar";
$lang['make_use'] = "Vi gjør bruk av";
$lang['provides_way'] = "som gir en enkel måte å vedlikeholde dine avatarer på internett.";
$lang['to_change'] = "for å endre din avatar må du gå til";
$lang['sign_up_for'] = "registrer deg for";
$lang['or'] = "eller";
$lang['log_into'] = "logg in på";
$lang['using_email'] = "bruker denne e-posten:";

// Settings
$lang['settings'] = "Account settings";

$lang['nickname_error'] = "Kallenavn må være mellom 4 og 14 tegn langt og kan bare inneholde bokstaver og tall";
$lang['location_error'] = "Plassering kan bare være opptil 32 tegn langt og kan bare inneholde bokstaver";
$lang['pw_doesnt_match'] = "Passordene stemmer ikke!";
$lang['changes_saved'] = "Endringer er lagret!";
$lang['invalid_pw'] = "Feil passord!";
$lang['nickname_taken'] = "Kallenavnet er allerede tatt";
$lang['invalid_language'] = "Ugyldig språk";

// Change expansion
$lang['change_expansion'] = "Endre ekspansjon";
$lang['expansion_changed'] = "Din ekspansjon har blitt endret.";
$lang['back_to_ucp'] = "Klikk her for å gå tilbake til bruker panel!";
$lang['invalid_expansion'] = "Utvidelsen du valgte eksisterer ikke!";
$lang['expansion'] = "Ekspansjon";
$lang['none'] = "Ingen";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";