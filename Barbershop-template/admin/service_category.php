<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    $main = new Template("design/index.html");
    $service_category = new Template("design/service-category.html");
    $service_category_table = new Template("design/service-category-table.html");

    $stmt = $connection->query("SELECT * FROM categoriaAttivita");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $service_category_table->setContent($key, $value);
            }
        }
    } while ($data);

    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;


    $service_category->setContent("service_category_table", $service_category_table->get());
    $main->setContent("service_category", $service_category->get());
    $main->setContent("serviceCount", $serviceCount);
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();



?>
