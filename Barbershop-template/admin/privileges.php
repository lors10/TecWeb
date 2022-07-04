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


    $privileges = new Template("design/privileges.html");
    $privileges_user = new Template("design/privileges-user-table.html");
    $privileges_admin = new Template("design/privileges-admin-table.html");



    // devo selezionare i privilegi dalla tabella servizi e passarli alla tabella degli utenti
    $stmt = $connection->query("SELECT servizi.idServizio, servizi.script, servizi.descrizioneServizio,
                                             gruppiServizi.idServizio, gruppiServizi.idGruppo
                                             FROM servizi
                                             LEFT JOIN gruppiServizi
                                             ON servizi.idServizio = gruppiServizi.idServizio
                                             WHERE gruppiServizi.idGruppo = 2");

    if (!$stmt) {

        // errore query
        echo "errore";
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $privileges_user->setContent($key, $value);
            }
        }
    } while ($data);


    // devo selezionare i privilegi dalla tabella servizi e passarli alla tabella degli amministratori
    $stmt = $connection->query("SELECT servizi.idServizio, servizi.script, servizi.descrizioneServizio,
                                                 gruppiServizi.idServizio, gruppiServizi.idGruppo
                                                 FROM servizi
                                                 LEFT JOIN gruppiServizi
                                                 ON servizi.idServizio = gruppiServizi.idServizio
                                                 WHERE gruppiServizi.idGruppo = 1");

    if (!$stmt) {

        // errore query
        echo "errore";
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $privileges_admin->setContent($key, $value);
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

    $employeesCount = $stmt->num_rows;

    $main->setContent("clientsCount", $employeesCount);



    $privileges->setContent("user_privileges", $privileges_user->get());
    $privileges->setContent("admin_privileges", $privileges_admin->get());
    $main->setContent("privileges", $privileges->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>