<?php

function getContestants($semester) {
    require 'connectfile.php';
    if (!is_array($semester)) {
        try {
            $query = "SELECT c.pk_contestants_id, c.u_name, c.register_date, (sum(en.distance) / 223) as percentage
 FROM entries en
 INNER JOIN events e
 ON en.fk_events = e.pk_events_id
 INNER JOIN contestants c
 ON c.pk_contestants_id = en.fk_contestants
 WHERE e.semester = '" . $semester . "'
 AND en.fk_events = (SELECT pk_events_id from events where semester = '" . $semester . "')
 group by c.u_name, c.register_date;";

            $stmt = $db->query($query);
            $rows = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }

            return json_encode($rows);
        } catch (PDOEXCEPTION $ex) {
            return "something bad!";
        }
    }
}

if (isset($_POST['semester'])) {
    $semester = $_POST['semester'];
    echo getContestants($semester);
}

?>