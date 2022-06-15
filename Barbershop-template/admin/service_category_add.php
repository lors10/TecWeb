<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

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
