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
$lang['user_panel'] = "Панель користувача";
$lang['change_avatar'] = "Змінити аватар";
$lang['nickname'] = "Никнейм";
$lang['location'] = "Локація";
$lang['expansion'] = "Доповнення";
$lang['account_rank'] = "Доступ аккаунта";
$lang['voting_points'] = "Очки голосування";
$lang['donation_points'] = "Очки пожертвувань";
$lang['account_status'] = "Аккаунт статус";
$lang['member_since'] = "Игрок з";

// Avatar
$lang['change_avatar'] = "Змінити аватар";
$lang['make_use'] = "Ми використовуєм";
$lang['provides_way'] = "яка забезпечує простий спосіб для підримки вашого аватару в інтернеті.";
$lang['to_change'] = "Щоб змінити аватар ви повинні";
$lang['sign_up_for'] = "зареєструватись";
$lang['or'] = "або";
$lang['log_into'] = "увійти";
$lang['using_email'] = "використовуючи наступну пошту:";

// Settings
$lang['settings'] = "Налаштування аккаунта";

$lang['nickname_error'] = "Ник должен быть от 4 до 14 символов и может содержать только буквы и цифры";
$lang['location_error'] = "Локація може бути лише до 32 символів і може містити лише латинські букви.";
$lang['pw_doesnt_match'] = "Пароль не співпадає!";
$lang['changes_saved'] = "Зміни збережені!";
$lang['invalid_pw'] = "Не правильний пароль!";
$lang['nickname_taken'] = "Ім'я користувача вже існує";
$lang['invalid_language'] = "Не правильна мова";

// Change expansion
$lang['change_expansion'] = "Змінити доповнення";
$lang['expansion_changed'] = "Ваше доповнення змінено.";
$lang['back_to_ucp'] = "Нажміть сюди, щоб вернутись в панель користувача!";
$lang['invalid_expansion'] = "доповнення яке ви вибрали не існує!";
$lang['expansion'] = "Доповнення";
$lang['none'] = "Немає";

/**
 * Only translate these if World of Warcraft does it themselves,
 * otherwise you'll confuse people who expect to see them in English
 */
$lang['tbc'] = "The Burning Crusade";
$lang['wotlk'] = "Wrath of The Lich King";
$lang['cataclysm'] = "Cataclysm";
$lang['mop'] = "Mists of Pandaria";