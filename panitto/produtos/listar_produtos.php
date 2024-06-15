<?php
include 'conexao.php';

$sql = "SELECT produtos.id, produtos.nome, produtos.descricao, produtos.preco, produtos.quantidade, categoria.nome as categoria_nome FROM produtos INNER JOIN categoria ON produtos.categoria_id = categoria.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["descricao"] . "</td>";
        echo "<td>R$ " . number_format($row["preco"], 2, ',', '.') . "</td>";
        echo "<td>" . $row["quantidade"] . "</td>";
        echo "<td>" . $row["categoria_nome"] . "</td>";
        echo "<td><button class='btn-editar' data-id='" . $row['id'] . "' data-nome='" . $row['nome'] . "' data-descricao='" . $row['descricao'] . "' data-preco='" . $row['preco'] . "' data-quantidade='" . $row['quantidade'] . "' data-categoria='" . $row['categoria_nome'] . "' onclick='editarProduto(" . $row['id'] . ", \"" . $row['nome'] . "\", \"" . $row['descricao'] . "\", \"" . $row['preco'] . "\", \"" . $row['quantidade'] . "\", \"" . $row['categoria_nome'] . "\")'>Editar</button> <button onclick=\"excluirProduto(" . $row['id'] . ")\">Excluir</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>Nenhum produto encontrado</td></tr>";
}
$conn->close();
?>