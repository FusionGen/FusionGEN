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
$lang['user_panel'] = "Panneau d'utilisateur";
$lang['change_avatar'] = "Changer d'avatar";
$lang['nickname'] = "Surnom";
$lang['location'] = "Location";
$lang['expansion'] = "Expansion";
$lang['account_rank'] = "Rand de compte";
$lang['voting_points'] = "Points de vote";
$lang['donation_points'] = "Points de Don";
$lang['account_status'] = "Statut du compte";
$lang['member_since'] = "Membre depuis";

// Avatar
$lang['change_avatar'] = "Changer d'avatar";
$lang['make_use'] = "Nous faisons usage de";
$lang['provides_way'] = "qui fournit un moyen facile de maintenir vos avatars sur le Web.";
$lang['to_change'] = "Pour changer votre avatar vous devez";
$lang['sign_up_for'] = "Enregistrez-vous pour";
$lang['or'] = "ou";
$lang['log_into'] = "Connectez-vous";
$lang['using_email'] = "en utilisant l'adresse électronique suivante:";

// Settings
$lang['settings'] = "Paramètres de compte";

$lang['nickname_error'] = "Le surnom doit contenir entre 4 et 14 caractères et doit contenir seulement des lettres et des chiffres.";
$lang['location_error'] = "L'emplacement doit contenir jusqu'à 42 caractères et dois seulement contenir des lettres.";
$lang['pw_doesnt_match'] = "Les mots de passe ne correspondent pas!";
$lang['changes_saved'] = "Les changements ont été sauvegardés!";
$lang['invalid_pw'] = "Mot de passe incorrect!";
$lang['nickname_taken'] = "Le surnom est déja utilisé";
$lang['invalid_language'] = "Langue invalide";

// Change expansion
$lang['change_expansion'] = "Changer l'expansion";
$lang['expansion_changed'] = "Votre expansion a été changée.";
$lang['back_to_ucp'] = "Cliquez ici pour retourner au panneau de l'utilisateur!";
$lang['invalid_expansion'] = "L'expansion séléctionnée n'existe pas!";
$lang['expansion'] = "Expansion";
$lang['none'] = "Aucune";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";