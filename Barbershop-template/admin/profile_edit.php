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

    $edit_profile = new Template("design/profile-edit.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // estraggo i dati dell'admin in base all'id della sessione

            $stmt = $connection->query("SELECT * FROM utenti WHERE idUtente={$_SESSION['id']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $edit_profile->setContent($key,$value);
                }
            }

            break;


        case 1:

            $stmt = $connection->query("UPDATE utenti SET 
                                                        nomeUtente = \"{$_REQUEST['admin_name_update']}\",
                                                        cognomeUtente = \"{$_REQUEST['admin_surname_update']}\",
                                                        cellulareUtente = \"{$_REQUEST['admin_number_update']}\",
                                                        username = \"{$_REQUEST['admin_username_update']}\",
                                                        password = \"{$_REQUEST['admin_password_update']}\"
                                                        WHERE idUtente = {$_REQUEST['admin_id']}");

            if ($stmt == 1) {

                echo "Profilo Admin aggiornato con successo!";

                header("Location: profile.php");
            } else {

                // check errore
                echo "Errore: " . $stmt . '<br />' . $connection->connect_error;
            }



            break;




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

    $clientsCount = $stmt->num_rows;

    $main->setContent("clientsCount", $clientsCount);


    $main->setContent("add_employer", $edit_profile->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>