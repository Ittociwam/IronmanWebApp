<?php
/*
 * This file will handle a new iron man event entry. Only the admins should be able to use this
 * 
 */
require 'connectfile.php';
try {
    $semester = $_GET['season'] . $_GET['year'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    //YOU ARE HERE!

    $query = "INSERT INTO events (semester, start_date, end_date)
 VALUES(:semester, :start_date, :end_date);";


    $statement = $db->prepare($query);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':start_date', $start_date);
    $statement->bindValue(':end_date', $end_date);
    $message = "";
    if ($statement->execute()) {
        $message = "Successfully inserted: " . $semester . " with a start date of " . $start_date . " and an end date of " . $end_date;
    }
} catch (PDOEXCEPTION $ex) {
    echo $ex;
    $message = "Event not submitted. Perhaps it alredy exists.";
}
?>
<!DOCTYPE html>
<html>
    <body>
        <h3><?php echo $message ?></h3>
        <a href="index.php"> <button>Return to home page.</button></a>
    </body>
</html>
