<?php

    require ("include/template2.inc.php");
    require ("include/dbms.inc.php");
    require ("include/session-start.php");

    error_reporting(0);



    // pagina principale: index.html
    $main = new Template("design/index.html");

    $log = $_SESSION['id'];
    $idG = $_SESSION['idG'];


    /*

    */

    // sezione navbar: navbar.html
    $navbar = new Template("design/navbar.html");

    $stmt = $connection->query("SELECT path, idImmagine FROM immagini WHERE idImmagine=1");

    if (!$stmt) {

        // errore
    }

    $data = $stmt->fetch_assoc();

    foreach ($data as $key => $value) {
        $navbar->setContent($key, $value);
    }

    if ( $log != 0 ) {

        if ($idG == 1) {

            $navbar->setContent("loggedUser", $_SESSION['name']);

            /*
            $navbar->setContent("logoutButton", "<div class=\"header-btn\">
                                                                <a href=\"logout.php\" class=\"menu-btn\">Logout</a>
                                                            </div>");
            */
            $navbar->setContent("logoutButton_a", "<li class=\"\">
                                                                <a class=\"nav-link\" href=\"#\" id=\"userDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                                                    <span></span>
									                                    <i class=\"fas fa-caret-down\"></i>
                                                                </a>

                                                                <!-- Dropdown - User Information -->
                                                                <div class=\"dropdown-menu dropdown-menu-right shadow animated--grow-in\" aria-labelledby=\"userDropdown\">
                                                                    
                                                                        <a class=\"dropdown-item\" href=\"admin/index.php\">
                                                                            <i class=\"fas fa-fw fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400\"></i>
                                                                                Dashboard Admin
                                                                        </a>
                                                                        <div class=\"dropdown-divider\"></div>
                                                                        <a class=\"dropdown-item\" href=\"logout.php\">
                                                                            <i class=\"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400\"></i>
                                                                                Logout
                                                                        </a>
                                                                </div>
                                                            </li>");
        } else {

            $navbar->setContent("logoutButton_u", "<div class=\"header-btn\">
                                                                <a href=\"logout.php\" class=\"menu-btn\">Logout</a>
                                                            </div>");
        }
    } else {

        $navbar->setContent("loginButton", "<div class=\"header-btn\">
                                                                <a href=\"login.php\" class=\"menu-btn\">Login</a>
                                                            </div>");
    }

    // sezione carosello: carosello.html
    $carosel = new Template("design/carosello.html");

    // NON RIESCO A FARE LA QUERY PER ESTRAPOLARE TUTTE TRE LE IMAGES CHE POI DEVO PASSARE NELLA GRAFICA

    // DEVO DISTINGUERE LE SLIDE IN BASE ALLA CLASSE active

    /*

        $stmt = $connection->query("SELECT slider.idImmagine, slider.idPosition, slider.titolo, slider.testo,
                                            immagini.idImmagine, immagini.path FROM slider
                                            LEFT JOIN immagini
                                            ON slider.idImmagine = immagini.idImmagine
                                            WHERE immagini.idImmagine=4");

        if (!$stmt) {

            // errore
        }

        $data = $stmt->num_rows;


         do {

                $data = $stmt->fetch_assoc();
                if ($data){
                    foreach ($data as $key => $value) {
                        echo "{$key} => {$value}";
                        print_r($data);
                    }
                }
            } while ($data);

    */









    // sezione servizi: servizi.html
    $services = new Template("design/servizi.html");

    $stmt = $connection->query("SELECT nomeAttivita, descrizioneAttivita FROM attivita WHERE prezzoAttivita <= 15");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $services->setContent($key, $value);
            }
        }
    } while ($data);

    // sezione appuntamento: appuntamento.html
    $appointment = new Template("design/appuntamento.html");

    // sezione galleria: galleria.html
    $gallery = new Template("design/galleria.html");

    $stmt = $connection->query("SELECT galleria.idImmagine, immagini.idImmagine, immagini.path
                                        FROM galleria 
                                        LEFT JOIN immagini
                                        ON galleria.idImmagine = immagini.idImmagine");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $gallery->setContent($key, $value);
            }
        }
    } while ($data);



    // sezione team: team.html
    $team = new Template("design/team.html");

    $stmt = $connection->query("SELECT immagini.idImmagine, immagini.path, dipendenti.idImmagine 
                                        FROM immagini
                                        LEFT JOIN dipendenti
                                        ON immagini.idImmagine = dipendenti.idImmagine
                                        WHERE immagini.idImmagine = dipendenti.idImmagine");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $team->setContent($key, $value);
            }
        }
    } while ($data);

    // sezione prezzi: prezzi.html
    $prices = new Template("design/prezzi.html");

    /*
    $stmt = $connection->query("SELECT categoriaAttivita.idCategoria, categoriaAttivita.nomeCategoria, 
                                                attivita.idCategoria, attivita.nomeAttivita, attivita.descrizioneAttivita, attivita.prezzoAttivita
                                                  FROM categoriaAttivita
                                                  LEFT JOIN attivita
                                                  ON categoriaAttivita.idCategoria = attivita.idCategoria");

    */

    $stmt = $connection->query("SELECT * FROM attivita LEFT JOIN categoriaAttivita ON attivita.idCategoria = categoriaAttivita.idCategoria");

    if (!$stmt) {

        // errore
    }

    do {

        $data = $stmt->fetch_assoc();
        if ($data){
            foreach ($data as $key => $value) {
                $prices->setContent($key, $value);
            }
        }
    } while ($data);


    $main->setContent("navbar", $navbar->get());
    $main->setContent("carosello", $carosel->get());
    $main->setContent("servizi", $services->get());
    $main->setContent("appuntamento", $appointment->get());
    $main->setContent("galleria", $gallery->get());
    $main->setContent("squadra", $team->get());
    $main->setContent("prezzi", $prices->get());

    //$main->setContent("loggedUser", $_SESSION['name']);
    $main->close();


?>
