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

    $appointment = new Template("design/appointments.html");
    $next_appointment_table = new Template("design/appointments-next-table.html");


    // query per estrarre info su prossimi appuntamenti e inserirli nella tabella apposita
    $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento, 
                                                 appuntamento.inizioTempoAppuntamento, appuntamento.idUtente, appuntamento.cancellazione,
                                                 prenotazione.idAppuntamento, prenotazione.idAttivita,
                                                 attivita.idAttivita, attivita.nomeAttivita
                                                 FROM appuntamento
                                                 INNER JOIN prenotazione
                                                 ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                                 INNER JOIN attivita
                                                 ON prenotazione.idAttivita = attivita.idAttivita
                                                 WHERE appuntamento.inizioDataAppuntamento >= current_date AND appuntamento.cancellazione = 0 
                                                 ORDER BY appuntamento.idUtente, appuntamento.inizioTempoAppuntamento");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $next_appointment_table->setContent($key, $value);
            }
        }
    } while ($data);

    $old_appointment_table = new Template("design/appointments-old-table.html");

    // query per estrapolare dati di:
    // - appuntamento
    // - utente
    // - servizio (attivita)
    // query che permette di vedere tutti gli appuntamenti

    $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento, appuntamento.inizioTempoAppuntamento, appuntamento.idUtente,
                                             prenotazione.idAppuntamento, prenotazione.idAttivita,
                                             attivita.idAttivita, attivita.nomeAttivita
                                             FROM appuntamento
                                             INNER JOIN prenotazione
                                             ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                             INNER JOIN attivita
                                             ON prenotazione.idAttivita = attivita.idAttivita
                                             WHERE appuntamento.inizioDataAppuntamento < current_date");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $old_appointment_table->setContent($key, $value);
            }
        }
    } while ($data);





    $cancelled_appointment_table = new Template("design/appointments-cancelled-table.html");

    // manca query per vedere tutti gli appuntamenti annullati

    $stmt = $connection->query("SELECT * FROM appuntamento WHERE cancellazione = 1");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $cancelled_appointment_table->setContent($key, $value);
            }
        }
    } while ($data);







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


    $appointment->setContent("appointmentNexttable", $next_appointment_table->get());
    $appointment->setContent("appointmentAlltable", $old_appointment_table->get());
    $appointment->setContent("appointmentCancelledtable", $cancelled_appointment_table->get());
    $main->setContent("appointment", $appointment->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
