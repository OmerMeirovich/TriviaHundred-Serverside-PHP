<?php

// Function creates a random number and then creates a new user in the db with the random number.
function createUser_switch($userName, $uuid) {

    // check if the function adding user returns true.

    $createdId = createUser_query($userName, $uuid);

    if ($createdId > 0) {

        echo json_encode(array(
            'id' => "$createdId",
            'status' => "1",
            'output' => "success",
        ));
        return;
    }

    echo json_encode(array(
        'id' => "0",
        'status' => "0",
        'output' => "failure",
    ));
    return;
}

// Create a new session when user starts playing.
function createSession_switch($userId, $uuid, $score, $level) {

    // Date of session
    $date = new DateTime();
    $dateStamp = $date->getTimestamp();

    $validUser = checkUser_query($userId, $uuid);

    if ($validUser) {

        if (createSession_query($userId, $dateStamp, $score, $level)) {
            echo json_encode(array(
                'status' => "1",
                'output' => "success",
            ));
            return;
        }
    }

    echo json_encode(array(
        'status' => "0",
        'output' => "failure",
    ));
    return;
}

// Get all session info of a user.
function getSessionInfo_switch($userId, $uuid) {

    $validUser = checkUser_query($userId, $uuid);
    if ($validUser) {

        $response = getSesssionInfo_query($userId);

        $wrapArr = array(
            "Sessions" => $response
        );

        echo json_encode($wrapArr, JSON_PRETTY_PRINT);
    }
}

function getTopFiveSessions_switch() {

    $response = getTopFiveSessions_query();

    foreach (array_keys($response) as $key1) {
        foreach (array_keys($response[$key1]) as $key2) {
            if ($key2 == "user_name") {
                $response[$key1][$key2] = getNameFromId($response[$key1][$key2]);
            }
        }
    }

    $wrapArr = array(
        "Sessions" => $response
    );

    echo json_encode($wrapArr, JSON_PRETTY_PRINT);
}

// Get all questions of a level difficulty.
function getQuestion_switch($levelId) {

    $response = getQuestions_query($levelId);

    $wrapArr = array(
        "Questions" => $response
    );

    echo json_encode($wrapArr, JSON_PRETTY_PRINT);
}

// Get 10 random questions from a level difficulty.
// Database will contain all questions for LEVEL 1, LEVEL 2 and etc..
function getRandomTen_switch($levelId) {

    $response = getRandomTen_query($levelId);

    $wrapArr = array(
        "Questions" => $response
    );
    echo json_encode($wrapArr, JSON_PRETTY_PRINT);
}

function getConfig_switch() {

    $response = getConfig_query();
    echo json_encode($response);
}

function getTopLastDay_switch() {

    $response = getTopLastDay_query();

    foreach (array_keys($response) as $key1) {
        foreach (array_keys($response[$key1]) as $key2) {
            if ($key2 == "user_name") {
                $response[$key1][$key2] = getNameFromId($response[$key1][$key2]);
            }
        }
    }

    $wrapArr = array(
        "Sessions" => $response
    );

    echo json_encode($wrapArr, JSON_PRETTY_PRINT);
}

function getTopLastWeek_switch() {

    $response = getTopLastWeek_query();

    foreach (array_keys($response) as $key1) {
        foreach (array_keys($response[$key1]) as $key2) {
            if ($key2 == "user_name") {
                $response[$key1][$key2] = getNameFromId($response[$key1][$key2]);
            }
        }
    }

    $wrapArr = array(
        "Sessions" => $response
    );

    echo json_encode($wrapArr, JSON_PRETTY_PRINT);
}

function setNewUserName_switch($userId, $userName, $uuid) {

    $validUser = checkUser_query($userId, $uuid);

    if ($validUser) {
        if (setNewUserName_query($userId, $userName)) {
            echo json_encode(array(
                'status' => "1",
                'output' => "success",
            ));
            return;
        }
    }
    echo json_encode(array(
        'status' => "0",
        'output' => "failure",
    ));
    return;
}
