<?php


    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");


    // query di cancellazione appuntamento
    $stmt = $connection->query("DELETE FROM appuntamento WHERE idAppuntamento={$_REQUEST['delete']}");

    header('Location: appointment.php');


?>
