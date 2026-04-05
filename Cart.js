document.addEventListener('DOMContentLoaded', () => {
    
    // --- NAVIGATION LOGIC ---
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const closeBtn = document.getElementById('close-btn');
    const sideNav = document.getElementById('side-nav');
    const overlay = document.getElementById('overlay');

    const toggleMenu = (isOpen) => {
        sideNav.classList.toggle('active', isOpen);
        overlay.classList.toggle('active', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    };

    hamburgerBtn?.addEventListener('click', () => toggleMenu(true));
    closeBtn?.addEventListener('click', () => toggleMenu(false));
    overlay?.addEventListener('click', () => toggleMenu(false));

    // --- CART KEY LOGIC (Kaniya-kaniyang Cart) ---
    // Kinukuha ang cartKey mula sa global variable sa cart.php. Fallback sa 'cart_guest' kung wala.
    const currentCartKey = (typeof cartKey !== 'undefined') ? cartKey : 'cart_guest';

    const cartItemsList = document.getElementById('cart-items-list');
    const subtotalDisplay = document.getElementById('subtotal-display');
    const vatDisplay = document.getElementById('vat-display'); 
    const discountDisplay = document.getElementById('discount-display'); 
    const totalDisplay = document.getElementById('total-display');

    // --- RENDER CART (SMOOTH UPDATE) ---
    const renderCart = () => {
        let cart = JSON.parse(localStorage.getItem(currentCartKey)) || [];
        cartItemsList.innerHTML = '';
        let subtotal = 0;
        let highestPrice = 0; 

        if (cart.length === 0) {
            cartItemsList.innerHTML = `
                <div class="empty-msg">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <p>Your cart is empty. <br> Add items from the Popular section below!</p>
                </div>`;
            updateTotals(0, 0);
            return;
        }

        cart.forEach((item) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            
            if (item.price > highestPrice) {
                highestPrice = item.price;
            }

            const safeName = item.name.replace(/'/g, "\\'"); 

            cartItemsList.innerHTML += `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <span class="u-price">@ PHP ${item.price.toFixed(2)}</span>
                    </div>
                    <div class="cart-controls">
                        <div>
                            <button class="btn-qty" onclick="changeQty('${safeName}', -1)"><i class="fa-solid fa-minus"></i></button>
                            <span class="qty-display">${item.qty}</span>
                            <button class="btn-qty" onclick="changeQty('${safeName}', 1)"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="item-total-price">
                        PHP ${itemTotal.toFixed(2)}
                    </div>
                </div>`;
        });
        updateTotals(subtotal, highestPrice);
    };

    const updateTotals = (subtotal, highestPrice) => {
        // Kunin ang status mula sa localStorage (na sinet ng PHP)
        const discountType = localStorage.getItem('userDiscountType') || 'None';
        
        let vatAmount = 0;
        let totalDiscount = 0;
        let finalTotal = 0;

        // Base computation: 12% VAT sa lahat
        const standardVat = subtotal * 0.12;

        if (discountType === 'Senior' || discountType === 'PWD') {
            // --- SENIOR/PWD CALCULATION (VAT EXEMPT + 20% OFF) ---
            
            // 1. VAT Exemption: Ang pinakamahal na item ay walang tax
            const vatExemption = highestPrice * 0.12;
            
            // 2. 20% Discount: Bawas sa base price ng pinakamahal na ulam
            const twentyPercentOff = highestPrice * 0.20;

            // VAT na babayaran na lang ay para sa ibang items
            vatAmount = standardVat - vatExemption;
            
            // Total na tipid (Tax saved + 20% discount)
            totalDiscount = vatExemption + twentyPercentOff;
            
            // Final Bill: (Pagkain + Tax) - Tipid
            finalTotal = (subtotal + standardVat) - totalDiscount;

            const discRow = document.getElementById('discount-row');
            if(discRow) discRow.style.display = 'flex';
        } else {
            // --- REGULAR CUSTOMER CALCULATION ---
            vatAmount = standardVat;
            totalDiscount = 0;
            finalTotal = subtotal + vatAmount;

            const discRow = document.getElementById('discount-row');
            if(discRow) discRow.style.display = 'none';
        }

        // Update Displays sa screen
        if(subtotalDisplay) subtotalDisplay.innerText = subtotal.toFixed(2);
        if(vatDisplay) vatDisplay.innerText = vatAmount.toFixed(2);
        if(discountDisplay) discountDisplay.innerText = totalDiscount.toFixed(2);
        if(totalDisplay) totalDisplay.innerText = finalTotal.toFixed(2);
        
        updateBadge();
    };

    window.changeQty = (name, amount) => {
        let cart = JSON.parse(localStorage.getItem(currentCartKey)) || [];
        const itemIndex = cart.findIndex(item => item.name === name);
        if (itemIndex > -1) {
            cart[itemIndex].qty += amount;
            if (cart[itemIndex].qty <= 0) {
                cart.splice(itemIndex, 1);
                showToast(`Removed ${name} from cart.`);
            }
        }
        localStorage.setItem(currentCartKey, JSON.stringify(cart));
        renderCart(); 
    };

    const updateBadge = () => {
        const cart = JSON.parse(localStorage.getItem(currentCartKey)) || [];
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        const badge = document.getElementById('cart-badge');
        if (badge) badge.innerText = totalItems;
    };

    window.addToCart = (name, price, img) => {
        let cart = JSON.parse(localStorage.getItem(currentCartKey)) || [];
        const existing = cart.find(i => i.name === name);
        
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ name, price, img, qty: 1 });
        }
        
        localStorage.setItem(currentCartKey, JSON.stringify(cart));
        renderCart(); 
        showToast(`Added ${name} to cart!`);
    };

    const showToast = (msg) => {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.innerText = msg;
            toast.style.visibility = 'visible';
            setTimeout(() => { toast.style.visibility = 'hidden'; }, 2000);
        }
    };

    renderCart();
});

// --- CHECKOUT LOGIC ---
const proceedBtn = document.getElementById('btn-proceed-checkout');
proceedBtn?.addEventListener('click', () => {
    let cart = JSON.parse(localStorage.getItem((typeof cartKey !== 'undefined' ? cartKey : 'cart_guest'))) || [];
    if (cart.length === 0) {
        const toast = document.getElementById('toast');
        if(toast) {
            toast.innerText = "Naku! Mag-add muna ng ulam bago mag-checkout.";
            toast.style.visibility = 'visible';
            setTimeout(() => { toast.style.visibility = 'hidden'; }, 2000);
        }
    } else {
        window.location.href = 'checkout.html';
    }
});

// Global addToCart para sa Popular Section buttons
function addToCart(name, price, img) {
    const currentCartKey = (typeof cartKey !== 'undefined') ? cartKey : 'cart_guest';
    let cart = JSON.parse(localStorage.getItem(currentCartKey)) || [];
    const existing = cart.find(i => i.name === name);
    if (existing) { existing.qty += 1; } 
    else { cart.push({ name, price, img, qty: 1 }); }
    
    localStorage.setItem(currentCartKey, JSON.stringify(cart));
    location.reload(); 
}