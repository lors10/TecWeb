<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $appointment = new Template("design/appointments.html");

    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;


    $main->setContent("appointment", $appointment->get());
    $main->setContent("serviceCount", $serviceCount);
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
