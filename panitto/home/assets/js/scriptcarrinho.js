if (document.readyState == 'loading') {
  document.addEventListener('DOMContentLoaded', ready)
} else {
  ready()
}

var totalAmount = "0,00"

function ready() {
  // Botão remover produto
  const removeCartProductButtons = document.getElementsByClassName("remove-product-button")
  for (var i = 0; i < removeCartProductButtons.length; i++) {
      removeCartProductButtons[i].addEventListener("click", removeProduct)
  }

  // Mudança valor dos inputs
  const quantityInputs = document.getElementsByClassName("product-qtd-input")
  for (var i = 0; i < quantityInputs.length; i++) {
      quantityInputs[i].addEventListener("change", checkIfInputIsNull)
  }

  // Botão add produto ao carrinho
  const addToCartButtons = document.getElementsByClassName("button-hover-background")
  for (var i = 0; i < addToCartButtons.length; i++) {
      addToCartButtons[i].addEventListener("click", adicionarAoCarrinho)
  }

  // Botão comprar
  const purchaseButton = document.getElementsByClassName("purchase-button")[0]
  purchaseButton.addEventListener("click", finalizarCompra) // Mudança: agora chama finalizarCompra diretamente
}

function removeProduct(event) {
  event.target.parentElement.parentElement.remove()
  updateTotal()
}

function checkIfInputIsNull(event) {
  if (event.target.value === "0") {
      event.target.parentElement.parentElement.remove()
  }

  updateTotal()
}

function adicionarAoCarrinho(nome, preco) {
  const productsCartNames = document.getElementsByClassName("cart-product-title");
  for (var i = 0; i < productsCartNames.length; i++) {
      if (productsCartNames[i].innerText === nome) {
          productsCartNames[i].parentElement.parentElement.getElementsByClassName("product-qtd-input")[0].value++;
          updateTotal();
          return;
      }
  }

  let newCartProduct = document.createElement("tr");
  newCartProduct.classList.add("cart-product");

  newCartProduct.innerHTML = `
      <td class="cart-product-title">${nome}</td>
      <td class="cart-product-price">R$ ${preco}</td>
      <td><input class="product-qtd-input" type="number" value="1" /></td>
      <td><button class="remove-product-button">Remover</button></td>
  `;

  const tableBody = document.querySelector(".cart-table tbody");
  tableBody.append(newCartProduct);
  updateTotal();

  newCartProduct.getElementsByClassName("remove-product-button")[0].addEventListener("click", removeProduct);
  newCartProduct.getElementsByClassName("product-qtd-input")[0].addEventListener("change", checkIfInputIsNull);
}


function finalizarCompra() {
  // Verifica se o carrinho está vazio
  const cartProducts = document.getElementsByClassName("cart-product");
  if (cartProducts.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
  }

  // Obtém o ID do usuário logado (hipoteticamente, assume-se que está autenticado)
  const usuarioId = 1; // Substitua pelo ID do usuário logado (pode ser obtido do contexto da sessão)

  // Calcula o valor total do pedido
  let totalAmountNumber = parseFloat(totalAmount.replace(",", ".")); // Converte o valor total para um número

  // Cria um novo pedido na tabela 'pedido'
  fetch('processar_pedido.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          usuario_id: usuarioId,
          valor_total: totalAmountNumber
      })
  })
  .then(response => response.json())
  .then(pedido => {
      const pedidoId = pedido.id; // Obtém o ID do pedido criado

      // Para cada produto no carrinho, insere um item de pedido na tabela 'itens_pedido'
      const itemsPromises = Array.from(cartProducts).map(cartProduct => {
          const productName = cartProduct.querySelector(".cart-product-title").innerText;
          const productPrice = parseFloat(cartProduct.querySelector(".cart-product-price").innerText.replace("R$", "").replace(",", "."));
          const productQuantity = parseInt(cartProduct.querySelector(".product-qtd-input").value);

          return fetch('processar_itens_pedido.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                  pedido_id: pedidoId,
                  produto_nome: productName,
                  quantidade: productQuantity,
                  preco_unitario: productPrice
              })
          });
      });

      // Executa todas as inserções dos itens do pedido em paralelo
      Promise.all(itemsPromises)
      .then(() => {
          // Limpa o carrinho e atualiza o total após finalizar a compra
          document.querySelector(".cart-table tbody").innerHTML = "";
          updateTotal();

          // Redireciona para a página card.html após a compra
          window.location.href = '../pagamento/card.html';
      })
      .catch(error => {
          console.error('Erro ao inserir itens do pedido:', error);
          alert('Houve um erro ao finalizar a compra. Por favor, tente novamente mais tarde.');
      });
  })
  .catch(error => {
      console.error('Erro ao criar pedido:', error);
      alert('Houve um erro ao finalizar a compra. Por favor, tente novamente mais tarde.');
  });
}

// Atualizar o valor total do carrinho
function updateTotal() {
  const cartProducts = document.getElementsByClassName("cart-product");
  totalAmount = 0;

  for (var i = 0; i < cartProducts.length; i++) {
      const productPrice = parseFloat(cartProducts[i].getElementsByClassName("cart-product-price")[0].innerText.replace("R$", "").replace(",", "."));
      const productQuantity = parseInt(cartProducts[i].getElementsByClassName("product-qtd-input")[0].value);

      totalAmount += productPrice * productQuantity;
  }

  totalAmount = totalAmount.toFixed(2);
  totalAmount = totalAmount.replace(".", ",");
  document.querySelector(".cart-total-container span").innerText = "R$" + totalAmount;
}
