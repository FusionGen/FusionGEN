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
$lang['user_panel'] = "Panel de usuario";
$lang['change_avatar'] = "Cambiar avatar";
$lang['nickname'] = "Nombre de usuario";
$lang['location'] = "Localización";
$lang['expansion'] = "Expansión";
$lang['account_rank'] = "Rango de cuenta";
$lang['voting_points'] = "Puntos de Votación (PV)";
$lang['donation_points'] = "Puntos de donación (PD)";
$lang['account_status'] = "Estado de la cuenta";
$lang['member_since'] = "Miembro desde:";

// Avatar
$lang['change_avatar'] = "Cambiar avatar";
$lang['make_use'] = "Hacemos uso de";
$lang['provides_way'] = "lo que nos da una una manera sencilla de mantener tu avatar en la web.";
$lang['to_change'] = "Para cambiar el avatar necesitas";
$lang['sign_up_for'] = "Registrarte para";
$lang['or'] = "O";
$lang['log_into'] = "Conectarse en";
$lang['using_email'] = "usando el siguiente mail:";

// Settings
$lang['settings'] = "Configuración de cuenta";

$lang['nickname_error'] = "El nombre de usuario debe tenerentre 4 y 14 carácteres y estos deben ser alfanuméricos";
$lang['location_error'] = "Location may only be up to 32 characters long and may only contain letters";
$lang['pw_doesnt_match'] = "¡Las contraseñas no coinciden!";
$lang['changes_saved'] = "¡Los cambios han sido cambiados!";
$lang['invalid_pw'] = "¡Contraseña incorrecta!";
$lang['nickname_taken'] = "El nombre de usuario ya está cojido";
$lang['invalid_language'] = "Lenguaje incorrecto";

// Change expansion
$lang['change_expansion'] = "Cambiar expansión";
$lang['expansion_changed'] = "Tu expansión ha sido cambiada.";
$lang['back_to_ucp'] = "¡Click aquí para volver al panel de control del usuario!";
$lang['invalid_expansion'] = "La expansión que has seleccionado no existe!";
$lang['expansion'] = "Expansión";
$lang['none'] = "Ninguna";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";