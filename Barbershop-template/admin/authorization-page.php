<?php


    require("../include/template2.inc.php");
    require("../include/dbms.inc.php");


    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("../design/index.html");


    $error_page = new Template("design/authorization-page.html");


    $error_page->setContent("errorAuth", "<div class=\"alert alert-danger\">
                                                                  <p>Prenotazione non avvenuta</p>
                                                               </div>");





    $main->setContent("errorPage", $error_page->get());
    $main->close();


?>
