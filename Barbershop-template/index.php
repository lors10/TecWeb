<?php

    require ("include/template2.inc.php");



    // pagina principale: index.html
    $main = new Template("design/index.html");

    // sezione carosello: carosello.html
    $carosel = new Template("design/carosello.html");

    // sezione servizi: servizi.html
    $services = new Template("design/servizi.html");

    // sezione appuntamento: appuntamento.html
    $appointment = new Template("design/appuntamento.html");

    // sezione galleria: galleria.html
    $gallery = new Template("design/galleria.html");

    // sezione team: team.html
    $team = new Template("design/team.html");

    // sezione prezzi: prezzi.html
    $prices = new Template("design/prezzi.html");



    $main->setContent("carosello", $carosel->get());
    $main->setContent("servizi", $services->get());
    $main->setContent("appuntamento", $appointment->get());
    $main->setContent("galleria", $gallery->get());
    $main->setContent("squadra", $team->get());
    $main->setContent("prezzi", $prices->get());


    $main->close();

?>
