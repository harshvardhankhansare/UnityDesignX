const addToCartButtons = document.querySelectorAll('.add-to-cart');
const cart = document.querySelector('.cart');

addToCartButtons.forEach(button => {
  button.addEventListener('click', () => {
    const productName = button.getAttribute('data-product');
    cart.innerHTML += `<p>${productName}</p>`;
  });
});

const viewCartButton = document.querySelector('.view-cart');

viewCartButton.addEventListener('click', () => {
  alert('Cart Viewed');
});