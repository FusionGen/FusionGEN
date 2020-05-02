<?php

/**
 * Short-command to get the current language name
 * @return string
 */
function getLang()
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->getLanguage();
}

/**
 * Short-command to get a language string
 * @param stringstring $id
 * @param stringstring $file
 * @return stringstring
 */
function lang($id, $file = 'main')
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->get($id, $file);
}

/**
 * Short-command to set a client language string
 * @param string $id
 * @param string $file
 * @return string
 */
function clientLang($id, $file = 'main')
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->setClientData($id, $file);
}

/**
 * Translate the JSON-stored language string to the desired language
 * @param string $json
 * @return string
 */
function langColumn($json)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->translateLanguageColumn($json);
}

/**
 * Get the selected language
 * @param string $json
 * @return string
 */
function getColumnLang($json)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->getColumnLanguage($json);
}
