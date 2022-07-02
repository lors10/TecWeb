<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");
    require ("include/session-start.php");


    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    $success_page = new Template("design/success-page.html");


    $success_page->setContent("successAlert", "<div class=\"alert alert-success\">
                                                            <p>Prenotazione avvenuta con successo</p>
                                                          </div>");





    $footer = new Template("design/footer.html");


    $main->setContent("successPage", $success_page->get());
    $main->setContent("footer", $footer->get());
    $main->close();

?>