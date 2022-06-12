<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");


    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>