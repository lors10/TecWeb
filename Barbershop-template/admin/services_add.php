<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $add_service = new Template("design/service-add.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form

            // estrapolo categorie di servizi
            $stmt = $connection->query("SELECT idCategoria, nomeCategoria FROM categoriaAttivita");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $add_service->setContent($key,$value);
                }
            }

            break;

        case 1:

            // query per aggiungere un servizio
            // notifica di aggiunta


            $query = "INSERT into attivita (idAttivita, idCategoria, nomeAttivita, descrizioneAttivita, prezzoAttivita)
                            VALUES (NULL, {$_REQUEST['service_category']}, '{$_REQUEST['service_name']}', '{$_REQUEST['service_description']}', {$_REQUEST['service_price']})";

            if ($connection->query($query) == 1) {

                echo "Categoria aggiunta con successo!";

                $query = "";

                header("Location: services.php");
            } else {

                // check errore
                echo "Errore: " . $query . '<br />' . $connection->connect_error;
            }

            break;
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


    $main->setContent("add_service", $add_service->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>