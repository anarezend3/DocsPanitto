'use strict';

// Selecione o botão de login
const loginButton = document.getElementById('loginButton');

// Adicione um evento de clique ao botão
loginButton.addEventListener('click', function() {
  // Redirecione o navegador para a página de login
  window.location.href = '../login/cadastro.html';
});


/**
 * Adiciona um evento a um elemento ou a uma lista de elementos
 * @param {Element|NodeList} elem - O elemento HTML ou lista de elementos HTML aos quais o evento será adicionado
 * @param {string} type - O tipo de evento a ser adicionado (por exemplo, 'click', 'mouseover', etc.)
 * @param {Function} callback - A função a ser executada quando o evento ocorrer
 */
const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
}

/**
 * Toggle da barra de navegação
 */
const navToggler = document.querySelector("[data-nav-toggler]");
const navbar = document.querySelector("[data-navbar]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  navToggler.classList.toggle("active");
}

addEventOnElem(navToggler, "click", toggleNavbar);

const closeNavbar = function () {
  navbar.classList.remove("active");
  navToggler.classList.remove("active");
}

addEventOnElem(navbarLinks, "click", closeNavbar);

/**
 * Ativa o cabeçalho quando a rolagem atinge 100px
 */
const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

const activeElemOnScroll = function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
    backTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    backTopBtn.classList.remove("active");
  }
}

addEventOnElem(window, "scroll", activeElemOnScroll);

/**
 * Função para buscar e exibir os produtos
 */
function exibirProdutos() {
  fetch('get_produtos.php')
    .then(response => response.json())
    .then(produtos => {
      const productList = document.getElementById('product-list');
      productList.innerHTML = ''; // Limpa a lista de produtos antes de adicionar os novos

      produtos.forEach(produto => {
        const li = document.createElement('li');
        li.innerHTML = `
          <div class="product-card">
            <div class="card-banner img-holder" style="--width: 100; --height: 100;">
              <img src="./assets/images/produtos/${produto.nome}.png" alt="${produto.nome}" class="img-cover default">
              <img src="./assets/images/produtos/${produto.nome}.png" width="360" height="360" loading="lazy" alt="Etiam commodo leo sed" class="img-cover hover">
              <button class="card-action-btn" aria-label="add to card" title="Add To Card" onclick="adicionarAoCarrinho('${produto.nome}', ${produto.preco})">
                <ion-icon name="bag-add-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
            <div class="card-content">
              <div class="wrapper">
                <div class="rating-wrapper gray">
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                </div>
                <span class="span">(0)</span>
              </div>
              <h3 class="h3">
                <a href="#" class="card-title">${produto.nome}</a>
              </h3>
              <data class="card-price" value="${produto.preco}">R$ ${produto.preco}</data>
            </div>
          </div>
        `;
        productList.appendChild(li);
      });
    })
    .catch(error => console.error('Erro ao buscar produtos:', error));
}

// Chama a função para exibir os produtos quando a página carrega
window.onload = exibirProdutos;
