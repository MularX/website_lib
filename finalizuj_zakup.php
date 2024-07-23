<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
</head>
<body>
    <h2>Koszyk</h2>
    <?php
    // Rozpoczęcie sesji
    session_start();

    // Sprawdzenie, czy koszyk nie jest pusty
    if(isset($_SESSION['koszyk']) && !empty($_SESSION['koszyk'])) {
        // Połączenie z bazą danych
        include("database.php");

        // Pobranie informacji o książkach z koszyka
        $id_ksiazki = implode(',', $_SESSION['koszyk']); // Konwertujemy tablicę na listę id książek
        $sql = "SELECT Tytuł, Cena FROM baza_danych WHERE ID IN ($id_ksiazki)";
        $result = $conn->query($sql);

        // Wyświetlanie informacji o książkach w koszyku
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<p><strong>Tytuł:</strong> " . $row["Tytuł"] . "</p>";
                echo "<p><strong>Cena:</strong> " . $row["Cena"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Koszyk jest pusty.</p>";
        }

        // Zamknięcie połączenia z bazą danych
        $conn->close();

        // Przyciski do kontynuowania zakupów i finalizacji zamówienia
        echo "<a href='ksiazki.php'><button>Kontynuuj zakupy</button></a>";
        echo "<a href='finalizacja_zakupu.php'><button>Finalizuj zamówienie</button></a>";
    } else {
        echo "<p>Koszyk jest pusty.</p>";
        echo "<a href='ksiazki.php'><button>Kontynuuj zakupy</button></a>";
    }
    ?>
</body>
</html>