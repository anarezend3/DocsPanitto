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

$pedido_id = $data->pedido_id;
$produto_nome = $data->produto_nome;
$quantidade = $data->quantidade;
$preco_unitario = $data->preco_unitario;

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao conectar ao banco de dados: " . $conn->connect_error));
    exit;
}

// Obtém o ID do produto pelo nome
$sql_produto = "SELECT id FROM produtos WHERE nome = ?";
$stmt_produto = $conn->prepare($sql_produto);
$stmt_produto->bind_param("s", $produto_nome);
$stmt_produto->execute();
$result_produto = $stmt_produto->get_result();

if ($result_produto->num_rows > 0) {
    $produto = $result_produto->fetch_assoc();
    $produto_id = $produto['id'];
} else {
    http_response_code(404); // Not Found
    echo json_encode(array("message" => "Produto não encontrado."));
    exit;
}

$stmt_produto->close();

// Prepara a query SQL para inserir o item do pedido
$sql = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao preparar a declaração SQL: " . $conn->error));
    exit;
}

// Binda os parâmetros e executa a query
$stmt->bind_param("iiid", $pedido_id, $produto_id, $quantidade, $preco_unitario);
if ($stmt->execute()) {
    http_response_code(201); // Created
    echo json_encode(array("message" => "Item do pedido criado com sucesso."));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Erro ao executar a query: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
