<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $add_slider = new Template("design/images-add-slider.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form

            // estrapolo id Immagine
            $stmt = $connection->query("SELECT idImmagine, alt FROM immagini");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $add_slider->setContent($key,$value);
                }
            }

            break;

        case 1:


            // query per aggiungere un servizio
            // notifica di aggiunta


            $query = "INSERT into slider (idImmagine, idPosition, titolo, testo)
                            VALUES ({$_REQUEST['slider_id']}, {$_REQUEST['slider_position']}, 
                                        '{$_REQUEST['slider_title']}', '{$_REQUEST['slider_body']}')";

            if ($connection->query($query) == 1) {

                echo "Categoria aggiunta con successo!";

                header("Location: images.php");
            } else {

                // check errore
                echo "Errore: " . $query . '<br />' . $connection->connect_error;
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
                                                WHERE utentiGruppi.idGruppo = 2");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);



    $main->setContent("add_slider", $add_slider->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
