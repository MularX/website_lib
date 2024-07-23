<?php
include("database.php");

function updateDostepnyToZero($conn) {
    $sql = "UPDATE koshyk SET dostepny = 0";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if(isset($_POST['update_dostepny'])) {
    updateDostepnyToZero($conn);
}

$sql = "SELECT * FROM koshyk";
$result = $conn->query($sql);

$sum = 0;

echo "<div class='container'>";
echo "<h1>Koszyk</h1>";
echo "<div class='books'>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        if ($row["dostepny"] == 1) {

            $sum += $row["Cena"];
            echo "<div class='book'>";

                //obraz

            echo "<img src='" . htmlspecialchars($row["Image_Link"]) . "' alt='Book Cover'>";
            echo "<div class='book-details'>";


            
            //  info poza id oraz ilością stron


            foreach ($row as $columnName => $columnValue) {
                if ($columnName !== "Id" && $columnName !== "Ilość_sztuk" && $columnName !== "Image_Link" && $columnName !== "dostepny") {
                    echo "<p><strong>" . htmlspecialchars($columnName) . ":</strong> " . htmlspecialchars($columnValue) . "</p>";
                }
            }
            echo "</div>"; 
            echo "</div>"; // Closing book
        }
    }
} else {
    echo "<p class='error-message'>Koszyk jest pusty.</p>";
}

echo "</div>"; // Closing books


echo "<form method='post'>";
echo "<button type='submit' name='update_dostepny' style='position: fixed; top: 10px; right: 10px;'>Płatność</button>";
echo "</form>";
echo "<p style='position: fixed; top: 50px; right: 10px;'>Suma do zapłaty: " . $sum . "</p>";


echo "<form action='ksiazki.php' method='get'>";
echo "<button type='submit' name='move_to_ksiazki' style='position: fixed; top: 90px; right: 10px;'>Wróć do zakupów</button>";
echo "</form>";

echo "</div>"; // 


$conn->close();
