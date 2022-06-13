<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $service_category = new Template("design/service-category.html");

    $main->setContent("service_category", $service_category->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();



?>
