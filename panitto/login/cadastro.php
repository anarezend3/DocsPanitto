<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "panitto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nome = $conn->real_escape_string($_POST["nome"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $senha = password_hash($conn->real_escape_string($_POST["senha"]), PASSWORD_DEFAULT);
    $tipo = $conn->real_escape_string($_POST["tipo"]); // Captura o tipo de usuário selecionado

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header("Location: login.html");
    exit;
}
?>
