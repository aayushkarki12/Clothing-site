document.addEventListener('DOMContentLoaded', () => {
    const addToCartButton = document.querySelector('.normal');
    const proceedToCheckoutButton = document.querySelector('#cart-add button.normal');
    const esewaForm = document.getElementById('esewa-form');
    const esewaAmountField = document.getElementById('esewa-amount');
    const esewaTotalAmountField = document.getElementById('esewa-total-amount');

    if (addToCartButton) {
        addToCartButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default form submission

            const productId = document.querySelector('#main').src.split('/').pop().split('.')[0]; // Extract product ID from image src
            const size = document.querySelector('select').value;
            const quantity = document.querySelector('input[type="number"]').value;

            // Validate data
            if (size === 'Select Size' || quantity <= 0) {
                alert('Please select a valid size and quantity.');
                return;
            }

            // Make AJAX request
            fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId, size, quantity }),
            })
            .then(response => response.text()) // Change to .text() to debug response
            .then(text => {
                try {
                    const data = JSON.parse(text); // Parse response as JSON
                    if (data.success) {
                        alert('Product added to cart!');
                        // Optionally redirect to cart page
                        window.location.href = 'cart.html';
                    } else {
                        alert('Failed to add product to cart.');
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    alert('Received an unexpected response from the server.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to the cart.');
            });
        });
    } else {
        console.error('Add to Cart button not found.');
    }
    
    if (proceedToCheckoutButton) {
        proceedToCheckoutButton.addEventListener('click', function () {
            const totalAmount = parseFloat(document.getElementById('cart-total').innerText.replace('$', ''));
            esewaAmountField.value = totalAmount.toFixed(2);
            esewaTotalAmountField.value = totalAmount.toFixed(2);
            esewaForm.submit();
        });
    }
});