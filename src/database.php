<?php

require_once "../vendor/autoload.php";

class DataBase
{

    protected $pdo;

    function __construct()
    {
        $this->pdo = new \FaaPz\PDO\Database("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
    }
}
