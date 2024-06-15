<?php
// Verifica se os dados foram submetidos através do formulário de avaliação
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos necessários estão presentes
    if (isset($_POST['rating']) && isset($_POST['opinion']) && isset($_POST['id'])) {
        // Sua lógica de conexão com o banco de dados e inserção de dados aqui
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "panitto";

        // Conexão com o banco de dados
        $conn = new mysqli($servername, $username, $password, $database);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Prepara os dados para inserção na tabela de avaliação
        $id = $_POST['id']; // Aqui usamos 'id' em vez de 'produto_id'
        $usuario_id = 1; // Suponha que o ID do usuário seja 1 por enquanto
        $rating = $_POST['rating'];
        $opinion = $_POST['opinion'];
        $data_avaliacao = date("Y-m-d H:i:s");

        // Insere os dados na tabela de avaliação
        $sql = "INSERT INTO avaliacao (id, usuario_id, rating, opinion, data_avaliacao) 
                VALUES ('$id', '$usuario_id', '$rating', '$opinion', '$data_avaliacao')";

        if ($conn->query($sql) === TRUE) {
            // Atualiza o número de avaliações e a média das avaliações na tabela de produtos
            $sql_update = "UPDATE produtos SET 
                           numero_avaliacoes = numero_avaliacoes + 1,
                           media_avaliacoes = (media_avaliacoes * (numero_avaliacoes - 1) + $rating) / numero_avaliacoes
                           WHERE id = $id";

            if ($conn->query($sql_update) === TRUE) {
                echo "Avaliação registrada com sucesso! Você será redirecionado!";
                echo "<script>setTimeout(function(){ window.location.href = '../home/index.html'; }, 3000);</script>";
                exit();

            } else {
                echo "Erro ao atualizar as informações do produto: " . $conn->error;
            }
        } else {
            echo "Erro ao registrar a avaliação: " . $conn->error;
        } 

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "Todos os campos devem ser preenchidos.";
    }
} else {
    echo "Acesso inválido.";
}
?>