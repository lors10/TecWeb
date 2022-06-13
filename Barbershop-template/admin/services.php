<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");


    $services_page = new Template("design/services.html");

    $main->setContent("services", $services_page->get());


    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
