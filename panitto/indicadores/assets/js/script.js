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


// Função para adicionar um produto ao carrinho
const adicionarAoCarrinho = function (produtoNome, produtoPreco) {
  let carrinho = localStorage.getItem('carrinho');
  if (!carrinho) {
    carrinho = [];
  } else {
    carrinho = JSON.parse(carrinho);
  }
  carrinho.push({ nome: produtoNome, preco: produtoPreco });
  localStorage.setItem('carrinho', JSON.stringify(carrinho));
  alert('Produto adicionado ao carrinho!');
}

// Chama a função para exibir os produtos quando a página carrega
window.onload = exibirProdutos;

document.addEventListener("DOMContentLoaded", function() {
  // Função para buscar e exibir os indicadores
  function exibirIndicadores() {
      fetch('indicadores.php')
          .then(response => response.json())
          .then(data => {
              // Atualizar os valores dos indicadores nos elementos HTML correspondentes
              document.getElementById('indicator1').textContent = data.totalUsuarios;
          })
          .catch(error => console.error('Erro ao buscar indicadores:', error));
  }

  // Chamar a função para exibir os indicadores quando a página carrega
  exibirIndicadores();
});
