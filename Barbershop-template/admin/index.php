<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");


    // query per conteggio dei clienti del sito
    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                        utentiGruppi.idUtente, utentiGruppi.idGruppo
                                        FROM utenti
                                        LEFT JOIN utentiGruppi
                                        ON utenti.idUtente = utentiGruppi.idUtente
                                        /*WHERE utentiGruppi.idGruppo = 2*/");

    $data = $stmt->num_rows;

    $main->setContent("clientsCount", $data);



    // query per conteggio servizi
    $stmt = $connection->query("SELECT * FROM attivita");

    $data = $stmt->num_rows;

    $main->setContent("serviceCount", $data);


    // query per conteggio dei dipendenti
    $stmt = $connection->query("SELECT * FROM dipendenti");

    $data = $stmt->num_rows;

    $main->setContent("employeesCount", $data);


    // query per conteggio degli appuntamenti
    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);


    // placeholder per restituire il nome dell'admin
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>