<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");


    $add_service = new Template("design/service-add.html");


    $main->setContent("add_service", $add_service->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>