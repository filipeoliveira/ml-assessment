<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

/**
 * Dumps the given variables and stops the script execution.
 *
 * This function is useful for debugging.
 * After dumping the variables, it stops the script execution using the die() function.
 *
 * @param mixed ...$vars The variables to dump.
 */
function debug(...$vars)
{
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}
