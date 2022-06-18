<?php

    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $settingUser = new Template("design/setting-user.html");


    $query = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente,
                                        utentiGruppi.idUtente, utentiGruppi.idGruppo,
                                        gruppi.idGruppo, gruppi.nomeGruppo, gruppi.descrizioneGruppo
                                        FROM utenti
                                        LEFT JOIN utentiGruppi
                                        ON utenti.idUtente = utentiGruppi.idUtente
                                        LEFT JOIN gruppi
                                        ON utentiGruppi.idGruppo = gruppi.idGruppo
                                        /*WHERE utentiGruppi.idGruppo = 2*/
                                        ");

    if (!$query) {

        //error
    }

    while ($data = $query->fetch_assoc()) {

        foreach ($data as $key => $value) {

            $settingUser->setContent($key,$value);
        }
    }





    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;

    $main->setContent("serviceCount", $serviceCount);



    $stmt = $connection->query("SELECT * FROM dipendenti");

    $employeesCount = $stmt->num_rows;

    $main->setContent("employeesCount", $employeesCount);



    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                                    utentiGruppi.idUtente, utentiGruppi.idGruppo
                                                    FROM utenti
                                                    LEFT JOIN utentiGruppi
                                                    ON utenti.idUtente = utentiGruppi.idUtente
                                                    WHERE utentiGruppi.idGruppo = 2");

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);



    $main->setContent("settingUser", $settingUser->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>

