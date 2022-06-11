<?php

    //script di prova connessione al db
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $databasename = "barber_shop";

    //connessione
    $connection =
        new mysqli($servername, $username, $password, $databasename);

        // check della connessione
        if ($connection->connect_error) {
            // per visualizzare l'errore
            die("Connection error" . $connection->connect_error);
        }

?>
