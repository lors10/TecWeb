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

    $images_edit = new Template("design/images-edit.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }

    switch ($_REQUEST['state']) {

        case 0:

            // estraggo i dati della tabella immagini
            $stmt = $connection->query("SELECT idImmagine, path, alt 
                                                    FROM immagini
                                                    WHERE idImmagine = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $images_edit->setContent($key,$value);
                }
            }

            break;

        case 1:

            // modificare i dati della tabella
            // notifica
            // tornare alla home immagini

            $stmt = $connection->query("UPDATE immagini SET 
                                                        path = \"{$_REQUEST['image_path_update']}\",
                                                        alt = \"{$_REQUEST['image_alt_update']}\"
                                                        WHERE idImmagine = {$_REQUEST['image_id']}");

            if ($stmt == 1) {

                echo "Categoria aggiunta con successo!";

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



    $main->setContent("edit_images", $images_edit->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>