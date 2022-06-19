<?php

        require ("include/dbms.inc.php");
        require ("include/template2.inc.php");
        require ("include/session-start.php");


        $login = new Template("design/login.html");

        if (!isset($_REQUEST['state'])) {
            $_REQUEST['state'] = 0;
        }


        switch ($_REQUEST['state']) {

            case 0;

                // emissione della form

                break;

            case 1:

                // 1. controllo dell'utente admin (se esiste)
                // 2. controllo se non è un utente admin
                // 3. messaggi di errore
                // 4. passaggio alla index dell'admin

                /*

                query 1:
                SELECT utentiGruppi.idGruppo, utenti.idUtente, utenti.password
                FROM utentiGruppi
                LEFT JOIN utenti
                ON utenti.idUtente = utentiGruppi.idUtente
                WHERE utenti.username = ?;

                query 2:
                SELECT idUtente, password FROM utenti WHERE username = ?

                */


                // query e connessione al db
                // tramite questa query estrapolo:
                // idGruppo per verificare che l'utente sia un admin
                // idUtente e password dell'utente per verificare che le credenziali siano giuste
                if($stmt = $connection->prepare("SELECT utentiGruppi.idGruppo, utenti.idUtente, utenti.password
                                                                FROM utentiGruppi
                                                                LEFT JOIN utenti
                                                                ON utenti.idUtente = utentiGruppi.idUtente
                                                                WHERE utenti.username = ?")) {
                    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                    $stmt->bind_param('s', $_REQUEST['username']);
                    $stmt->execute();
                    // memorizzo il risultato per controllare se l'account esiste nel db
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($idG, $id, $password);
                        $stmt->fetch();

                        // l'account esiste.
                            // Ora verifico che la password sia correta
                            // NOTA: se volessi usare password cifrate mi devo ricordare di usare password_hash
                            if ($_REQUEST['password'] === $password) {
                                // la verifica è avvenuta con successo. L'utente è loggato
                                // Ora creo la sessione, in modo tale da sapere che l'utente è loggato

                                $_SESSION['loggedin'] = true;
                                $_SESSION['idG'] = $idG;
                                $_SESSION['name'] = $_REQUEST['username'];
                                $_SESSION['id'] = $id;
                            } else {

                                $login->setContent("message", "<div class=\"alert alert-danger\">
                                                                                    <button data-dismiss=\"alert\" class=\"close close-sm\" type=\"button\">
                                                                                        <span aria-hidden=\"true\">×</span>
                                                                                    </button>
                                                                                    <div class=\"messages\">
                                                                                        <div>Username and/or password are incorrect!</div>
                                                                                    </div>
                                                                                 </div>");
                            }
                    } else {

                        $login->setContent("message", "<div class=\"alert alert-danger\">
                                                                                    <button data-dismiss=\"alert\" class=\"close close-sm\" type=\"button\">
                                                                                        <span aria-hidden=\"true\">×</span>
                                                                                    </button>
                                                                                    <div class=\"messages\">
                                                                                        <div>Username and/or password are incorrect!</div>
                                                                                    </div>
                                                                                 </div>");
                    }
                }

                if (isset($_SESSION['id'])) {
                    header("Location: index.php");
                }

                break;
        }


        $login->close();

?>
