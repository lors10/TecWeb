<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");

    $stmt = $connection->query("SELECT * FROM attivita");

        if (!$stmt){

            // error
        }

        $data = $stmt->num_rows;


        $main->setContent("serviceCount", $data);
        $main->setContent("loggedUser", $_SESSION['name']);
        $main->close();

?>