<?php
// This file is part of Additional tools library for Moodle™.
// phpcs:disable moodle.Files.BoilerplateComment.CommentEndedTooSoon

/**
 * Environment tests.
 *
 * @package     tool_mulib
 * @copyright   2025 Petr Skoda
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Full 64bit PHP support is required.
 *
 * @param environment_results $result
 * @return environment_results
 */
function tool_mulib_64bit_required(environment_results $result): environment_results {
    $result->setInfo("Full 64-bit PHP support");

    if ((string)PHP_INT_MAX !== '9223372036854775807') {
        $result->setStatus(false);
        return $result;
    }

    // Make sure dates after 2032 are supported.
    $time = strtotime('2050-01-01T00:00:01Z');
    if ((string)$time !== '2524608001') {
        $result->setStatus(false);
        return $result;
    }

    $result->setStatus(true);
    return $result;
}

/**
 * Prevent Oracle Database usage!
 *
 * @param environment_results $result
 * @return environment_results|null
 */
function tool_mulib_oracle_incompatible(environment_results $result): ?environment_results {
    global $DB;

    if ($DB->get_dbfamily() === 'oracle') {
        $result->setStatus(false);
        return $result;
    }

    return null;
}

/**
 * No official support for MS SQL Server because MS gave up on supporting PHP
 * drivers for their database.
 *
 * @param environment_results $result
 * @return environment_results|null
 */
function tool_mulib_mssql_unsupported(environment_results $result): ?environment_results {
    global $DB;

    if ($DB->get_dbfamily() === 'mssql') {
        $result->setStatus(false);
        return $result;
    }

    return null;
}

/**
 * No official support for MS Windows because they stopped supporting PHP and their drivers.
 *
 * @param environment_results $result
 * @return environment_results|null
 */
function tool_mulib_windows_unsupported(environment_results $result): ?environment_results {
    if (DIRECTORY_SEPARATOR === '\\') {
        $result->setStatus(false);
        return $result;
    }

    return null;
}
