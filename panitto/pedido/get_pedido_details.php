<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "panitto";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID do pedido foi enviado
if (isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];

    // Consulta SQL para obter os detalhes do pedido
    $sql = "SELECT ip.id, p.nome, ip.quantidade, ip.preco_unitario 
            FROM itens_pedido ip 
            INNER JOIN produtos p ON ip.produto_id = p.id 
            WHERE ip.pedido_id = $pedido_id";
    
    $result = $conn->query($sql);

    $pedido_items = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pedido_items[] = $row;
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

    // Retorna os detalhes do pedido em formato JSON
    echo json_encode($pedido_items);
}
?>
