<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getSemester($date) {
    require 'connectfile.php';
    //check and see if the event/semester is open for submitting entries
    $getSemester = "SELECT * FROM events "
            . "WHERE CURDATE() BETWEEN start_date AND end_date;";
    $getSemesterStatement = $db->query($getSemester);
    $getSemesterStatement->setFetchMode(PDO::FETCH_ASSOC);
    $semester = $getSemesterStatement->fetch();
    //if the query returns nothing
    if ($semester == null) {
        //there is no ironman compitition currently in progress
        return '{"code":1, "message": "Currently there is no ironman competition in progress. '
                . 'Check with the activities office to find out when the next one starts!"}';
        //if the date they are trying to submit for is outside of the current semesters open period
    } else if ($date < $semester['start_date'] || $date > $semester['end_date']) {
        //tell them!
        return '{"code":1, "message": "Your entry date is invalid for ' . $semester['semester'] . '."}';
    } else
        return $semester;
}

// becasue this file returns both json or a reqular string I included a function to tell 
// if a string is json or not.
function isJson($string) {
    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
}
