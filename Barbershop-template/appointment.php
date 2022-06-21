<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");
    require ("include/session-start.php");

    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];


    $appointment = new Template("design/appuntamento-form.html");


    $footer = new Template("design/footer.html");


    //$main->setContent("navbar", $navbar->get());
    $main->setContent("appuntamentoForm", $appointment->get());
    $main->setContent("footer", $footer->get());

    $main->close();

?>