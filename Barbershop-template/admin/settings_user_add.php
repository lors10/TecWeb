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

    $admin_add = new Template("design/setting-user-add.html");



    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form


            break;

        case 1:

            // query 1; per aggiungere admin nella tabella utenti
            // query 2: per aggiungere admin nella tabella gruppoUtenti
            // notifica di aggiunta




            $stmt = $connection->query("INSERT INTO utenti (idUtente, nomeUtente, cognomeUtente, cellulareUtente, username, password, emailUtente)
                        VALUES (NULL, '{$_REQUEST['admin_name']}', '{$_REQUEST['admin_surname']}', '{$_REQUEST['admin_number']}',
                                '{$_REQUEST['admin_username']}', '{$_REQUEST['admin_password']}', '{$_REQUEST['admin_mail']}')");

            if (!$stmt) {

                echo "errore query 1";
            }

            // procedura per estrapolare informazioni da utente admin appena inserito e inserire info nella tabella utentiGruppi (per possibili controlli)

            $sql = "SELECT idUtente, nomeUtente, cognomeUtente, cellulareUtente, password FROM utenti WHERE username= '{$_REQUEST['admin_username']}'";

            if (!$sql) {

                echo "errore query 2";
            }

            $result = $connection->query($sql);

            while ($row = $result->fetch_assoc()) {

                //echo $row['idUtente'] . "\n" . $row['nomeUtente'] . "\n" . $row['cognomeUtente'] . "\n" . $row['cellulareUtente'] . "\n" . $row['password'];

                $stmt = $connection->query("INSERT into utentiGruppi (idUtente, idGruppo) VALUES ({$row['idUtente']},1)");

                if (!$stmt) {

                    echo "errore";
                }
            }

            header("Location: settings_user.php");


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



    $main->setContent("adminAdd", $admin_add->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
