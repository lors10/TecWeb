<?php

    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    error_reporting(0);

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    // controllo se l'utente (admin / cliente) ha l'accesso a questa pagina
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


    $permission = $connection->query($stmt)->num_rows;


    if (intval($permission) == 0) {

        // accesso negato
        echo "Non hai il permesso";
        exit();

    } else {

        // accesso consentito
    }
    // fine controllo accesso

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
                                        WHERE utenti.idutente != {$_SESSION['id']} 
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



    $main->setContent("settingUser", $settingUser->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>

