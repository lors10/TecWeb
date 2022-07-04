<?php

    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    error_reporting(0);

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo per verificare che utente (admin / cliente) abbia il permesso per accedere a questa pagina
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


    if ($connection->query($stmt)->num_rows == 0) {

        // accesso negato
        echo "Non hai l'accesso";
        exit();

    } else {

        // accesso consentito
    }
    // controllo terminato

    $stmt = $connection->query("DELETE FROM dipendenti WHERE idDipendente={$_REQUEST['delete']}");

    if (!$stmt){

        // error
    }

    header('Location: employees.php');

?>
