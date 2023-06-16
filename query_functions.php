<?php

//Create a new user.
function createUser_query($userName, $uuid) {

    global $dbh;

    try {
        $sth = $dbh->prepare("INSERT INTO users (user_name,uuid) VALUES (:user_name,:uuid)");
        $sth->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $sth->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $sth->execute();

        $insertedId = $dbh->lastInsertId();
        return $insertedId;
    } catch (Exception $e) {

        echo $e;
        return 0;
    }
}

//check if user exists in a query.
function checkUser_query($userId, $uuid) {

    global $dbh;

    try {

        $sth = $dbh->prepare("SELECT id"
                . " FROM users"
                . " WHERE id = :user_id AND uuid=:uuid");
        $sth->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sth->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row > 0) {

            return true;
        }
    } catch (Exception $ex) {

        echo $ex;
        return false;
    }

    return false;
}

//create a new session using the user_id and the session_time.
function createSession_query($userId, $sessionTime, $score, $level) {

    global $dbh;

    try {
        $sth = $dbh->prepare("INSERT INTO sessions (user_id,score,session_time,level) "
                . "VALUES (:user_id,:score,:session_time,:level)");
        $sth->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sth->bindParam(':score', $score, PDO::PARAM_INT);
        $sth->bindParam(':session_time', $sessionTime, PDO::PARAM_INT);
        $sth->bindParam(':level', $level, PDO::PARAM_INT);

        $sth->execute();

        return true;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// getAll the 10 best sessions info about a user.
function getSesssionInfo_query($userId) {


    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT score,level,session_time"
                . " FROM sessions"
                . " WHERE user_id=:user_id"
                . " ORDER BY score DESC LIMIT 10");
        $sth->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// get all questions for the levelId in the database.
function getQuestions_query($categoryId) {

    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT question,answer_one,answer_two,answer_three,correct_answer"
                . " FROM questions"
                . " WHERE category_id =:category_id");
        $sth->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// Get ten random questions from the database in a random order/
function getRandomTen_query($categoryId) {

    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT question,answer_one,answer_two,answer_three,correct_answer"
                . " FROM questions"
                . " WHERE category_id =:category_id"
                . " ORDER BY RAND()"
                . " LIMIT 100"
        );
        $sth->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// getAll the sessions info about a user.
function getTopFiveSessions_query() {

    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT score,user_id AS user_name"
                . " FROM sessions"
                . " ORDER BY score DESC LIMIT 5");
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

function getNameFromId($userId) {

    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT user_name"
                . " FROM users"
                . " WHERE id=:user_id");
        $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return reset($result);
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

function getConfig_query() {

    global $dbh;

    try {
        $sth = $dbh->prepare("SELECT question_duration,answer_duration,is_changed"
                . " FROM configs");
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// getAll the sessions info about a user.
function getTopLastDay_query() {

    global $dbh;

    $date = new DateTime();
    // 86400 - seconds in one day.
    $stamp = ($date->getTimestamp()) - 86400;


    try {
        $sth = $dbh->prepare("SELECT score,user_id AS user_name"
                . " FROM sessions"
                . " WHERE session_time > :stamp"
                . " ORDER BY score DESC LIMIT 50");
        $sth->bindParam(':stamp', $stamp, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// getAll the sessions info about a user.
function getTopLastWeek_query() {

    global $dbh;

    $date = new DateTime();
    // 604800 - seconds in one week.
    $stamp = ($date->getTimestamp()) - 604800;


    try {
        $sth = $dbh->prepare("SELECT score,user_id AS user_name"
                . " FROM sessions"
                . " WHERE session_time > :stamp"
                . " ORDER BY score DESC LIMIT 50");
        $sth->bindParam(':stamp', $stamp, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}

// getAll the sessions info about a user.
function setNewUserName_query($userId, $userName) {

    global $dbh;
    try {
        $sth = $dbh->prepare("UPDATE users"
                . " SET user_name = :user_name"
                . " WHERE user_id = :user_id");
        $sth->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sth->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $sth->execute();
        return true;
    } catch (Exception $e) {

        echo $e;
        return false;
    }
}
