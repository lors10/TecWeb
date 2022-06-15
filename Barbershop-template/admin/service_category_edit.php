<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");


    if (!isset($_REQUEST['state'])) {
        $_REQUEST['state'] = 0;
    }

    switch ($_REQUEST['state']) {

        case 0:

            //

            break;

        case 1:

            // modificare i dati della tabella
            // notifica
            // tornare alla home

            $stmt = $connection->query("UPDATE categoriaAttivita SET 
                                                    nomeCategoria = \"{$_REQUEST['category_name']}\",
                                                    descrizioneCategoria = \"{$_REQUEST['category_description']}\"
                                                    WHERE idCategoria = {$_REQUEST['edit']}");

            if ($stmt == 1) {

                echo "Categoria aggiunta con successo!";

                header("Location: index.php");
            } else {

                // check errore
                echo "Errore: " . $stmt . '<br />' . $connection->connect_error;
            }
    }


?>