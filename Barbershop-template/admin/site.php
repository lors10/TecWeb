<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");


    $site_page = new Template("design/web-site.html");

    $main->setContent("site", $site_page->get());


    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
