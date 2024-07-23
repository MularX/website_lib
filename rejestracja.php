<?php
    include("header.html");
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h2>Witaj w oknie rejestracji!</h2>
        nazwa użytkownika:<br>
        <input type="username" name="username"><br>
        hasło:<br>
        <input type="password" name="password"><br>
        <input type="submit" name="submit" value="rejestracja">
    </form>
</body>
</html>
<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(empty($username)){
            echo"Proszę podać nazwę użytkownika";
        }
        elseif(empty($password)){
            echo"Proszę podać hasło";
        }
        else{
            $hash = password_hash($password, PASSWORD_DEFAULT); 
            $sql = "INSERT INTO użytkownicy (nazwa_użytkownika, hasło, czy_sprzedawca)
                    VALUES ('$username', '$hash', 0)";
            
            try{
                mysqli_query($conn, $sql);
                echo"Właśnie zostałeś zarejestrowany!";
            }
            catch(mysqli_sql_exception){
                echo"Ta nazwa użytkownika jest zajęta";
            }
        }
    }

    mysqli_close($conn);
?>

