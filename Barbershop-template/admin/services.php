<?php


    require("../include/dbms.inc.php");
    require("../include/template2.inc.php");
    require("../include/session-start.php");

    $main = new Template("design/index.html");
    $services_page = new Template("design/services.html");
    $services_table = new Template("design/service-table.html");

    $stmt = $connection->query("SELECT attivita.idAttivita, attivita.idCategoria, attivita.nomeAttivita, 
                                                attivita.descrizioneAttivita, attivita.prezzoAttivita, 
                                                categoriaAttivita.idCategoria, categoriaAttivita.nomeCategoria
                                        FROM attivita
                                        LEFT JOIN categoriaAttivita
                                        ON attivita.idCategoria = categoriaAttivita.idCategoria");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $services_table->setContent($key, $value);
            }
        }
    } while ($data);

    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;



    $services_page->setContent("servicesTable", $services_table->get());
    $main->setContent("services", $services_page->get());
    $main->setContent("serviceCount", $serviceCount);
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
