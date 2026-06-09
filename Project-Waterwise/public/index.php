<?php

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */
$minPhpVersion = '8.1'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 */
require __DIR__ . '/../app/Config/Paths.php';


$paths = new Config\Paths();

require $paths->systemDirectory . '/Boot.php';

/*
 *---------------------------------------------------------------
 * 🔍 Disable output buffering so `dd()` works
 *---------------------------------------------------------------
 */
if (ob_get_level()) {
    ob_end_clean(); // <-- This line ensures `dd()` will output immediately.
}

exit(CodeIgniter\Boot::bootWeb($paths));
