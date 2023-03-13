<?php
    $host = "localhost";
    $User = "root";
    $pass = "";

    $db = "dbprueba";

    $con = mysqli_connect($host, $User, $pass, $db);
    if (!$con) {
        echo "Conexión fallida";
    }
