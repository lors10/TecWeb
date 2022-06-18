<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $stmt = $connection->query("DELETE FROM slider WHERE idImmagine='{$_REQUEST['delete']}'");

    header('Location: images.php');
?>
