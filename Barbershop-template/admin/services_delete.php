<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $stmt = $connection->query("DELETE FROM attivita WHERE nomeAttivita='{$_REQUEST['delete']}'");

    header('Location: services.php');

?>
