<?php

    require ("../include/dbms.inc.php");
    require ("../include/template2.inc.php");
    require ("../include/session-start.php");

    error_reporting(0);

    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];

    // controllo se l'utente è loggato o meno
    require ("../include/authorization.php");

    // controllo se l'utente (admin / cliente) ha l'accesso a questa pagina
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


    $permission = $connection->query($stmt)->num_rows;


    if (intval($permission) == 0) {

        // accesso negato
        echo "Non hai il permesso";
        exit();

    } else {

        // accesso consentito
    }
    // fine controllo accesso

    $images = new Template("design/images.html");
    $images_table = new Template("design/images-table.html");
    $slider_table = new Template("design/images-slider-table.html");
    $gallery_table = new Template("design/images-gallery-table.html");
    $employees_table = new Template("design/images-employees-table.html");

    /*

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

    */

    // query per estrapolare tutte le immagini e metterle nella tabella apposita
    $stmt = $connection->query("SELECT * FROM immagini");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $images_table->setContent($key, $value);
            }
        }
    } while ($data);



    // query per estrapolare le immagine della sezione slider e inserirle nella tabella apposita
    $stmt = $connection->query("SELECT * FROM slider");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $slider_table->setContent($key, $value);
            }
        }
    } while ($data);



    // query per estrarre immagini da mettere nella sezione galleria
    $stmt = $connection->query("SELECT galleria.idImmagine, immagini.idImmagine, immagini.alt 
                                            FROM galleria
                                            LEFT JOIN immagini
                                            ON galleria.idImmagine = immagini.idImmagine");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $gallery_table->setContent($key, $value);
            }
        }
    } while ($data);


    // query per estrarre informazioni dei dipendenti ed associarli alla tabella apposita insieme alla info delle immagini
    $stmt = $connection->query("SELECT * FROM dipendenti");

    if (!$stmt) {

        //error
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $employees_table->setContent($key, $value);
            }
        }
    } while ($data);






    $stmt = $connection->query("SELECT * FROM attivita");

    $serviceCount = $stmt->num_rows;

    $main->setContent("serviceCount", $serviceCount);


    $stmt = $connection->query("SELECT * FROM dipendenti");

    $employeesCount = $stmt->num_rows;

    $main->setContent("employeesCount", $employeesCount);


    $stmt = $connection->query("SELECT * FROM appuntamento");

    $data = $stmt->num_rows;

    $main->setContent("appointmentCount", $data);


    $stmt = $connection->query("SELECT utenti.idUtente, utenti.nomeUtente, utenti.cognomeUtente, utenti.cellulareUtente, utenti.emailUtente,
                                            utentiGruppi.idUtente, utentiGruppi.idGruppo
                                            FROM utenti
                                            LEFT JOIN utentiGruppi
                                            ON utenti.idUtente = utentiGruppi.idUtente
                                            /*WHERE utentiGruppi.idGruppo = 2*/");

    $employeesCount = $stmt->num_rows;

    $main->setContent("clientsCount", $employeesCount);



    $images->setContent("imagesTable", $images_table->get());
    $images->setContent("sliderTable", $slider_table->get());
    $images->setContent("galleryTable", $gallery_table->get());
    $images->setContent("employeesTable", $employees_table->get());
    $main->setContent("images", $images->get());
    $main->setContent("loggedUser", $_SESSION['name']);
    $main->close();

?>