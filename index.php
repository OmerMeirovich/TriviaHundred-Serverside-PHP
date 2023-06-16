<?php

require_once 'db_connection.php';
require_once 'switch_functions.php';
require_once 'query_functions.php';

$action = $_GET["action"];
switch ($action) {

    case 'createUser':
        $userName = $_GET['name'];
        $uuid = $_GET['uuid'];
        createUser_switch($userName, $uuid);
        break;
    case 'createSession':
        $userId = $_GET["id"];
        $uuid = $_GET['uuid'];
        $score = $_GET["score"];
        $level = $_GET["level"];
        createSession_switch($userId, $uuid, $score, $level);
        break;
    case 'getSessionsInfo':
        $userId = $_GET["id"];
        $uuid = $_GET['uuid'];
        getSessionInfo_switch($userId, $uuid);
        break;
    case 'getTopFive':
        getTopFiveSessions_switch();
        break;
    case 'getQuestions':
        $levelId = $_GET["category_id"];
        getQuestion_switch($levelId);
        break;
    case 'getRandomQuestions':
        $levelId = $_GET["category_id"];
        // Each level in the databse will have all the questions of that level, for example alleasy questions will be id 100.
        getRandomTen_switch($levelId);
        break;
    case 'getTopLastDay':
        getTopLastDay_switch();
        break;
    case 'getTopLastWeek':
        getTopLastWeek_switch();
        break;
    case 'getConfigs':
        getConfig_switch();
        break;
    case 'setNewName':
        $userId = $_GET["id"];
        $uuid = $_GET['uuid'];
        $userName = $_GET['name'];
        setNewUserName_switch($userId, $userName, $uuid);
        break;
    default:
        echo 'No action provided';
        break;
}



