<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    $service_category = new Template("design/service-category.html");
    $service_category_table = new Template("design/service-category-table.html");


    // seleziono le categorie di servizi per poi passarle nella tabella grafica
    $stmt = $connection->query("SELECT * FROM categoriaAttivita");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $service_category_table->setContent($key, $value);
            }
        }
    } while ($data);


    // query per conteggio servizi
    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;

    $main->setContent("serviceCount", $serviceCount);


    // query per conteggio staff
    $stmt = $connection->query("SELECT * FROM dipendenti");

    $employeesCount = $stmt->num_rows;

    $main->setContent("employeesCount", $employeesCount);



    // query per conteggio appuntamenti
    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);


    // query per conteggio dei clienti totali
    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                        utentiGruppi.idUtente, utentiGruppi.idGruppo
                                        FROM utenti
                                        LEFT JOIN utentiGruppi
                                        ON utenti.idUtente = utentiGruppi.idUtente
                                        /*WHERE utentiGruppi.idGruppo = 2*/");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);


    $service_category->setContent("service_category_table", $service_category_table->get());
    $main->setContent("service_category", $service_category->get());
    // placeholder per nome admin
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();



?>
