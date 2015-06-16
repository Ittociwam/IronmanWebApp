<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (getenv('OPENSHIFT_MYSQL_DB_HOST')) { // openshift
    $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
    $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
    $dbuser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
    $dbPass = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
} else { // localhost
    $dbuser = 'aNewUser';
    $dbPass = 'password';
    $dbHost = '127.0.0.1';
}
$dbName = 'iron_man';

$db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbuser, $dbPass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

