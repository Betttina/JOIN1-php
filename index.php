<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
<div class="header">
    <!-- Lägg till en div med klassen "connection-status" -->
    <div class="connection-status">
        <?php
        // Deklarera variabeln $connection innan den används
        $connection = getConnection();

        // check connection
        if ($connection->connect_error != null) {
            echo "Anslutningen misslyckades: " . $connection->connect_error;
        } else {
            echo "Anslutningen lyckades.";
        }
        ?>
    </div>
</div>

<?php

// skapa anslutning till databasen
function getConnection(){
$host = "localhost";
$port = 3306;
$database = "databas1";
$username = "root";
$password = "";

// create connection to database
$connection = new mysqli($host, $username, $password, $database, $port);
return $connection;
}

// Använder JOIN för att kombinera tabellerna customers och orders (kopplade genom customer_id)
$query1="SELECT customers.customer_name
FROM customers
INNER JOIN orders ON customers.customer_id = orders.customer_id
WHERE orders.order_id IN (SELECT DISTINCT order_id FROM reviews);
";

// Fylla order_id kolumnens rader med data automatiskt i review-tabell baserat på customer_id (kolumn som finns i review-tabell
$query77 = "UPDATE reviews
JOIN orders ON reviews.customer_id = orders.customer_id
SET reviews.order_id = orders.order_id;
";

$query88 = "ALTER TABLE orders CHANGE orders_id order_id INT;";

// skapar resultat
$result = $connection->query($query1);


if ($result === false) {
    die("Fel vid SQL-frågan: " . $connection->error);
}

// loopa genom resultatet och visa
while ($row = $result->fetch_assoc()) {
    echo "Kundnamn: " . $row['customer_name'] . "<br>";
}



// check connection
if($connection->connect_error != null){
    die("Anslutningen misslyckades: " . $connection->connect_error);
}else{
    echo "Anslutningen lyckades.";
}



// stäng anslutningen till databasen
$connection->close();
    
?>

</body>
</html>