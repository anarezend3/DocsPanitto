<?php
$servername = "localhost"; // Substitua com seu servidor
$username = "root"; // Substitua com seu nome de usuário do banco de dados
$password = ""; // Substitua com sua senha do banco de dados
$dbname = "panitto";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nome, descricao, preco, quantidade, categoria_id FROM produtos";
$result = $conn->query($sql);

$produtos = array();

if ($result->num_rows > 0) {
    // Output data de cada linha
    while($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    echo "0 resultados";
}
$conn->close();

echo json_encode($produtos);
?>
