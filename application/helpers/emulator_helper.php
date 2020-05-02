<?php

/**
 * Get the name of a table
 * @param string $name
 * @return string
 */
function table($name, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        return $CI->realms->getRealm($realm)->getEmulator()->getTable($name);
    } else {
        return $CI->realms->getEmulator()->getTable($name);
    }
}

/**
 * Get the name of a column
 * @param string $table
 * @param string $name
 * @param bool $as
 * @return string
 */
function column($table, $name, $as = false, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        $column = $CI->realms->getRealm($realm)->getEmulator()->getColumn($table, $name);
    } else {
        $column = $CI->realms->getEmulator()->getColumn($table, $name);
    }

    if (!$column) {
        return false;
    }

    return $column . (($as) ? " AS " . $name : "");
}

/**
 * Get a pre-defined query
 * @param string $name
 * @return string
 */
function query($name, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        return $CI->realms->getRealm($realm)->getEmulator()->getQuery($name);
    } else {
        return $CI->realms->getEmulator()->getQuery($name);
    }
}

/**
 * Get the columns and format them
 * @param string $table
 * @param array $columns
 * @return string
 */
function columns($table, $columns, $realm = false)
{
    foreach ($columns as $column) {
        if (!isset($out)) {
            $out = column($table, $column, false, $realm) . " AS " . $column;
        } else {
            $out .= "," . column($table, $column, false, $realm) . " AS " . $column;
        }
    }

    return $out;
}

/**
 * Get the columns and format them
 * @param string $table
 * @param array $columns
 * @return string
 */
function allColumns($table, $realm = false)
{
    global $CI;

    if ($realm) {
        $columns = $CI->realms->getRealm($realm)->getEmulator()->getAllColumns($table);
    } else {
        $columns = $CI->realms->getEmulator()->getAllColumns($table);
    }

    foreach ($columns as $name => $column) {
        if (!isset($out)) {
            $out = $column . " AS " . $name;
        } else {
            $out .= "," . $column . " AS " . $name;
        }
    }

    return $out;
}
