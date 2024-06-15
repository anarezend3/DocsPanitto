<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panitto";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter os indicadores
$sql = "SELECT COUNT(*) AS totalUsuarios FROM usuarios";
$result = $conn->query($sql);

// Verifica se a consulta foi bem sucedida
if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

// Obtém os dados da consulta
$row = $result->fetch_assoc();
$totalUsuarios = $row['totalUsuarios'];

// Fechar conexão
$conn->close();

// Retorna os dados como JSON
echo json_encode(['totalUsuarios' => $totalUsuarios]);
?>
