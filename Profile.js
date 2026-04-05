document.addEventListener('DOMContentLoaded', () => {
    
    // --- HAMBURGER MENU LOGIC ---
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

    // --- UPDATE CART BADGE ---
    const updateBadge = () => {
        const cart = JSON.parse(localStorage.getItem('myCart')) || [];
        const total = cart.reduce((sum, item) => sum + item.qty, 0);
        const badge = document.getElementById('cart-badge');
        if (badge) badge.innerText = total;
    };
    updateBadge();

    // --- BUTTON CLICK EFFECTS (Visual feedback) ---
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', function() {
            if(this.classList.contains('btn-save')) {
                alert("Profile Information Saved Successfully!");
            }
        });
    });
});