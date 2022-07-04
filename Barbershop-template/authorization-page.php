<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");


    error_reporting(0);


    // pagina principale: index.html
    $main = new Template("design/index.html");

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


    $error_page = new Template("design/authorization-page.html");


    $error_page->setContent("errorAuth", "<div class=\"alert alert-danger\">
                                                              <p>Autenticazione Fallita</p>
                                                           </div>");





    $footer = new Template("design/footer.html");


    $main->setContent("errorPage", $error_page->get());
    $main->setContent("footer", $footer->get());
    $main->close();

?>