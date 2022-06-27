<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $appointment = new Template("design/appointments.html");
    $next_appointment_table = new Template("design/appointments-next-table.html");

    $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento, appuntamento.inizioTempoAppuntamento, appuntamento.idUtente,
                                                 prenotazione.idAppuntamento, prenotazione.idAttivita,
                                                 attivita.idAttivita, attivita.nomeAttivita
                                                 FROM appuntamento
                                                 INNER JOIN prenotazione
                                                 ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                                 INNER JOIN attivita
                                                 ON prenotazione.idAttivita = attivita.idAttivita
                                                 WHERE appuntamento.inizioDataAppuntamento >= current_date");

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

    $all_appointment_table = new Template("design/appointments-all-table.html");

    // query per estrapolare dati di:
    // - appuntamento
    // - utente
    // - servizio (attivita)

    $stmt = $connection->query("SELECT appuntamento.idAppuntamento, appuntamento.inizioDataAppuntamento, appuntamento.inizioTempoAppuntamento, appuntamento.idUtente,
                                             prenotazione.idAppuntamento, prenotazione.idAttivita,
                                             attivita.idAttivita, attivita.nomeAttivita
                                             FROM appuntamento
                                             INNER JOIN prenotazione
                                             ON appuntamento.idAppuntamento = prenotazione.idAppuntamento
                                             INNER JOIN attivita
                                             ON prenotazione.idAttivita = attivita.idAttivita
                                             /*WHERE appuntamento.inizioAppuntamento >= current_date*/");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $all_appointment_table->setContent($key, $value);
            }
        }
    } while ($data);



    $cancelled_appointment_table = new Template("design/appointments-cancelled-table.html");

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
                                                WHERE utentiGruppi.idGruppo = 2");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);


    $appointment->setContent("appointmentNexttable", $next_appointment_table->get());
    $appointment->setContent("appointmentAlltable", $all_appointment_table->get());
    $appointment->setContent("appointmentCancelledtable", $cancelled_appointment_table->get());
    $main->setContent("appointment", $appointment->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
