<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");


    $edit_service = new Template("design/service-edit.html");


    $main->setContent("edit_service", $edit_service->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>