<?php

$user = 'shokock_trivia';

$pass = 'gunzkid123';

$localhost = 'localhost';

$db_name = 'shokock_trivia_server';


//$user = 'root';
//
//$pass = '';
//
//$localhost = 'localhost';
//
//$db_name = 'shokock_trivia_server';


try {

    // CHARSET TO UTF 8 SO HEBREW WOULD WORK!.
    $dbh = new PDO('mysql:host=' . $localhost . ';dbname=' . $db_name . ';,charset=UTF8', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"))or die("no connction");
} catch (PDOException $e) {


    echo "Connection failed: " . $e->getMessage();
}