<?php

require ("include/template2.inc.php");
require ("include/dbms.inc.php");
require ("include/session-start.php");


    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    $error_page = new Template("design/error-page.html");


    $error_page->setContent("errorAlert", "<div class=\"alert alert-danger\">
                                                          <p>Prenotazione non avvenuta</p>
                                                       </div>");





    $footer = new Template("design/footer.html");


    $main->setContent("errorPage", $error_page->get());
    $main->setContent("footer", $footer->get());
    $main->close();

?>