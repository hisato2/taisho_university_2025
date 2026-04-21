<?php
ini_set('display_errors', 1);

define('DSN', 'mysql:host=localhost;dbname=welfare_taisho2025;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');
define('HOST', 'localhost');
define('DB_NAM', 'welfare_taisho2025');

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}
/*

define('DSN', 'mysql:host=localhost;dbname=welfare_taishio;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');
define('HOST', 'localhost');
define('DB_NAM', 'taisho_university');
*/


/* */