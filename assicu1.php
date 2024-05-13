<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "verifica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connessione al database fallita: " . $conn->connect_error);
}

$codice_tipo_polizza = $_GET['codice_tipo_polizza'];

$sql = "SELECT assicurato.nome_assicurato, assicuratore.nominativo_assicuratore
        FROM premi
        INNER JOIN paga ON premi.codice_premio = paga.codice_premio
        INNER JOIN assicurato ON paga.codice_assicurato = assicurato.codice_assicurato
        INNER JOIN assicuratore ON premi.codice_assicuratore = assicuratore.codice_assicuratore
        WHERE premi.codice_tipo_polizza = $codice_tipo_polizza
        ORDER BY assicurato.nome_assicurato";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "Assicurato: " . $row["nome_assicurato"]. " - Assicuratore: " . $row["nominativo_assicuratore"]. "<br>";
  }
} else {
  echo "Nessun risultato trovato";
}

$conn->close();
?>
