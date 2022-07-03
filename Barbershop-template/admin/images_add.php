<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    $add_images = new Template("design/images-add.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }

    switch ($_REQUEST['state']) {

        case 0:

            // emissione form


            break;

        case 1:

            // query per aggiungere un'immagine
            // notifica di aggiunta

            /*

                $query = "INSERT into attivita (idAttivita, idCategoria, nomeAttivita, descrizioneAttivita, prezzoAttivita)
                                VALUES (NULL, {$_REQUEST['service_category']}, '{$_REQUEST['service_name']}', '{$_REQUEST['service_description']}', {$_REQUEST['service_price']})";

                if ($connection->query($query) == 1) {

                    echo "Categoria aggiunta con successo!";

                    header("Location: services.php");
                } else {

                    // check errore
                    echo "Errore: " . $query . '<br />' . $connection->connect_error;
                }

            */

            $query = "INSERT into immagini (idImmagine, path, alt)
                            VALUES (NULL, '{$_REQUEST['image_path']}', '{$_REQUEST['image_alt']}')";

            if ($connection->query($query) == 1) {

                echo "Immagine aggiunta con successo!";

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


    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);



    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                            utentiGruppi.idUtente, utentiGruppi.idGruppo
                                            FROM utenti
                                            LEFT JOIN utentiGruppi
                                            ON utenti.idUtente = utentiGruppi.idUtente
                                            /*WHERE utentiGruppi.idGruppo = 2*/");

    $employeesCount = $stmt->num_rows;

    $main->setContent("clientsCount", $employeesCount);


    $main->setContent("add_images", $add_images->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
