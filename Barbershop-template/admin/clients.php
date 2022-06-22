<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");


    $main = new Template("design/index.html");
    $clients_page = new Template("design/clients.html");
    $clients_table = new Template("design/clients-table.html");



    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                        utentiGruppi.idUtente, utentiGruppi.idGruppo
                                        FROM utenti
                                        LEFT JOIN utentiGruppi
                                        ON utenti.idUtente = utentiGruppi.idUtente
                                        WHERE utentiGruppi.idGruppo = 2");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $clients_table->setContent($key, $value);
            }
        }
    } while ($data);

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);




    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;

    $main->setContent("serviceCount", $serviceCount);


    $stmt = $connection->query("SELECT * FROM dipendenti");

    $employeesCount = $stmt->num_rows;

    $main->setContent("employeesCount", $employeesCount);


    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);


    $clients_page->setContent("clientsTable", $clients_table->get());
    $main->setContent("clients", $clients_page->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
