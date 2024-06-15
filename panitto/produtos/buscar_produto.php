<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        echo json_encode($produto);
    } else {
        echo "Produto não encontrado.";
    }

    $conn->close();
}
?>