<style>
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
<?php
include("database.php");

// Dodawanie info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['tytul']) && isset($_POST['autor']) && isset($_POST['cena']) &&
        isset($_POST['ilosc']) && isset($_POST['gatunek']) && isset($_POST['ilosc_stron']) &&
        isset($_POST['jezyk']) && isset($_POST['wydawnictwo']) && isset($_POST['data_wydania']) &&
        isset($_POST['image_link']) 
    ) {
        $tytul = $_POST['tytul'];
        $autor = $_POST['autor'];
        $cena = $_POST['cena'];
        $ilosc = $_POST['ilosc'];
        $gatunek = $_POST['gatunek'];
        $ilosc_stron = $_POST['ilosc_stron'];
        $jezyk = $_POST['jezyk'];
        $data_wydania = $_POST['data_wydania'];
        $wydawnictwo = $_POST['wydawnictwo'];
        $image_link = $_POST['image_link']; //obrazek ;/

        // Zabezpieczenie przed atakami SQL injection
        $tytul = mysqli_real_escape_string($conn, $tytul);
        $autor = mysqli_real_escape_string($conn, $autor);
        $gatunek = mysqli_real_escape_string($conn, $gatunek);
        $jezyk = mysqli_real_escape_string($conn, $jezyk);
        $wydawnictwo = mysqli_real_escape_string($conn, $wydawnictwo);
        $data_wydania = mysqli_real_escape_string($conn, $data_wydania);
        $image_link = mysqli_real_escape_string($conn, $image_link); 

        // Zapytanie SQL do wstawienia danych
        $sql = "INSERT INTO baza_danych(Tytuł, Autor, Gatunek, Cena, Ilość_sztuk, Język, Wydawnictwo, Data_wydania, Ilość_stron, Image_Link, koszyk) 
        VALUES ('$tytul', '$autor', '$gatunek', '$cena', '$ilosc', '$jezyk', '$wydawnictwo', '$data_wydania', '$ilosc_stron', '$image_link', '1')";


        // Wykonanie zapytania
        if ($conn->query($sql) === TRUE) {
            echo "Nowy rekord został dodany pomyślnie.";
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }

        // Zamykanie połączenia
        $conn->close();
    } else {
        //errorek
        echo "Proszę wypełnić wszystkie pola!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formularz dodawania książki</title>
    <script>
        function validateForm() {
            var tytul = document.getElementById("tytul").value;
            var autor = document.getElementById("autor").value;
            var cena = document.getElementById("cena").value;
            var ilosc = document.getElementById("ilosc").value;
            var gatunek = document.getElementById("gatunek").value;
            var ilosc_stron = document.getElementById("ilosc_stron").value;
            var jezyk = document.getElementById("jezyk").value;
            var wydawnictwo = document.getElementById("wydawnictwo").value;
            var data_wydania = document.getElementById("data_wydania").value;
            var image_link = document.getElementById("image_link").value; 

            // Walidacja, że pola nie są puste
            if (tytul == "" || autor == "" || cena == "" || ilosc == "" || gatunek == "" || ilosc_stron == "" || jezyk == "" || wydawnictwo == "" || data_wydania == "" || image_link == "") { // Check if image link is empty
                alert("Proszę wypełnić wszystkie pola!");
                return false;
            }

            // Walidacja, że cena, ilość i ilość stron są liczbami dodatnimi
            if (isNaN(cena) || parseFloat(cena) <= 0 || isNaN(ilosc) || parseInt(ilosc) <= 0 || isNaN(ilosc_stron) || parseInt(ilosc_stron) <= 0) {
                alert("Proszę wprowadzić poprawną cenę, ilość i ilość stron!");
                return false;
            }

            // Walidacja daty wydania
            var regex = /^\d{4}-\d{2}-\d{2}$/;
            if(!regex.test(data_wydania)) {
                alert("Proszę wprowadzić poprawny format daty (RRRR-MM-DD)!");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h2>Formularz dodawania książki</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <label for="tytul">Tytuł:</label><br>
        <input type="text" id="tytul" name="tytul"><br>

        <label for="autor">Autor:</label><br>
        <input type="text" id="autor" name="autor"><br>

        <label for="cena">Cena:</label><br>
        <input type="text" id="cena" name="cena"><br>

        <label for="ilosc">Ilość:</label><br>
        <input type="text" id="ilosc" name="ilosc"><br>

        <label for="gatunek">Gatunek:</label><br>
        <input type="text" id="gatunek" name="gatunek"><br>

        <label for="ilosc_stron">Ilość stron:</label><br>
        <input type="text" id="ilosc_stron" name="ilosc_stron"><br>

        <label for="jezyk">Język:</label><br>
        <input type="text" id="jezyk" name="jezyk"><br>

        <label for="wydawnictwo">Wydawnictwo:</label><br>
        <input type="text" id="wydawnictwo" name="wydawnictwo"><br>

        <label for="data_wydania">Data wydania:</label><br>
        <input type="text" id="data_wydania" name="data_wydania" placeholder="RRRR-MM-DD"><br>

        <label for="image_link">Link do obrazka okładki:</label><br> 
        <input type="text" id="image_link" name="image_link"><br> 


        <input type="submit" value="Dodaj książkę">
    </form>
    <form action="logowanie.php" method="post">
    <input type="submit" class="logout-button" name="wyloguj" value="Wyloguj się">

    
</body>
</html>

<?php
include("footer.html");
?>

<?php
if(isset($_POST['wyloguj'])) {
    // Zakończenie sesji
   
   
      
   
            
    session_unset(); // Wyczyść wszystkie zmienne sesji
    session_destroy(); // Zniszcz sesję
    // Przekierowanie użytkownika do strony logowania
    header("Location: logowanie.php");
    exit; // Upewnienie się, że żadna inna treść nie jest renderowana po przekierowaniu

}

    ?>