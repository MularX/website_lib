<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep książkowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        .sorting-options {
            text-align: center;
            margin-bottom: 20px;
        }

        .sorting-options label {
            font-weight: bold;
        }

        .books {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }

        .book {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        .book:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .book h2 {
            margin-top: 0;
            font-size: 1.2em;
            color: #007bff;
            text-align: center;
        }

        .book p {
            margin: 10px 0;
            color: #666;
            font-size: 0.9em;
        }

        .book img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .book form {
            text-align: center;
        }

        .book form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .book form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        /* Style for the button */
        .cart-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cart-button:hover {
            background-color: #0056b3;
        }

        .logout-button {
            position: fixed;
            top: 80px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }


    </style>
</head>
<body>
<div class="container">
    <h1>Sklep książkowy</h1>
    <div class="sorting-options">
        <label for="sort_by">Sortuj według:</label>
        <select id="sort_by" onchange="location = this.value;">
            <option value="?sort_by=Tytuł">Tytuł</option>
            <option value="?sort_by=Autor">Autor</option>
            <option value="?sort_by=Gatunek">Gatunek</option>
            <option value="?sort_by=Cena">Cena</option>
        </select>
    </div>

    <div class="books">
    <?php
    // Include database connection file
    include("database.php");

    // Check if the book ID is provided
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_ksiazki'])) {
        $book_id = $_POST['id_ksiazki'];
        
        // Decrease the quantity by 1 in the baza_danych table
        $update_sql = "UPDATE baza_danych SET Ilość_sztuk = Ilość_sztuk - 1 WHERE Id = $book_id";

        if ($conn->query($update_sql) === TRUE) {
            // SQL query to insert the specific book from baza_danych into koszyk
            $insert_sql = "INSERT INTO koshyk (Tytuł, Autor, Gatunek, Cena, Ilość_sztuk, Język, Wydawnictwo, Data_wydania, Ilość_stron, Image_Link, dostepny)
                    SELECT Tytuł, Autor, Gatunek, Cena, Ilość_sztuk, Język, Wydawnictwo, Data_wydania, Ilość_stron, Image_Link, koszyk 
                    FROM baza_danych 
                    WHERE Id = $book_id";

            if ($conn->query($insert_sql) === TRUE) {
                // If insertion is successful, display a success message
                echo "<script>alert('Książka została dodana do koszyka.');</script>";
            } else {
                // If insertion fails, display an error message
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        } else {
            // If update fails, display an error message
            echo "Error updating record: " . $conn->error;
        }
    }

    // Fetch data from baza_danych
    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'Tytuł'; // Default sorting by 'Tytuł'
    $sql = "SELECT * FROM baza_danych ORDER BY $sort_by";
    $result = $conn->query($sql);

    if (!$result) {
        // Handle query execution error
        echo "Error: " . $conn->error;
    } else {
        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Display books
            while($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<h2>" . htmlspecialchars($row["Tytuł"]) . "</h2>";
                echo "<p><strong>Autor:</strong> " . htmlspecialchars($row["Autor"]) . "</p>";
                echo "<p><strong>Gatunek:</strong> " . htmlspecialchars($row["Gatunek"]) . "</p>";
                echo "<p><strong>Cena:</strong> " . htmlspecialchars($row["Cena"]) . "</p>";
                echo "<p><strong>Ilość sztuk:</strong> " . htmlspecialchars($row["Ilość_sztuk"]) . "</p>";
                echo "<img src='" . htmlspecialchars($row["Image_Link"]) . "' alt='Cover Image'>";
                // Add hidden input for book id
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='id_ksiazki' value='" . $row["Id"] . "'>";
                echo "<input type='submit' value='Dodaj do koszyka'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            // No books available
            echo "<p class='error-message'>Brak dostępnych książek.</p>";
        }
    }
    ?>
 


    <form action="logowanie.php" method="post">
    <input type="submit" class="logout-button" name="wyloguj" value="Wyloguj się">
</form>

<?php



if(isset($_POST['wyloguj'])) {
    // Zakończenie sesji
   
   
      
   
            
    session_unset(); // Wyczyść wszystkie zmienne sesji
    session_destroy(); // Zniszcz sesję
    // Przekierowanie użytkownika do strony logowania
    header("Location: logowanie.php");
    exit; // Upewnienie się, że żadna inna treść nie jest renderowana po przekierowaniu

    // Close the database connection
    $conn->close();
}
?>


    </div>

    <!-- Button to go to dodaj_do_koszyka.php -->
    <a href="dodaj_do_koszyka.php" class="cart-button">Przejdź do koszyka</a>
</div>
</body>
</html>
