<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pm_tool');

define('BASE_URL', 'http://localhost/pm-tool');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
