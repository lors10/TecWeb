<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

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

    $edit_service = new Template("design/service-edit.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form

            // estrapolo categorie di servizi
            $stmt = $connection->query("SELECT attivita.idAttivita, attivita.idCategoria, attivita.nomeAttivita, 
                                                      attivita.descrizioneAttivita, attivita.prezzoAttivita,
                                                      categoriaAttivita.idCategoria, categoriaAttivita.nomeCategoria
                                                        FROM attivita
                                                        LEFT JOIN categoriaAttivita
                                                        ON attivita.idCategoria = categoriaAttivita.idCategoria
                                                        WHERE attivita.idAttivita = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $edit_service->setContent($key,$value);
                }
            }

            break;

        case 1:

            // modificare i dati della tabella
            // notifica
            // tornare alla home

            $stmt = $connection->query("UPDATE attivita SET 
                                                    nomeAttivita = \"{$_REQUEST['service_name_update']}\",
                                                    descrizioneAttivita = \"{$_REQUEST['service_description_update']}\",
                                                    prezzoAttivita = \"{$_REQUEST['service_price_update']}\"
                                                    WHERE idAttivita = {$_REQUEST['service_id']}");

            if ($stmt == 1) {

                echo "Attivita' aggiunta con successo!";

                header("Location: services.php");
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

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);


    $main->setContent("edit_service", $edit_service->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>