<?php

    // modificare appuntamento
    // creare pagina con due form
    // - per modificare appuntamento
    // - per annullare appuntamento


    // modifica appuntamento
    // - servizio
    // - data e slot temporale
    // quindi modifica in tabelle appuntamento e prenotazione


    // annullamento appuntamento
    // - indicare motivo di annullamento
    // quindi modifica in tabella appuntamento


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    error_reporting(0);

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    // controllo per verificare che utente (admin / cliente) abbia il permesso per accedere a questa pagina
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


    if ($connection->query($stmt)->num_rows == 0) {

        // accesso negato
        echo "Non hai l'accesso";
        exit();

    } else {

        // accesso consentito
    }
    // controllo terminato

    // pagina generale per modificare appuntamento
    $edit_appointment = new Template("design/appointments-edit.html");

    // pagina con form per modificare appuntamento (modifica data e/o ora)
    $update_appointment = new Template("design/appointments-update.html");

    // pagina con form per annullare appuntamento (definire motivo annullamento appuntamento)
    $cancel_appointment = new Template("design/appointments-cancel.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // estraggo i dati delle tabelle appuntamento e prenotazione per passarli alla form modifica appuntamento

            $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento,
                                                     appuntamento.inizioTempoAppuntamento, appuntamento.idUtente,
                                                     prenotazione.idAppuntamento, prenotazione.idAttivita,
                                                     attivita.idAttivita, attivita.nomeAttivita
                                                     FROM appuntamento
                                                     INNER JOIN prenotazione
                                                     ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                                     INNER JOIN attivita
                                                     ON prenotazione.idAttivita = attivita.idAttivita
                                                     WHERE appuntamento.idAppuntamento = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $update_appointment->setContent($key,$value);
                }
            }


            // estraggo i dati delle tabelle appuntamento e prenotazione per passarli alla form annulla appuntamento

            $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento,
                                                     appuntamento.inizioTempoAppuntamento, appuntamento.idUtente,
                                                     prenotazione.idAppuntamento, prenotazione.idAttivita,
                                                     attivita.idAttivita, attivita.nomeAttivita
                                                     FROM appuntamento
                                                     INNER JOIN prenotazione
                                                     ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                                     INNER JOIN attivita
                                                     ON prenotazione.idAttivita = attivita.idAttivita
                                                     WHERE appuntamento.idAppuntamento = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $cancel_appointment->setContent($key,$value);
                }
            }

            break;


        case 1:

            $stmt = $connection->query("UPDATE appuntamento SET 
                                                            inizioDataAppuntamento = \"{$_REQUEST['appointment_date_update']}\",
                                                            inizioTempoAppuntamento = \"{$_REQUEST['selected_time_slot_update']}\"
                                                            WHERE idAppuntamento = {$_REQUEST['appointment_id_update']}");

            if ($stmt == 1) {


                header("Location: appointment.php");
            } else {

                // check errore
                echo "Errore: " . $stmt . '<br />' . $connection->connect_error;
            }

            $stmt = $connection->query("UPDATE appuntamento SET 
                                                            cancellazione = 1,
                                                            ragioneCancellazione = \"{$_REQUEST['appointment_cancel']}\"
                                                            WHERE idAppuntamento = {$_REQUEST['appointment_id_cancel']}");

            if ($stmt == 1) {


                header("Location: appointment.php");
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



    $edit_appointment->setContent("updateAppointment", $update_appointment->get());
    $edit_appointment->setContent("cancelAppointment", $cancel_appointment->get());
    $main->setContent("editAppointment", $edit_appointment->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
