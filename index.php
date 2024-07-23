<?php
include("database.php");
// include("header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Główna Księgarni</title>
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

        h1, h2 {
            color: #007bff;
        }

        p {
            margin: 10px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include("header.html"); ?>

    <div class="container">
        <h1>Strona Główna Księgarni</h1>
        <p>Witaj na stronie głównej księgarni!</p>
        <p>Zaloguj się, aby móc wypożyczyć książkę.</p>
        <p>Nowych użytkowników zapraszamy do rejestracji.</p>
    </div>

    <?php include("footer.html"); ?>
</body>
</html>
