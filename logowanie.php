<?php
include("header.html");
include("database.php");

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Zabezpieczenie przed atakami SQL injection
        $username2 = mysqli_real_escape_string($conn, $username);
        $password2 = mysqli_real_escape_string($conn, $password);

        // Zapytanie SQL sprawdzające czy użytkownik istnieje
        $sql = "SELECT * FROM użytkownicy WHERE nazwa_użytkownika = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Użytkownik istnieje w bazie danych
            $row = $result->fetch_assoc();
            $hashed_password = $row['hasło']; // hasło zahashowane w bazie danych
            $sprzedawca = $row['czy_sprzedawca'];
            // Sprawdzenie czy podane hasło pasuje
            if (password_verify($password, $hashed_password)) {

                session_start(); // Rozpoczęcie sesji
                $_SESSION['nazwa_użytkownika'] = $username;

                if ($sprzedawca == 1) {
                    header("Location: dodawanie_ksiazek.php");
                    echo "Zalogowano pomyślnie!";
                    exit();
                } else {
                    header("Location: ksiazki.php");
                    echo "Zalogowano pomyślnie!";
                }
            } else {
                echo "Nieprawidłowe hasło!";
            }
        } else {
            echo "Użytkownik o podanej nazwie nie istnieje!";
        }

        mysqli_close($conn);
    } else {
        // If username or password is not set, this means the form was submitted but not fully filled
        echo "Prosimy wypełnić oba pola!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        form {
            text-align: center;
        }

        input[type="username"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h2>Witaj w oknie logowania!</h2>
            Nazwa użytkownika:<br>
            <input type="username" name="username"><br>
            Hasło:<br>
            <input type="password" name="password"><br>
            <input type="submit" name="submit" value="Logowanie">
        </form>
    </div>
</body>
</html>
