<?php

    require ("include/dbms.inc.php");
    require ("include/template2.inc.php");
    require ("include/session-start.php");

    error_reporting(0);


    $singup = new Template("design/signup.html");

    // controllo per verificare che utente (admin / cliente) abbia il permesso per accedere a questa pagina
    $stmt = "SELECT servizi.idServizio, servizi.script,
                        gruppiServizi.idServizio, gruppiServizi.idGruppo, gruppi.idGruppo
                        FROM servizi
                        LEFT JOIN gruppiServizi
                        ON servizi.idServizio = gruppiServizi.idServizio
                        LEFT JOIN gruppi
                        ON gruppiServizi.idGruppo = gruppi.idGruppo
                        WHERE servizi.script = '{$_SERVER['SCRIPT_NAME']}'";

    if ($connection->query($stmt) == 1) {

        // Query ok

    } else {

        // check errore
        echo "Errore: " . $stmt . '<br />' . $connection->connect_error;

    }


    if ($connection->query($stmt)->num_rows == 0) {

        // accesso negato
        echo "Non hai l'accesso";
        exit();

    } else {

        // accesso consentito
    }
    // controllo terminato

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0;

            // emissione della form

            break;

        case 1:

            // controllo su password

            if ($_REQUEST['password'] != $_REQUEST['confirm_password']) {

                $singup->setContent("message", "<div class=\"alert alert-danger\">
                                                                     <button data-dismiss=\"alert\" class=\"close close-sm\" type=\"button\">
                                                                          <span aria-hidden=\"true\">×</span>
                                                                     </button>
                                                                     <div class=\"messages\">
                                                                         <div>Le password inserite non coincidono!</div>
                                                                     </div>
                                                                  </div>");
            }


            // query di inserimento utente nel db

            $stmt = $connection->query("INSERT into utenti (idUtente, nomeUtente, cognomeUtente, cellulareUtente, username, password, emailUtente)
                            VALUES (NULL, '{$_REQUEST['name']}', '{$_REQUEST['surname']}', '{$_REQUEST['number']}', '{$_REQUEST['username']}', '{$_REQUEST['password']}', '{$_REQUEST['mail']}')");

            if (!$stmt) {

                // errore
            }

            // procedura per estrapolare informazioni da utente appena inserito e inserire info nella tabella utentiGruppi (per possibili controlli)

            $sql = "SELECT idUtente, nomeUtente, cognomeUtente, cellulareUtente, password FROM utenti WHERE username= '{$_REQUEST['username']}'";

            if (!$sql) {

                echo "errore";
            }

            $result = $connection->query($sql);

            while ($row = $result->fetch_assoc()) {

                //echo $row['idUtente'] . "\n" . $row['nomeUtente'] . "\n" . $row['cognomeUtente'] . "\n" . $row['cellulareUtente'] . "\n" . $row['password'];

                $stmt = $connection->query("INSERT into utentiGruppi (idUtente, idGruppo) VALUES ({$row['idUtente']},2)");

                if (!$stmt) {

                    echo "errore";
                }
            }

            header("Location: login.php");


            break;
    }


    $singup->close();
?>
