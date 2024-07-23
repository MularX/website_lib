<?php

$db_server = "localhost";
$db_user = "root";
$db_pass ="";
$db_name ="ksiazki";
$conn="";


try {
    // Ustanowienie połączenia z bazą danych
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Nie można połączyć się z bazą danych: " . $conn->connect_error);
    } else {
        // echo "Połączenie z bazą danych zostało pomyślnie ustanowione";
    }
} catch (mysqli_sql_exception $e) {
    echo "Wystąpił błąd podczas łączenia z bazą danych: " . $e->getMessage();
}
?>