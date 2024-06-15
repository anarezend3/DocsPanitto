// Função para buscar os produtos do pedido
function buscarProdutosPedido(pedido_id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("product-list").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "listar_produtos_pedido.php?pedido_id=" + pedido_id, true);
    xhr.send();
}

// Chamar a função para buscar os produtos do pedido assim que a página carregar
window.onload = function() {
    // Supondo que o ID do pedido é passado como parâmetro na URL
    var urlParams = new URLSearchParams(window.location.search);
    var pedido_id = urlParams.get('pedido_id');
    buscarProdutosPedido(pedido_id);
};
