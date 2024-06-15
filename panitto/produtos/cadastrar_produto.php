<?php
include 'conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria_id = $_POST['categoria_id']; // Agora estamos recebendo o ID da categoria

    $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade, categoria_id) VALUES ('$nome', '$descricao', '$preco', '$quantidade', '$categoria_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
    $conn->close();
}
?>