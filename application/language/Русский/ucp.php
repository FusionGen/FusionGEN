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
$lang['user_panel'] = "Панель пользователя";
$lang['change_avatar'] = "Изменить аватарку";
$lang['nickname'] = "Никнейм";
$lang['location'] = "Локация";
$lang['expansion'] = "Дополнение";
$lang['account_rank'] = "Доступ аккаунта";
$lang['voting_points'] = "Очки голосования";
$lang['donation_points'] = "Очки пожертвования";
$lang['account_status'] = "Аккаунт статус";
$lang['member_since'] = "Игрок с";

// Avatar
$lang['change_avatar'] = "Изменить аватарку";
$lang['make_use'] = "Мы используем";
$lang['provides_way'] = "которая обеспечивает простой способ для поддержания вашей аватарки в Интернете.";
$lang['to_change'] = "Чтобы изменить аватарку вы должны";
$lang['sign_up_for'] = "зарегистрироваться";
$lang['or'] = "или";
$lang['log_into'] = "войти";
$lang['using_email'] = "используя следующую почту:";

// Settings
$lang['settings'] = "Настройки аккаунта";

$lang['nickname_error'] = "Ник должен быть от 4 до 14 символов и может содержать только буквы и цифры";
$lang['location_error'] = "Локация может быть только до 32 символов и может содержать только латинские буквы";
$lang['pw_doesnt_match'] = "Пароль не совпадает!";
$lang['changes_saved'] = "Изменения сохранены!";
$lang['invalid_pw'] = "Не правильный пароль!";
$lang['nickname_taken'] = "Имя пользователя уже существует";
$lang['invalid_language'] = "Не правильный язык";

// Change expansion
$lang['change_expansion'] = "Изменить дополнение";
$lang['expansion_changed'] = "Ваше дополнение было изменено.";
$lang['back_to_ucp'] = "Нажмите сюда, чтобы вернуться в панель пользователя!";
$lang['invalid_expansion'] = "Дополнение которое вы выбрали не существует!";
$lang['expansion'] = "Дополнение";
$lang['none'] = "Нету";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";