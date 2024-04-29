document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartItemsList = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const showBillButton = document.getElementById('show-bill-btn');
    const confirmButton = document.getElementById('confirm_bt');
    const cancelButton = document.getElementById('cancel_bt');
    const couponCodeInput = document.querySelector('.coupon-code');
    const couponMessageYes = document.querySelector('.yes');
    const couponMessageNo = document.querySelector('.no');
    
    let totalPrice = 0;
    let cartItems = {};
    let selectedDrinks = []; // Array to store names of selected drinks

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const product = button.parentElement;
            const productName = product.querySelector('h2').innerText;
            const productPriceText = product.querySelector('.price').innerText;
            const productPrice = parseFloat(productPriceText.replace('Rs. ', ''));
            const quantity = parseInt(product.querySelector('.quantity').innerText);

            if (quantity > 0) {
                if (cartItems[productName]) {
                    cartItems[productName].count = quantity;
                } else {
                    cartItems[productName] = {
                        price: productPrice,
                        count: quantity
                    };
                    selectedDrinks.push(productName); // Add selected drink to array
                }
            }

            updateCartView(); 
        });
    });

    showBillButton.addEventListener('click', function(){
        document.querySelector('.total').style.display = 'block';
        document.querySelector('.confirm').style.display = 'flex';
        calculateTotalPrice();
    })

    confirmButton.addEventListener('click', function() {
        const selectedDrinksString = selectedDrinks.join(', ');

        // Send data to PHP using fetch
        fetch('process_bill.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'selectedDrinks=' + selectedDrinksString + '&totalPrice=' + totalPrice
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log(data);
            window.location.href = './profile.php';
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });

    cancelButton.addEventListener('click', function(){
        window.location.href = './drinks.php';
    });
    function updateCartView() {
        cartItemsList.innerHTML = '';
        for (const itemName in cartItems) {
            const item = cartItems[itemName];
            const cartItem = document.createElement('li');
            cartItem.classList.add('cart-item');
            cartItem.innerText = `${itemName} - Rs. ${item.price.toFixed(2)} x ${item.count}`;
            cartItemsList.appendChild(cartItem);
        }
    }

    function calculateTotalPrice() {
        totalPrice = 0;
        for (const itemName in cartItems) {
            const item = cartItems[itemName];
            totalPrice += item.price * item.count;
        }
        
        // Check if coupon code is applied
        if (couponCodeInput.value.trim() === 'CO50') {
            totalPrice -= 50;
            couponMessageYes.style.display = 'block';
            couponMessageNo.style.display = 'none';
        }
        if(couponCodeInput.value.trim() === ""){
            couponMessageYes.style.display = 'none';
            couponMessageNo.style.display = 'none';
        } 
        
        else {
            couponMessageYes.style.display = 'none';
            couponMessageNo.style.display = 'block';
        }
        
        if (totalPrice < 0) {
            totalPrice = 0;
        }
        totalPriceElement.innerText = totalPrice.toFixed(2);
    }

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = button.getAttribute('data-action');
            const quantityElement = button.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantityElement.innerText);
            if (action === 'decrease' && quantity > 0) {
                quantity--;
            } else if (action === 'increase') {
                quantity = Math.min(quantity + 1, 99);
            }
            quantityElement.innerText = quantity;
        });
    });
});