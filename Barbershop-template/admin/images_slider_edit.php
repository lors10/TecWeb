<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $edit_slider = new Template("design/images-edit-slider.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form

            // estrapolo informazioni Immagine
            $stmt = $connection->query("SELECT slider.idImmagine, slider.idPosition, slider.titolo, slider.testo,
                                                      immagini.idImmagine
                                                      FROM slider
                                                      LEFT JOIN immagini
                                                      ON slider.idImmagine = immagini.idImmagine
                                                      WHERE slider.idImmagine = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $edit_slider->setContent($key,$value);
                }
            }

            break;

        case 1:


            // modificare i dati della tabella
            // notifica
            // tornare alla home immagini

            $stmt = $connection->query("UPDATE slider SET 
                                                        idPosition = \"{$_REQUEST['slider_position_update']}\",
                                                        titolo = \"{$_REQUEST['slider_title_update']}\",
                                                        testo = \"{$_REQUEST['slider_body_update']}\"
                                                        WHERE idImmagine = {$_REQUEST['image_id']}");

            if ($stmt == 1) {

                echo "Slider aggiunta con successo!";

                header("Location: images.php");
            } else {

                // check errore
                echo "Errore: " . $stmt . '<br />' . $connection->connect_error;
            }

            break;
    }


    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;

    $main->setContent("serviceCount", $serviceCount);



    $stmt = $connection->query("SELECT * FROM dipendenti");

    $employeesCount = $stmt->num_rows;

    $main->setContent("employeesCount", $employeesCount);


    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                                    utentiGruppi.idUtente, utentiGruppi.idGruppo
                                                    FROM utenti
                                                    LEFT JOIN utentiGruppi
                                                    ON utenti.idUtente = utentiGruppi.idUtente
                                                    /*WHERE utentiGruppi.idGruppo = 2*/");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);



    $main->setContent("edit_slider", $edit_slider->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
