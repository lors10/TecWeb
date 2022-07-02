<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $stmt = $connection->query("DELETE FROM utenti WHERE idUtente='{$_REQUEST['delete']}'");

    header('Location: settings_user.php');


?>
