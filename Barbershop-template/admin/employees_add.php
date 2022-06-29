<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $add_employer = new Template("design/employees-add.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // estraggo id immagine per l'immagine del dipendente

            $stmt = $connection->query("SELECT idImmagine, alt FROM immagini");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $add_employer->setContent($key,$value);
                }
            }

            break;


        case 1:

            // operazione di insert e notifica di successo

            $query = "INSERT into  dipendenti (idDipendente, idImmagine, nomeDipendente, cognomeDipendente, cellulareDipendente, emailDipendente)
                            VALUES (NULL, {$_REQUEST['employer_image_id']}, '{$_REQUEST['employer_name']}', '{$_REQUEST['employer_surname']}',
                                    '{$_REQUEST['employer_phone']}', '{$_REQUEST['employer_mail']}')";

            if ($connection->query($query) == 1) {

                echo "Categoria aggiunta con successo!";

                header("Location: employees.php");
            } else {

                // check errore
                echo "Errore: " . $query . '<br />' . $connection->connect_error;
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


    $main->setContent("add_employer", $add_employer->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>