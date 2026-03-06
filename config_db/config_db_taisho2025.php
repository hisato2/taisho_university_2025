<?php
ini_set('display_errors', 1);
define('DSN', 'mysql:host=mysql8084.xserver.jp;dbname=hakuhousha_taishou2025;charset=utf8');
define('DB_USER', 'hakuhousha_dev');
define('DB_PASS', 'hakuhoushait');
define('HOST', 'mysql8084.xserver.jp');
define('DB_NAM', 'hakuhousha_taishou2025');

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}


/*
phpMyAdmindefine('DSN', 'mysql:host=localhost;dbname=taisho_kanri;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');
define('HOST', 'localhost');
define('DB_NAM', 'taisho_kanri');
*/

/* */