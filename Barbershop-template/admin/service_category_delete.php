<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $stmt = $connection->query("DELETE FROM categoriaAttivita WHERE idCategoria=" . $_GET['delete']);

    header('Location: service_category.php');

?>