<?php
// Conexão com o banco de dados (substitua com suas credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panitto";

// Obtém os dados enviados via POST (JSON)
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Dados inválidos."));
    exit;
}

$usuario_id = $data->usuario_id;
$valor_total = $data->valor_total;
$data_pedido = date("Y-m-d H:i:s"); // Data atual

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao conectar ao banco de dados: " . $conn->connect_error));
    exit;
}

// Prepara a query SQL para inserir o pedido
$sql = "INSERT INTO pedido (usuario_id, data, status, valor_total) VALUES (?, ?, 'Pendente', ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao preparar a declaração SQL: " . $conn->error));
    exit;
}

// Binda os parâmetros e executa a query
$stmt->bind_param("iss", $usuario_id, $data_pedido, $valor_total);
if ($stmt->execute()) {
    $pedido_id = $stmt->insert_id; // Obtém o ID do pedido inserido
    http_response_code(201); // Created
    echo json_encode(array("id" => $pedido_id));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao executar a query: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
