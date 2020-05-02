<?php

/**
 * Check if a user has permission to do a certain task
 * @param string $permissionName
 * @param string $moduleName
 * @param int $userId
 * @return bool
 */
function hasPermission($permissionName, $moduleName = false, $userId = false)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->hasPermission($permissionName, $moduleName, $userId);
}

/**
 * Check if a user has permission to see a menu link
 * @param string $permissionName
 * @param string $moduleName
 * @return bool
 */
function hasViewPermission($permissionName, $moduleName)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->hasViewPermission($permissionName, $moduleName);
}

/**
 * Check if a user has permission to do a certain task
 * @param string $permissionName
 * @param string $moduleName
 * @return bool
 */
function requirePermission($permissionName, $moduleName = false)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->requirePermission($permissionName, $moduleName);
}
