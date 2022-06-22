<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $clients_page = new Template("design/employees.html");
    $employe_table = new Template("design/employees-table.html");

    $stmt = $connection->query("SELECT * FROM dipendenti");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $employe_table->setContent($key, $value);
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
                                                WHERE utentiGruppi.idGruppo = 2");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);



    $clients_page->setContent("employeesTable", $employe_table->get());
    $main->setContent("employees", $clients_page->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
