/**
 * KAINAN NI ATE KABAYAN - Checkout.js (FIXED VERSION)
 */

// --- HELPER: Kunin ang tamang Key ---
function getActiveCartKey() {
    // Kinukuha natin ang user_id kung meron (mula sa global variable na madalas mong gamitin)
    const userId = window.currentUserId || "";
    const userSpecificKey = userId ? 'cart_' + userId : null;

    if (localStorage.getItem('myCart')) return 'myCart';
    if (userSpecificKey && localStorage.getItem(userSpecificKey)) return userSpecificKey;
    if (typeof cartKey !== 'undefined') return cartKey;
    return 'cart_guest';
}

// --- 1. GLOBAL FUNCTIONS ---

window.placeOrder = function() {
    console.log(">>> Checkout Process Started...");

    const activePayBtn = document.querySelector('.pay-btn.active');
    const paymentMethod = activePayBtn ? activePayBtn.getAttribute('data-method') : 'Cash';
    
    const totalEl = document.getElementById('summary-total');
    if (!totalEl) {
        alert("Error: Hindi mahanap ang total price sa page.");
        return;
    }
    
    // Siguraduhing numero ang kinukuha para sa final total
    const finalTotal = parseFloat(totalEl.innerText.replace(/[^\d.-]/g, ''));

    const address = document.getElementById('display-text')?.innerText || "No address provided";
    const note = document.getElementById('delivery-note')?.value || "";
    const isPickup = document.getElementById('btn-pickup')?.classList.contains('active');

    const activeKey = getActiveCartKey();
    const cart = JSON.parse(localStorage.getItem(activeKey)) || [];

    if (cart.length === 0) {
        alert("Naku Kabayan, wala pang laman ang cart mo!");
        return;
    }

    if (paymentMethod === 'Card' || paymentMethod === 'E-Wallet') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'create_payment.php'; 

        const data = {
            'amount': finalTotal,
            'method': paymentMethod,
            'address': address,
            'note': note,
            'order_type': isPickup ? 'Pickup' : 'Delivery'
        };

        for (const key in data) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit(); 
    } else {
        window.location.href = `process_cash_order.php?total=${finalTotal}&address=${encodeURIComponent(address)}&note=${encodeURIComponent(note)}`;
    }
};

window.changeQtyCheckout = (name, amount) => {
    const activeKey = getActiveCartKey();
    let cart = JSON.parse(localStorage.getItem(activeKey)) || [];
    const idx = cart.findIndex(i => i.name === name);

    if (idx > -1) {
        // FIX: Gamitan ng parseInt para hindi mag-append bilang string (i.e., "1" + 1 = "11")
        let currentQty = parseInt(cart[idx].qty || 0);
        cart[idx].qty = currentQty + amount;

        if (cart[idx].qty <= 0) {
            cart.splice(idx, 1);
        }
    }
    localStorage.setItem(activeKey, JSON.stringify(cart));
    localStorage.setItem('myCart', JSON.stringify(cart));

    if (typeof window.triggerRender === 'function') {
        window.triggerRender();
    }
};

// --- 2. UI & CALCULATION LOGIC ---

document.addEventListener('DOMContentLoaded', () => {
    
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const sideNav = document.getElementById('side-nav');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-btn');

    const toggleMenu = (open) => {
        sideNav?.classList.toggle('active', open);
        overlay?.classList.toggle('active', open);
        document.body.style.overflow = open ? 'hidden' : 'auto';
    };

    hamburgerBtn?.addEventListener('click', () => toggleMenu(true));
    [closeBtn, overlay].forEach(el => el?.addEventListener('click', () => toggleMenu(false)));

    const renderSummary = () => {
        const activeKey = getActiveCartKey();
        const cart = JSON.parse(localStorage.getItem(activeKey)) || [];
        const container = document.getElementById('order-summary-list');
        
        if (!container) return;

        container.innerHTML = '';
        let subtotal = 0;

        if (cart.length === 0) {
            container.innerHTML = '<div style="text-align:center; padding:20px; color:#888;">Empty Cart</div>';
        }

        cart.forEach(item => {
            // FIX: Siguraduhing Numero ang price at qty para iwas NaN
            const price = parseFloat(String(item.price).replace(/[^\d.-]/g, '')) || 0;
            const qty = parseInt(item.qty) || 0;
            
            const itemTotal = price * qty;
            subtotal += itemTotal;
            const safeName = item.name.replace(/'/g, "\\'");

            container.innerHTML += `
                <div class="summary-item" style="display:flex; gap:15px; margin-bottom:15px; align-items:center; background:#fff; padding:12px; border-radius:15px; border:1px solid #eee;">
                    <img src="${item.img}" style="width:50px; height:50px; border-radius:10px; object-fit:cover;">
                    <div style="flex:1;">
                        <h4 style="font-size:0.9rem; margin:0;">${item.name}</h4>
                        <div style="display:flex; align-items:center; gap:10px; margin-top:5px;">
                             <button onclick="changeQtyCheckout('${safeName}', -1)" style="border:none; background:#f0f0f0; width:22px; height:22px; border-radius:5px; cursor:pointer;">-</button>
                             <span style="font-size:0.85rem; font-weight:700;">${qty}</span>
                             <button onclick="changeQtyCheckout('${safeName}', 1)" style="border:none; background:#f0f0f0; width:22px; height:22px; border-radius:5px; cursor:pointer;">+</button>
                        </div>
                    </div>
                    <span style="font-weight:800; color:#333;">₱${itemTotal.toFixed(2)}</span>
                </div>`;
        });

        const beneficiarySelect = document.getElementById('beneficiary-select');
        const isDelivery = document.getElementById('btn-delivery')?.classList.contains('active');
        let deliveryFee = isDelivery ? 79 : 0;
        
        let finalVat = subtotal * 0.12;
        let finalDiscount = 0;
        let finalTotal = subtotal + deliveryFee + finalVat;

        if (beneficiarySelect && beneficiarySelect.value !== "") {
            const vatExemptSales = subtotal / 1.12;
            const discountedAmount = vatExemptSales * 0.80;
            finalDiscount = subtotal - discountedAmount;
            finalVat = 0; 
            finalTotal = discountedAmount + deliveryFee;

            document.getElementById('discount-row').style.display = 'flex';
            document.getElementById('discount-display').innerText = finalDiscount.toFixed(2);
        } else {
            const discountRow = document.getElementById('discount-row');
            if(discountRow) discountRow.style.display = 'none';
        }

        // Final UI Update
        if(document.getElementById('summary-subtotal')) 
            document.getElementById('summary-subtotal').innerText = `PHP ${subtotal.toFixed(2)}`;
        if(document.getElementById('vat-display')) 
            document.getElementById('vat-display').innerText = `PHP ${finalVat.toFixed(2)}`;
        if(document.getElementById('summary-total')) 
            document.getElementById('summary-total').innerText = finalTotal.toFixed(2);
    };

    window.triggerRender = renderSummary;
    document.getElementById('beneficiary-select')?.addEventListener('change', renderSummary);

    const setupToggles = (selector) => {
        document.querySelectorAll(selector).forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll(selector).forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                renderSummary();
            });
        });
    };
    setupToggles('.opt-btn');
    setupToggles('.pay-btn');

    renderSummary();
});

const addressModal = document.getElementById('figmaModal');
const openModalBtn = document.getElementById('open-address-modal');
openModalBtn?.addEventListener('click', () => addressModal?.classList.add('active'));
document.getElementById('cancel-modal')?.addEventListener('click', () => addressModal?.classList.remove('active'));