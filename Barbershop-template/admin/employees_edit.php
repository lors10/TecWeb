<?php


require("../include/dbms.inc.php");
require("../include/template2.inc.php");
require("../include/session-start.php");

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    $edit_employer = new Template("design/employees-edit.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // estraggo id immagine per l'immagine del dipendente

            $stmt = $connection->query("SELECT dipendenti.idDipendente, dipendenti.idImmagine, dipendenti.nomeDipendente, 
                                                     dipendenti.cognomeDipendente, dipendenti.cellulareDipendente, dipendenti.emailDipendente,
                                                     immagini.idimmagine
                                                     FROM dipendenti
                                                     LEFT JOIN immagini
                                                     ON dipendenti.idImmagine = immagini.idImmagine
                                                     WHERE dipendenti.idDipendente = {$_REQUEST['edit']}");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $edit_employer->setContent($key,$value);
                }
            }

            break;


        case 1:

            // modificare i dati della tabella
            // notifica
            // tornare alla home dipendenti

            $stmt = $connection->query("UPDATE dipendenti SET 
                                                        nomeDipendente = \"{$_REQUEST['employer_name_update']}\",
                                                        cognomeDipendente = \"{$_REQUEST['employer_surname_update']}\",
                                                        cellulareDipendente = \"{$_REQUEST['employer_phone_update']}\",
                                                        emailDipendente = \"{$_REQUEST['employer_mail_update']}\"
                                                        WHERE idDipendente = {$_REQUEST['employer_id']}");

            if ($stmt == 1) {

                echo "Dipendente aggiunta con successo!";

                header("Location: employees.php");
            } else {

                // check errore
                echo "Errore: " . $stmt . '<br />' . $connection->connect_error;
            }



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


    $main->setContent("add_employer", $edit_employer->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>