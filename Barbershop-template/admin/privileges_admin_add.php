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


    $add_admin_privileges = new Template("design/privileges-admin-add.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }

    switch ($_REQUEST['state']) {

        case 0:

            // emissione form


            break;

        case 1:

            // query per inserire servizio raggiungibile da utente (su tabella servizi)
            $stmt = $connection->query("INSERT INTO servizi (idServizio, script, descrizioneServizio)
                                                    VALUES (NULL, '{$_REQUEST['script_path']}', '{$_REQUEST['script_description']}')");

            if (!$stmt){

                //errore
                echo "errore query 1";
            }

            // query per selezionare id servizio da tabella servizi
            // query per selezionare id Gruppo (forse) da tabella Gruppi
            $sql = "SELECT idServizio, script, descrizioneServizio FROM servizi 
                    WHERE script = '{$_REQUEST['script_path']}' AND descrizioneServizio ='{$_REQUEST['script_description']}'";

            if (!$sql) {

                //errore
                echo "errore query 2";
            }

            $result = $connection->query($sql);

            while ($row = $result->fetch_assoc()) {


                // query per inserire nella tabella gruppiServizi le chiavi esterne (idGruppo, idServizio)
                $stmt = $connection->query("INSERT into gruppiServizi (idGruppo, idServizio) VALUES (1,{$row['idServizio']})");

                if (!$stmt) {

                    echo "errore query 3";
                }
            }

            header("Location: privileges.php");


            break;
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

    $employeesCount = $stmt->num_rows;

    $main->setContent("clientsCount", $employeesCount);


    $main->setContent("add_admin_privileges", $add_admin_privileges->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>
