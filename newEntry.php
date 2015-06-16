<?php

/*
 * This file will handle a new iron man entry.
 * 
 */
define('BIKE_MILES', 112.0);
define('RUN_MILES', 26.0);
define('SWIM_LAPS', 85.0);

define('BIKE', 1); // these are the codes that the modes are stored as in the database
define('RUN', 2);
define('SWIM', 3);

function validateDistance(&$message, $distance, $totalDistance, $mode, $modeMiles){
    //echo "distance: $distance Totaldistance: $totalDistance ";
    if($totalDistance == null){
        $totalDistance = 0.0;
    }
    if($modeMiles - $totalDistance > 0.0 && $totalDistance + $distance >= $modeMiles){ // if they still have more to go but this entry will put them over
        $a = $modeMiles - $totalDistance;
        //echo "totalDistance: $totalDistance, modeMiles: $modeMiles,  modeMiles - totalDistance: $a";
        $message = '{"code":1, "message": "Congrats! You are all finished with '. $mode . '"}'; // notify them and
        return $modeMiles - $totalDistance;  // return the remaining distance they have so they don't go over
    }
    else if($totalDistance >= $modeMiles){ // otherwise if they have already finished
        $message = '{"code":1, "message": "You have already finished with '. $mode . $totalDistance.'"}'; // notify them and
        return 0.0; // return 0 so the system knows not to insert it as an entry
    }
    
    else
        return $distance; // if all is well just return the distance so that distance will stay the same. 
}

function checkIsFinished(&$message, $user, $modeNum, $semester, $distance){ // message is by reference so we can alter it at any moment
    require 'connectfile.php'; 
    //echo "user: $user modenum: $modeNum semester: $semester distance: $distance";

$query = "SELECT SUM(e.distance) as totalDistance 
    FROM contestants c
    INNER JOIN entries e
    ON e.fk_contestants = c.pk_contestants_id
    INNER JOIN events ev
    ON ev.pk_events_id = e.fk_events
    WHERE pk_contestants_id = :userId
    AND e.fk_mode = :modeId
    AND ev.semester = :semester
    GROUP BY e.fk_mode;";

    $stmt = $db->prepare($query); // this query will add up all the distance in the given miles. 

    $stmt->bindValue(":userId", $user);
    $stmt->bindValue(":modeId", $modeNum);
    $stmt->bindValue(":semester", $semester);

    $stmt->execute();

    $row = $stmt->fetch();

    $totalDistance = $row['totalDistance'];


    switch ($modeNum) { // determine the mode and check if the user will go over with this entry or if they are already over. 
        case BIKE:
        $distance = validateDistance($message, $distance, $totalDistance, "biking", BIKE_MILES);
        break;
        case RUN:
        $distance = validateDistance($message, $distance, $totalDistance, "running", RUN_MILES);
        break; // we assign whatever validateDistance() returns to distance becasue if this entry will put them over, it will return the amount they 
        case SWIM: // have left to complete so that they won't go over 100%
        $distance = validateDistance($message, $distance, $totalDistance, "swimming", SWIM_LAPS);
        break;
        default:
        $message = '{"code":1, "message": "There was an error with your mode type"}';
    }
    return $distance;
}

require 'connectfile.php';
require 'getSemester.php';


try {
    $mode = $_GET['mode'];
    $distance = $_GET['distance'];
    $date = $_GET['date'];
    $user = $_GET['user'];

    $message = '{"code" : 0, "message": "Good Job! You are well on your way to being an ironman champion!"}';

    $semester = @getSemester($date);
    if(isJson($semester)){
       $message = $semester; // if get semester returns json, it's an error message. display it.  
    }
    else {

        $pk_events_id = $semester['pk_events_id']; // pull out the event_id from the semester row.

        // check if the user has a registration for the event they are submitting for
        $checkRegistration = "SELECT * from registration as r"
        ."INNER JOIN contestants as c "
        ."ON pk_contestants_id = fk_contestants "
        ."WHERE pk_contestants_id = :user "
        ."AND fk_events = :pkevents ";

        //$checkRegistrationStatement = $db->query($checkRegistration);
        $checkRegistrationStatement = $db->prepare($checkRegistration);
        $checkRegistrationStatement->bindValue(':user', $user);
        $checkRegistrationStatement->bindValue(':pkevents', $pk_events_id);
        $checkRegistrationStatement->execute();
        $checkRegistrationStatement->setFetchMode(PDO::FETCH_ASSOC);
        $registration = $checkRegistrationStatement->fetch();

        // if they don't, register them for it!
        if ($registration == null) {
            $insertRegistration = "INSERT INTO registration(fk_contestants, fk_events)"
            . "VALUES(:user, :event)";
            $regStatement = $db->prepare($insertRegistration);
            $regStatement->bindValue(':user', $user);
            $regStatement->bindValue(':event', $pk_events_id);

            $regStatement->execute();
        }

        // get the correct mode id for the mode they entered
        // move this to javascript when you get time
        $modeNum = 0;
        switch ($mode) {
            case "Bike":
            $modeNum = BIKE;
            break;
            case "Run":
            $modeNum = RUN;
            break;
            case "Swim":
            $modeNum = SWIM;
            break;
        }

        //if the entry will put the user over or if they are already over, return a message that says you are finished with 'MODE'
        $distance = checkIsFinished($message, $user, $modeNum, $semester['semester'], $distance);
        if($distance != 0.0){ // if the distance has returned 0, they have already finished this mode. Don't insert becasue we can't have 
        // entries go over 100%.

        // go ahead and bulid the query
            $query = "INSERT INTO entries (entry_date, distance, fk_events, fk_contestants, fk_mode)
            VALUES(:date, :distance, :semester, :user, :modeNum);";


            $statement = $db->prepare($query);
            $statement->bindValue(':date', $date);
            $statement->bindValue(':distance', $distance);
            $statement->bindValue(':semester', $semester['pk_events_id']);
            $statement->bindValue(':user', $user);
            $statement->bindValue(':modeNum', $modeNum);
            $statement->execute(); // we made it! send the entry!

        }
        echo $message; // echo whatever message we have assigned as json so it can be parsed.
    }
} catch (PDOEXCEPTION $ex) {
    echo '{"code":1, "message": "There was an error in the database: "' . $ex . '"';
}
?>
