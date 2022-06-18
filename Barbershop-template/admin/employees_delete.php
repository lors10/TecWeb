<?php

    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $stmt = $connection->query("DELETE FROM dipendenti WHERE idDipendente={$_REQUEST['delete']}");

    if (!$stmt){

        // error
    }

    header('Location: employees.php');

?>
