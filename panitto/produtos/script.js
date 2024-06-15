function cadastrar() {
    var form = document.getElementById("product-form");
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            buscarProdutos(); // Atualizar lista de produtos após o cadastro
            form.reset(); // Limpar o formulário após o cadastro
        }
    };
    xhr.open("POST", "cadastrar_produto.php", true);
    xhr.send(formData);
}

function buscarProdutos() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("product-list").innerHTML = xhr.responseText;
            // Adicionar onclick para o botão Editar em cada linha da tabela
            var editButtons = document.querySelectorAll('.btn-editar');
            editButtons.forEach(function(button) {
                button.onclick = function() {
                    var id = button.dataset.id;
                    var nome = button.dataset.nome;
                    var descricao = button.dataset.descricao;
                    var preco = button.dataset.preco;
                    var quantidade = button.dataset.quantidade;
                    var categoria = button.dataset.categoria;
                    editarProduto(id, nome, descricao, preco, quantidade, categoria);
                }
            });
        }
    };
    xhr.open("GET", "listar_produtos.php", true);
    xhr.send();
}

function excluirProduto(id) {
    if (confirm("Tem certeza que deseja excluir este produto?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                buscarProdutos(); // Atualizar lista de produtos após a exclusão
            }
        };
        xhr.open("GET", "excluir_produto.php?id=" + id, true);
        xhr.send();
    }
}

// Carregar lista de produtos ao carregar a página
window.onload = function() {
    buscarProdutos();
};

function editarProduto(id, nome, descricao, preco, quantidade, categoria) {
    console.log("Editar produto", id, nome, descricao, preco, quantidade, categoria);

    document.getElementById("id").value = id;
    document.getElementById("nome").value = nome;
    document.getElementById("descricao").value = descricao;
    document.getElementById("preco").value = preco;
    document.getElementById("quantidade").value = quantidade;
    document.getElementById("categoria").value = categoria;
    
    // Mostrar botão Salvar
    document.getElementById("btn-salvar").style.display = "block";
}

function salvarEdicao() {
    var form = document.getElementById("product-form");
    var id = document.getElementById("id").value;
    var nome = document.getElementById("nome").value;
    var descricao = document.getElementById("descricao").value;
    var preco = document.getElementById("preco").value;
    var quantidade = document.getElementById("quantidade").value;
    var categoria = document.getElementById("categoria").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            buscarProdutos(); // Atualizar lista de produtos após a edição
            form.reset(); // Limpar o formulário após a edição
            document.getElementById("btn-salvar").style.display = "none"; // Esconder o botão Salvar
        }
    };
    xhr.open("POST", "editar_produto.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id + "&nome=" + encodeURIComponent(nome) + "&descricao=" + encodeURIComponent(descricao) + "&preco=" + preco + "&quantidade=" + quantidade + "&categoria=" + encodeURIComponent(categoria));
}
