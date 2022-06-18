<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");



    // pagina principale: index.html
    $main = new Template("design/index.html");

    $stmt = $connection->query("SELECT path, idImmagine FROM immagini WHERE idImmagine=1");

    if (!$stmt) {

        // errore
    }

    $data = $stmt->fetch_assoc();

    foreach ($data as $key => $value) {
        $main->setContent($key, $value);
    }

    // sezione carosello: carosello.html
    $carosel = new Template("design/carosello.html");

    // NON RIESCO A FARE LA QUERY PER ESTRAPOLARE TUTTE TRE LE IMAGES CHE POI DEVO PASSARE NELLA GRAFICA

    // DEVO DISTINGUERE LE SLIDE IN BASE ALLA CLASSE active

    /*

        $stmt = $connection->query("SELECT slider.idImmagine, slider.idPosition, slider.titolo, slider.testo,
                                            immagini.idImmagine, immagini.path FROM slider
                                            LEFT JOIN immagini
                                            ON slider.idImmagine = immagini.idImmagine
                                            WHERE immagini.idImmagine=4");

        if (!$stmt) {

            // errore
        }

        $data = $stmt->num_rows;


         do {

                $data = $stmt->fetch_assoc();
                if ($data){
                    foreach ($data as $key => $value) {
                        echo "{$key} => {$value}";
                        print_r($data);
                    }
                }
            } while ($data);

    */









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

    $stmt = $connection->query("SELECT galleria.idImmagine, immagini.idImmagine, immagini.path
                                        FROM galleria 
                                        LEFT JOIN immagini
                                        ON galleria.idImmagine = immagini.idImmagine");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $gallery->setContent($key, $value);
            }
        }
    } while ($data);



    // sezione team: team.html
    $team = new Template("design/team.html");

    $stmt = $connection->query("SELECT immagini.idImmagine, immagini.path, dipendenti.idImmagine 
                                        FROM immagini
                                        LEFT JOIN dipendenti
                                        ON immagini.idImmagine = dipendenti.idImmagine
                                        WHERE immagini.idImmagine = dipendenti.idImmagine");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $team->setContent($key, $value);
            }
        }
    } while ($data);

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
