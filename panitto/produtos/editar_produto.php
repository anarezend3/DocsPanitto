<?php
include 'conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria_id = $_POST['categoria_id']; // Supondo que você esteja recebendo o ID da categoria

    // Executar a atualização no banco de dados
    $sql_update = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco', quantidade='$quantidade', categoria_id='$categoria_id' WHERE id=$id";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "Produto atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar produto: " . $conn->error;
    }
} else {
    echo "Método inválido.";
}

$conn->close();
?>