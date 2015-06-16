<?php

require 'connectfile.php';

$semester = $_POST['semester'];
$id = $_POST["id"];

try {

    $query = "select * from entries e
 inner join contestants c
 on e.fk_contestants = c.pk_contestants_id
 inner join events ev
 on e.fk_events = ev.pk_events_id
 inner join mode m
 on e.fk_mode = m.pk_mode_id
 WHERE c.pk_contestants_id= '" . $id . "'
 AND ev.semester = '" . $semester . "'";
    $stmt = $db->query($query);
    $rows = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }

    echo json_encode($rows);
} catch (PDOEXCEPTION $ex) {
    echo "something bad!";
}
?>