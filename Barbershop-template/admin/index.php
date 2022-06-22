<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");



    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                        utentiGruppi.idUtente, utentiGruppi.idGruppo
                                        FROM utenti
                                        LEFT JOIN utentiGruppi
                                        ON utenti.idUtente = utentiGruppi.idUtente
                                        WHERE utentiGruppi.idGruppo = 2");

    $data = $stmt->num_rows;

    $main->setContent("clientsCount", $data);




    $stmt = $connection->query("SELECT * FROM attivita");

    $data = $stmt->num_rows;

    $main->setContent("serviceCount", $data);



    $stmt = $connection->query("SELECT * FROM dipendenti");

    $data = $stmt->num_rows;

    $main->setContent("employeesCount", $data);


    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);



    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>