<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $services_page = new Template("design/services.html");
    $services_table = new Template("design/service-table.html");


    // query per selezionare servizi offerti e passarli alla tabella grafica
    $stmt = $connection->query("SELECT attivita.idAttivita, attivita.idCategoria, attivita.nomeAttivita, 
                                                attivita.descrizioneAttivita, attivita.prezzoAttivita, 
                                                categoriaAttivita.idCategoria, categoriaAttivita.nomeCategoria
                                        FROM attivita
                                        LEFT JOIN categoriaAttivita
                                        ON attivita.idCategoria = categoriaAttivita.idCategoria");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $services_table->setContent($key, $value);
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



    $services_page->setContent("servicesTable", $services_table->get());
    $main->setContent("services", $services_page->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
