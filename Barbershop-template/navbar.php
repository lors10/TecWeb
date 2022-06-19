<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");
    require ("include/session-start.php");

    $navbar = new Template("design/navbar.html");

    if ($_SESSION['id'] != 0) {

        $navbar->setContent("logoutButton", "<div class=\"header-btn\">
                                                                <a href=\"logout.php\" class=\"menu-btn\">Logout</a>
                                                            </div>");
    } else {

        $navbar->setContent("loginButton", "<div class=\"header-btn\">
                                                                <a href=\"login.php\" class=\"menu-btn\">Login</a>
                                                            </div>");
    }


    $navbar->close();

?>