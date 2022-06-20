<?php

    require ("include/dbms.inc.php");
    require ("include/template2.inc.php");
    require ("include/session-start.php");


    $singup = new Template("design/signup.html");

    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0;

            // emissione della form

            break;

        case 1:

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



            $stmt = $connection->query("INSERT into utenti (idUtente, nomeUtente, cognomeUtente, cellulareUtente, username, password, emailUtente)
                            VALUES (NULL, '{$_REQUEST['name']}', '{$_REQUEST['surname']}', '{$_REQUEST['number']}', '{$_REQUEST['username']}', '{$_REQUEST['password']}', '{$_REQUEST['mail']}')");

            if (!$stmt) {

                // errore
            }


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
