<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");
    require ("include/session-start.php");



        /*
            seleziono da prenotazione le righe duplicate contandole secondo idAttivita

            SELECT idAppuntamento, COUNT(idAttivita)
            FROM prenotazione
            GROUP BY idAppuntamento
            HAVING COUNT(idAttivita) > 1

        */


    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("include/authorization.php");



    $appointment = new Template("design/appuntamento-form-2.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }

    switch ($_REQUEST['state']) {

        case 0:


            // emissione form

            // estrapolo informzioni su servizi forniti
            $stmt = $connection->query("SELECT idAttivita, nomeAttivita, prezzoAttivita, descrizioneAttivita FROM attivita");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $appointment->setContent($key, $value);
                }
            }

            // estaggo informazioni su utente che sta prenotando il servizio

            $stmt = $connection->query("SELECT nomeUtente, cognomeUtente, cellulareUtente, username, emailUtente FROM utenti WHERE username='{$_SESSION['name']}'");

            if (!$stmt) {

                echo "errore";
            }

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $appointment->setContent($key, $value);
                }
            }

            /*
            // faccio la query e la inserisco in un array associativo

            // estrapolo dal db il conteggio dello stesso giorno in cui viene prenotato lo stesso slot di tempo da persone diverse
            $result = $connection->query("SELECT inizioDataAppuntamento, COUNT(*) 
                                                    FROM appuntamento 
                                                    WHERE inizioTempoAppuntamento = '17:00:00' 
                                                    GROUP BY inizioDataAppuntamento");


            while ($data = $result->fetch_all(MYSQLI_ASSOC)) {

                foreach ($data as $row) {

                    //echo $row['COUNT(*)'] . "<br>";

                    if (($row['COUNT(*)'] >= 2) && ($_REQUEST['selected_date'])) {

                        //echo "caso falso";
                        //echo "<br>";
                        $appointment->setContent("label", "<label class=\"btn btn-secondary\" disabled=\"true\">
                                                                                <input type=\"radio\" name=\"selected_time_slot\" value=\"17:00:00\" style=\"margin-bottom: 5px\">05:00 - 06:00 AM
                                                                           </label>");

                    } else {

                        //echo "caso vero";
                        //echo "<br>";
                        $appointment->setContent("label", "<label class=\"default_btn_slot service_label item_label_slot btn btn-secondary\">
                                                                            <input type=\"radio\" name=\"selected_time_slot\" value=\"17:00:00\" style=\"margin-bottom: 5px\">05:00 - 06:00 AM
                                                                          </label>");

                    }
                }
            }
            */


            break;

        case 1:

            // compilazione ed invio form

            $query = "INSERT into appuntamento (idAppuntamento, idUtente, inizioDataAppuntamento, inizioTempoAppuntamento, cancellazione, createdAt)
                            VALUES (NULL, {$_SESSION['id']}, '{$_REQUEST['selected_date']}',  '{$_REQUEST['selected_time_slot']}', 0, '" . date('Y-m-d H:i:s') . "')";

            if ($connection->query($query) == 1) {

                $stmt = "SELECT * FROM appuntamento WHERE idUtente = {$_SESSION['id']}";

                $result = $connection->query($stmt);

                while ($row = $result->fetch_assoc()) {

                    //echo $row['idUtente'] . "\n" . $row['nomeUtente'] . "\n" . $row['cognomeUtente'] . "\n" . $row['cellulareUtente'] . "\n" . $row['password'];

                    $stmt = $connection->query("INSERT into prenotazione (idAppuntamento, idAttivita) VALUES ({$row['idAppuntamento']},{$_REQUEST['service_name']})");

                    if (!$stmt) {

                        echo "Errore: " . $query . '<br />' . $connection->connect_error;

                    }
                }


                header("Location: success_page.php");

            } else {

                // check errore
                //echo "Errore: " . $query . '<br />' . $connection->connect_error;

                header("Location: error_page.php");
            }


            //header("Location: index.php");

            break;

    }

    /*

    $appointment = new Template("design/appuntamento-form.html");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0;

            // emissione della form

            $appointment->setContent("nomeUser", $_SESSION['name']);


            $stmt = $connection->query("SELECT idAttivita, nomeAttivita, prezzoAttivita FROM attivita");

            while ($data = $stmt->fetch_assoc()) {

                foreach ($data as $key => $value) {

                    $appointment->setContent($key, $value);
                }
            }


            break;

        case 1:

            echo "errore";


            $query = "INSERT into appuntamento (idAppuntamento, idUtente, inizioAppuntamento, cancellazione, createdAt)
                            VALUES (NULL, {$_SESSION['id']}, '{$_REQUEST['date']} {$_REQUEST['time']}', 0, '" . date('Y-m-d H:i:s') . "')";

            if ($connection->query($query) == 1) {

                echo "Categoria aggiunta con successo!";

                $stmt = "SELECT * FROM appuntamento WHERE idUtente = {$_SESSION['id']}";

                $result = $connection->query($stmt);

                while ($row = $result->fetch_assoc()) {

                    //echo $row['idUtente'] . "\n" . $row['nomeUtente'] . "\n" . $row['cognomeUtente'] . "\n" . $row['cellulareUtente'] . "\n" . $row['password'];

                    $stmt = $connection->query("INSERT into prenotazione (idAppuntamento, idAttivita) VALUES ({$row['idAppuntamento']},{$_REQUEST['service_name']})");

                    if (!$stmt) {

                        echo "errore";
                    }
                }

                header("Location: index.php");

            } else {

                // check errore
                echo "Errore: " . $query . '<br />' . $connection->connect_error;
            }



            break;
    }

    */


    $footer = new Template("design/footer.html");


    //$main->setContent("navbar", $navbar->get());
    //$main->setContent("appuntamentoForm", $appointment->get());
    $main->setContent("appuntamentoForm", $appointment->get());
    $main->setContent("footer", $footer->get());

    $main->close();

?>