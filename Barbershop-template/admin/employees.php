<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");


    $clients_page = new Template("design/employees.html");

    $main->setContent("employees", $clients_page->get());


    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
