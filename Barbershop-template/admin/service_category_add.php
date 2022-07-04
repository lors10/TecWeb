<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    error_reporting(0);

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


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }


    switch ($_REQUEST['state']) {

        case 0:

            // emissione form

            break;

        case 1:

            // query per aggiungere una categoria di servizi
            // notifica di aggiunta

            $query = "INSERT into categoriaAttivita (idCategoria, nomeCategoria, descrizioneCategoria)
                            VALUES (NULL,'{$_REQUEST['category_name']}','{$_REQUEST['category_description']}')";

            if ($connection->query($query) == 1) {

                echo "Categoria aggiunta con successo!";

                header("Location: index.php");
            } else {

                // check errore
                echo "Errore: " . $query . '<br />' . $connection->connect_error;
            }


            break;
    }
?>
