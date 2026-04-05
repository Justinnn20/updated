document.addEventListener('DOMContentLoaded', () => {
    
    // --- PART A: INITIALIZATION (Tandaan ang original pwesto) ---
    const menuWrapper = document.querySelector('.menu-scroll-wrapper');
    const allCards = document.querySelectorAll('.menu-card-scroll');
    
    // Binibigyan natin ng "number" ang bawat card (0, 1, 2, 3...)
    allCards.forEach((card, index) => {
        card.setAttribute('data-original-order', index);
    });

    // --- PART B: HAMBURGER & SIDE NAV LOGIC ---
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


    // --- PART C: REORDER FUNCTION (Ang magic para sa sorting) ---
    const reorderCards = () => {
        const cardsArray = Array.from(allCards);

        cardsArray.sort((a, b) => {
            const isFavA = a.querySelector('.btn-heart').classList.contains('active');
            const isFavB = b.querySelector('.btn-heart').classList.contains('active');
            const orderA = parseInt(a.getAttribute('data-original-order'));
            const orderB = parseInt(b.getAttribute('data-original-order'));

            // 1. Kung parehong favorite o parehong hindi, base sa original order ang pwesto
            if (isFavA === isFavB) {
                return orderA - orderB;
            }
            // 2. Kung magkaiba, unahin ang favorite (A ang mauuna kung True siya)
            return isFavA ? -1 : 1;
        });

        // I-append ulit sa wrapper base sa bagong order
        cardsArray.forEach(card => menuWrapper.appendChild(card));
    };


    // --- PART D: CLICK DELEGATION (Add to Cart & Heart) ---
    document.addEventListener('click', (e) => {
        
        // --- Logic para sa Add to Cart ---
        const addBtn = e.target.closest('.btn-add-cart');
        if (addBtn) {
            e.preventDefault();
            const card = addBtn.closest('.menu-card-scroll');
            const name = card.querySelector('h3').innerText;
            const priceText = card.querySelector('.price-badge').innerText;
            const price = parseFloat(priceText.replace('₱', ''));
            const img = card.querySelector('img').src;

            let cart = JSON.parse(localStorage.getItem('myCart')) || [];
            const existingItem = cart.find(item => item.name === name);

            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ name, price, img, qty: 1 });
            }

            localStorage.setItem('myCart', JSON.stringify(cart));
            updateBadge();
            showToast(`Added ${name} to cart!`);
        }

        // --- Logic para sa Favorite Button ---
        const heartBtn = e.target.closest('.btn-heart');
        if (heartBtn) {
            e.preventDefault();
            heartBtn.classList.toggle('active');
            
            const icon = heartBtn.querySelector('i');
            if (heartBtn.classList.contains('active')) {
                icon.classList.replace('fa-regular', 'fa-solid');
            } else {
                icon.classList.replace('fa-solid', 'fa-regular');
            }

            // PAGKATAPOS MAG-TOGGLE, I-REORDER NA!
            reorderCards();
        }
    });

    // --- UTILITIES (Badge & Toast) ---
    const updateBadge = () => {
        const cart = JSON.parse(localStorage.getItem('myCart')) || [];
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        const badge = document.getElementById('cart-badge');
        if (badge) badge.innerText = totalItems;
    };

    function showToast(message) {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.innerText = message;
            toast.style.visibility = 'visible';
            setTimeout(() => { toast.style.visibility = 'hidden'; }, 3000);
        }
    }

    updateBadge(); // Initial badge load
});