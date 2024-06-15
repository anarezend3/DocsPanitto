<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: /panitto3%20/login/login.html");
    exit;
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padaria</title>
    <link rel="stylesheet" href="cadastrar_produtos.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="img/Panitto.png" alt="Logo da Padaria">
        </div>
    </header>

    <main>
        <section class="form-wrap">
            <h2>Cadastro de Produtos</h2>
            <form id="product-form">
                <input type="hidden" id="id" name="id">
                <input type="text" id="nome" name="nome" placeholder="Nome do Produto" required>
                <input type="text" id="descricao" name="descricao" placeholder="Descrição">
                <input type="number" id="preco" name="preco" placeholder="Preço" step="0.01" required>
                <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade" step="1" required>
                <select id="categoria_id" name="categoria_id" placeholder="Categoria">
                    <option value="1">Bolos</option>
                    <option value="2">Bebidas</option>
                    <option value="3">Doces</option>
                    <option value="4">Salgados</option>
                </select>
                <button type="button" id="btn-cadastrar" onclick="cadastrar()">Cadastrar</button>
                <button type="button" id="btn-salvar" style="display:block;" onclick="salvarEdicao()">Salvar</button>
            </form>
        </section>

        <div class="output">
            <h2>Lista de Produtos</h2>
            <table id="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço (R$)</th>
                        <th>Quantidade</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Dados da tabela serão preenchidos dinamicamente -->
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <button onclick="window.history.back()" class="back-button">Voltar</button>
    </footer>

    <script src="script.js"></script>
</body>
</html>