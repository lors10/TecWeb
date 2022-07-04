<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    error_reporting(0);

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    // controllo se l'utente (admin / cliente) ha l'accesso a questa pagina
    $stmt = "SELECT servizi.idServizio, servizi.script,
                        gruppiServizi.idServizio, gruppiServizi.idGruppo, gruppi.idGruppo
                        FROM servizi
                        LEFT JOIN gruppiServizi
                        ON servizi.idServizio = gruppiServizi.idServizio
                        LEFT JOIN gruppi
                        ON gruppiServizi.idGruppo = gruppi.idGruppo
                        WHERE servizi.script = '{$_SERVER['SCRIPT_NAME']}' AND gruppiServizi.idgruppo = {$log}";


    if ($connection->query($stmt) == 1) {

        // Query ok

    } else {

        // check errore
        echo "Errore: " . $stmt . '<br />' . $connection->connect_error;

    }


    $permission = $connection->query($stmt)->num_rows;


    if (intval($permission) == 0) {

        // accesso negato
        echo "Non hai il permesso";
        exit();

    } else {

        // accesso consentito
    }
    // fine controllo accesso

    $add_gallery_image = new Template("design/images-add-gallery.html");

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

                    $add_gallery_image->setContent($key,$value);
                }
            }

            break;

        case 1:

            // query per aggiungere un'immagine
            // notifica di aggiunta

            $query = "INSERT into galleria (idImmagine)
                            VALUES ({$_REQUEST['slider_id']})";

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
                                                /*WHERE utentiGruppi.idGruppo = 2*/");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);


    $main->setContent("add_gallery_images", $add_gallery_image->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
