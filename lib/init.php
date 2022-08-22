<?php

require 'config.php';

function connect($database) {
    return new \mysqli('localhost', RESET_DB_USER, RESET_DB_PASS);
}

function execute($db, $statement) {
    $db->query($statement);
    if ($db->errno != 0) {
        throw new \Exception($db->error);
    }
}

function execute_file($db, $dbname, $file) {
    $error = [];
    exec('mysql -u '.RESET_DB_USER.' --password="'.RESET_DB_PASS.'" -D '.$dbname.' 0< '.$file, $error, $code);
    if ($code != 0) {
        throw new \Exception(implode(PHP_EOL, $error));
    }
}
