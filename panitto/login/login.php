<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["senha"])) {
        $conexao = new mysqli("localhost", "root", "", "panitto");
        
        if ($conexao->connect_error) {
            die("Erro na conexão: " . $conexao->connect_error);
        }
        
        $email = $conexao->real_escape_string($_POST["email"]);
        $senha = $_POST["senha"];
        
        $sql = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $resultado = $sql->get_result();
        
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo']; // Armazena o tipo de usuário na sessão
                
                if ($usuario['tipo'] == 'admin') {
                    header("Location: /panitto3%20/admin/produtos/cadastrar_produtos.php"); // Redireciona para página de admin
                } else {
                    header("Location: /panitto/home/"); // Redireciona para página de cliente
                }
                exit;
            } else {
                echo "E-mail ou senha incorretos.";
            }
        } else {
            echo "E-mail ou senha incorretos.";
        }
        
        $conexao->close();
    }
}
?>
