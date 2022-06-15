<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $images = new Template("design/images.html");

    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;


    $main->setContent("images", $images->get());
    $main->setContent("serviceCount", $serviceCount);
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>