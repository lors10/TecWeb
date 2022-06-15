<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");



    // pagina principale: index.html
    $main = new Template("design/index.html");

    // sezione carosello: carosello.html
    $carosel = new Template("design/carosello.html");

    // sezione servizi: servizi.html
    $services = new Template("design/servizi.html");

    $stmt = $connection->query("SELECT nomeAttivita, descrizioneAttivita FROM attivita WHERE prezzoAttivita <= 15");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $services->setContent($key, $value);
            }
        }
    } while ($data);

    // sezione appuntamento: appuntamento.html
    $appointment = new Template("design/appuntamento.html");

    // sezione galleria: galleria.html
    $gallery = new Template("design/galleria.html");

    // sezione team: team.html
    $team = new Template("design/team.html");

    // sezione prezzi: prezzi.html
    $prices = new Template("design/prezzi.html");

    /*
    $stmt = $connection->query("SELECT categoriaAttivita.idCategoria, categoriaAttivita.nomeCategoria, 
                                                attivita.idCategoria, attivita.nomeAttivita, attivita.descrizioneAttivita, attivita.prezzoAttivita
                                                  FROM categoriaAttivita
                                                  LEFT JOIN attivita
                                                  ON categoriaAttivita.idCategoria = attivita.idCategoria");

    */

    $stmt = $connection->query("SELECT * FROM attivita LEFT JOIN categoriaAttivita ON attivita.idCategoria = categoriaAttivita.idCategoria");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $prices->setContent($key, $value);
            }
        }
    } while ($data);


    $main->setContent("carosello", $carosel->get());
    $main->setContent("servizi", $services->get());
    $main->setContent("appuntamento", $appointment->get());
    $main->setContent("galleria", $gallery->get());
    $main->setContent("squadra", $team->get());
    $main->setContent("prezzi", $prices->get());


    $main->close();

?>
